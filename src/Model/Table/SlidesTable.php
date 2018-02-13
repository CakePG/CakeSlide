<?php
namespace CakePG\CakeSlide\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use Cake\Core\Configure;

class SlidesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->addBehavior('CakePG/CakeSlide.ImageTransformer');
        $this->addBehavior('CakePG/CakeSlide.SortPriority');
        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'file' => [
                'nameCallback' => function(array $data, array $opts) {
                    $ext = substr(strrchr($data['name'], '.'), 1);
                    return str_replace('-', '', Text::uuid()).'.'.$ext;
                },
                'fields' => [
                    'dir' => 'dir',
                    'size' => 'size',
                    'type' => 'type',
                ],
                'filesystem' => [
                    'root' => '/',
                ],
                'transformer' =>  function ($table, $entity, $data, $field, $settings) {
                    $extension = pathinfo($data['name'], PATHINFO_EXTENSION);
                    $tmp = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;
                    $type = $entity->file['type'];

                    // 画像でなければスキップ
                    if (!($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/bmp')) {
                      return [$data['tmp_name'] => $data['name']];
                    }

                    $setting = Configure::read('CakeSlide.image');
                    // 画像加工
                    $tmp = $this->imageTransformer($data, $type, $setting, $tmp);
                    return [
                        $tmp => $data['name']
                    ];
                },
                'path' => STORAGE.'{model}{DS}',
                'keepFilesOnDelete' => false,
            ],
        ]);
    }

    public function beforeSave($event, $entity, $options)
    {
        // 新規の場合に名前を追加
        if ($original = $entity->getOriginal('file')) {
            if (!empty($original['name']) && empty($entity->name)) $entity->name = $original['name'];
        }
        // 画像でmaskを使ってる場合はpngに変換する
        if (($entity->type == 'image/jpeg' || $entity->type == 'image/png' || $entity->type == 'image/bmp') && Configure::read('CakeSlide.image.mask')) {
            $entity->type = 'image/png';
        }
        return true;
    }
    public function validationDefault(Validator $validator)
    {
        return $validator->provider('upload', \Josegonzalez\Upload\Validation\UploadValidation::class)
            ->add('file', 'fileUnderPhpSizeLimit', [
                'rule' => 'isUnderPhpSizeLimit',
                'message' => 'サーバーで許可されていないファイルサイズです。',
                'provider' => 'upload'
            ])
            ->add('file', 'fileUnderFormSizeLimit', [
                'rule' => 'isUnderFormSizeLimit',
                'message' => 'フォームで許可されていないファイルサイズです。',
                'provider' => 'upload'
            ])
            ->add('file', 'fileBelowMaxSize', [
                'rule' => ['isBelowMaxSize', 5000000],
                'message' => 'ファイルサイズ制限の5MBを超えています。',
                'provider' => 'upload'
            ])
            ->add('file', 'file', [
                'rule' => ['mimeType', [
                    'image/jpeg',
                    'image/png',
                    'image/bmp',
                    'image/gif'
                ]],
                'message' => '許可されていないファイルタイプです。',
                'on' => function ($context) {
                    return !empty($context['data']['file']['type']);
                }
            ])
            ->notEmpty('file')
            ->requirePresence('file', 'create');
    }
}
