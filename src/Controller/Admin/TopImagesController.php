<?php
namespace CakePG\CakeSlide\Controller\Admin;

use CakePG\CakeNews\Controller\AppController;
use Cake\Core\Configure;

class TopImagesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $topImages = $this->paginate($this->TopImages, [
            'order' => ['priority' => 'asc']
        ]);
        $this->set(compact('topImages'));
        $this->set('_serialize', ['topImages']);
    }

    public function view($id = null)
    {
        $topImage = $this->TopImages->get($id);
        $this->set(compact('topImage'));
        $this->set('_serialize', ['topImage']);
    }

    public function add()
    {
        $topImage = $this->TopImages->newEntity();
        if ($this->request->is('post')) {
            $priority = $this->TopImages->find('all')->count();
            $topImage = $this->TopImages->patchEntity($topImage, $this->request->data + ['priority' => $priority]);
            if ($this->TopImages->save($topImage)) {
                // ソート処理
                $orders = array_values($this->TopImages->find('list', ['valueField' => 'id', 'order' => ['priority' => 'asc']])->toArray());
                $this->TopImages->sortPriority($orders);
                $this->Flash->success(__d('CakeSlide', 'Top Slide').'を登録しました');
                return $this->redirect(['action' => 'view', $topImage->id]+$this->request->query());
            }
            $this->Flash->error(__d('CakeSlide', 'Top Slide').'の登録に失敗しました。もう一度お試しください');
        }
        $this->set('imageSetting', Configure::read('CakeSlide.image'));
        $this->set(compact('topImage'));
        $this->set('_serialize', ['topImage']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $topImage = $this->TopImages->get($id);
        try {
          if ($this->TopImages->delete($topImage)) {
              // ソート処理
              $orders = array_values($this->TopImages->find('list', ['valueField' => 'id', 'order' => ['priority' => 'asc']])->toArray());
              $this->TopImages->sortPriority($orders);
              $this->Flash->success(__d('CakeSlide', 'Top Slide').'を削除しました');
          } else {
              $this->Flash->error(__d('CakeSlide', 'Top Slide').'の削除に失敗しました。もう一度お試しください');
          }
        } catch (\Exception $e) {
          $this->Flash->error("不明なエラーが発生しました");
        }
        return $this->redirect(['action' => 'index']+$this->request->query());
    }

    // 並び替え
    public function sort()
    {
        $topImages = $this->TopImages->find('all', ['order' => ['priority' => 'asc']]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orders = explode(',',$this->request->data['orders']);
            if ($this->TopImages->sortPriority($orders)) {
                $this->Flash->success(__d('CakeSlide', 'Top Slide').'の順序を変更しました');
                return $this->redirect(['action' => 'index']+$this->request->query());
            } else {
                $this->Flash->error(__d('CakeSlide', 'Top Slide').'の順序の変更に失敗しました。もう一度お試しください');
            }
        }
        $this->set(compact('topImages'));
        $this->set('_serialize', ['topImages']);
    }
}
