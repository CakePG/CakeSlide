<?php
namespace CakePG\CakeSlide\Controller\Admin;

use CakePG\CakeSlide\Controller\AppController;
use Cake\Core\Configure;

class SlidesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $slides = $this->paginate($this->Slides, [
            'order' => ['priority' => 'asc']
        ]);
        $this->set(compact('slides'));
        $this->set('_serialize', ['slides']);
    }

    public function view($id = null)
    {
        $slide = $this->Slides->get($id);
        $this->set(compact('slide'));
        $this->set('_serialize', ['slide']);
    }

    public function add()
    {
        $slide = $this->Slides->newEntity();
        if ($this->request->is('post')) {
            $priority = $this->Slides->find('all')->count();
            $slide = $this->Slides->patchEntity($slide, $this->request->data + ['priority' => $priority]);
            if ($this->Slides->save($slide)) {
                // ソート処理
                $orders = array_values($this->Slides->find('list', ['valueField' => 'id', 'order' => ['priority' => 'asc']])->toArray());
                $this->Slides->sortPriority($orders);
                $this->Flash->success(__d('CakeSlide', 'Slide').'を登録しました');
                return $this->redirect(['action' => 'view', $slide->id]+$this->request->query());
            }
            $this->Flash->error(__d('CakeSlide', 'Slide').'の登録に失敗しました。もう一度お試しください');
        }
        $this->set('imageSetting', Configure::read('CakeSlide.image'));
        $this->set(compact('slide'));
        $this->set('_serialize', ['slide']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $slide = $this->Slides->get($id);
        try {
          if ($this->Slides->delete($slide)) {
              // ソート処理
              $orders = array_values($this->Slides->find('list', ['valueField' => 'id', 'order' => ['priority' => 'asc']])->toArray());
              $this->Slides->sortPriority($orders);
              $this->Flash->success(__d('CakeSlide', 'Slide').'を削除しました');
          } else {
              $this->Flash->error(__d('CakeSlide', 'Slide').'の削除に失敗しました。もう一度お試しください');
          }
        } catch (\Exception $e) {
          $this->Flash->error("不明なエラーが発生しました");
        }
        return $this->redirect(['action' => 'index']+$this->request->query());
    }

    // 並び替え
    public function sort()
    {
        $slides = $this->Slides->find('all', ['order' => ['priority' => 'asc']]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orders = explode(',',$this->request->data['orders']);
            if ($this->Slides->sortPriority($orders)) {
                $this->Flash->success(__d('CakeSlide', 'Slide').'の順序を変更しました');
                return $this->redirect(['action' => 'index']+$this->request->query());
            } else {
                $this->Flash->error(__d('CakeSlide', 'Slide').'の順序の変更に失敗しました。もう一度お試しください');
            }
        }
        $this->set(compact('slides'));
        $this->set('_serialize', ['slides']);
    }
}
