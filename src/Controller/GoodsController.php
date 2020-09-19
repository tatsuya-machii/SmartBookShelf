<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Goods Controller
 *
 * @property \App\Model\Table\GoodsTable $Goods
 * @method \App\Model\Entity\Good[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GoodsController extends AppController
{
  // コントローラー名以外のモデルを使用する場合はloadModelでモデルを読み込む必要がある。
  // このクラス全体で使用するため、initializeメソッドに記述する。
  public function initialize():void
  {
    parent::initialize();
    $this->loadModel('Users');
    $this->loadModel('Posts');
  }

  // ページネーションのオプション設定
  public $paginate = [
    'order' => [
      'created' => 'desc'
    ],
    'contain' => ['Users', 'Posts']
  ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id=null)
    {

        $goods = $this->paginate($this->Goods->find()->Where(['post_id'=>$id]));

        $this->set(compact('goods'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Good id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $good = $this->Goods->get($id);
        if ($this->Goods->delete($good)) {
            $this->Flash->success(__('The good has been deleted.'));
        } else {
            $this->Flash->error(__('The good could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }





  public function add()
  {
    //CakePHPのレンダー機能を無効化する
    $this->autoRender = false;

    $good = $this->Goods->newEmptyEntity();
    //Ajax通信か判定する
    if ($this->request->is('ajax')) {

      $good = $this->Goods->patchEntity($good, $this->request->getData());
      if ($this->Goods->save($good)) {
        $query = $this->Goods->find()->Where(['post_id'=> $this->request->getData('post_id')]);
        $count = $query->count();
        echo $count;
      }else{
        $this->Flash->error(__('The good could not be saved. Please, try again.'));
      }
    }
  }


    public function ajaxDelete()
    {
      //CakePHPのレンダー機能を無効化する
      $this->autoRender = false;

      //Ajax通信か判定する
      if ($this->request->is('ajax')) {

        if ($this->Goods->deleteAll(['post_id'=>$this->request->getData('post_id')])) {
          $query = $this->Goods->find()->Where(['user_id'=>$this->request->getData('user_id'), 'post_id'=>$this->request->getData('post_id')]);
          $count = $query->count();
          echo $count;
        }else{
          $this->Flash->error(__('The good could not be saved. Please, try again.'));

        }
      }
    }

    public function button(){
      //CakePHPのレンダー機能を無効化する
      $this->autoRender = false;

      //Ajax通信か判定する
      if ($this->request->is('ajax')) {
        $query = $this->Goods->find()->Where(['post_id'=> $this->request->getData('post_id')]);
        $data['count'] = $query->count();
        $recode = $this->Goods->find()->Where(['user_id'=>$this->request->getData('user_id'), 'post_id'=>$this->request->getData('post_id')]);
        if ($recode->count() == 1) {
          $data['btn']= 'already';
        }
      }
      header("Content-Type: application/json; charset=utf-8");
    // htmlへ渡す配列$resultをjsonに変換する
      echo json_encode($data);

    }



}
