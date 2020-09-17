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
    $this->loadModel('Books');
    $this->loadModel('Posts');
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
        $query = $this->Goods->find()->Where(['user_id'=> $this->request->getData('user_id')]);
        $count = $query->count();
        echo $count;
      }
      $this->Flash->error(__('The good could not be saved. Please, try again.'));
    }
  }

    public function delete()
    {
      //CakePHPのレンダー機能を無効化する
      $this->autoRender = false;

      //Ajax通信か判定する
      if ($this->request->is('ajax')) {

        if ($this->Goods->deleteAll(['user_id'=>$this->request->getData('user_id'), 'post_id'=>$this->request->getData('post_id')])) {
          $query = $this->Goods->find()->Where(['user_id'=> $this->request->getData('user_id')]);
          $count = $query->count();
          echo $count;
        }
        $this->Flash->error(__('The good could not be saved. Please, try again.'));
      }
    }

    public function button(){
      //CakePHPのレンダー機能を無効化する
      $this->autoRender = false;

      //Ajax通信か判定する
      if ($this->request->is('ajax')) {
        $query = $this->Goods->find()->Where(['user_id'=> $this->request->getData('user_id')]);
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
