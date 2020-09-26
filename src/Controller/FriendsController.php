<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Friends Controller
 *
 * @property \App\Model\Table\FriendsTable $Friends
 * @method \App\Model\Entity\Friend[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FriendsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id=null)
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];
        if (isset($id)) {
          $friends = $this->paginate($this->Friends->find()->where(['user_id'=>$id]));
        }else{
          $friends = $this->paginate($this->Friends);
        }

        $this->set(compact('friends'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
      //CakePHPのレンダー機能を無効化する
      $this->autoRender = false;

      //Ajax通信か判定する
      if ($this->request->is('ajax')) {

        $user_id = $this->request->getData('user_id');
        $friend = $this->Friends->newEmptyEntity();
        if ($this->request->is('post')) {
            $friend = $this->Friends->patchEntity($friend, $this->request->getData());
            if ($this->Friends->save($friend)) {
                $this->Flash->success(__('The friend has been saved.'));

                echo 'success';
            }else{
              $this->Flash->error(__('The friend could not be saved. Please, try again.'));
                echo 'false';
            }
        }

      }
    }


    /**
     * Delete method
     *
     * @param string|null $id Friend id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {
      //CakePHPのレンダー機能を無効化する
      $this->autoRender = false;
      //Ajax通信か判定する
      if ($this->request->is('ajax')) {
        $this->request->allowMethod(['post', 'delete']);
        // find()はクエリを実行しないので、toArray()で実行後の配列を取得。その後、配列の[0]（該当のfriend情報）を引数にしてdeleteを実行する。
        $friend = $this->Friends->find()->Where(['user_id'=>$this->request->getData('user_id'),'friends_id' =>$this->request->getData('friends_id')]);
        $friend = $friend->toArray();
        if ($this->Friends->delete($friend[0])) {
          $this->Flash->success(__('The friend has been deleted.'));
          echo 'success';

        } else {
          $this->Flash->error(__('The friend could not be deleted. Please, try again.'));
        }
      }
    }

    public function test()
    {
      //CakePHPのレンダー機能を無効化する
      $this->autoRender = false;
      //Ajax通信か判定する
      if ($this->request->is('ajax')) {
        // find()はクエリを実行しないので、toArray()で実行後の配列を取得。その後、配列の[0]（該当のfriend情報）を引数にしてdeleteを実行する。
        $friend = $this->Friends->find()->Where(['user_id'=>$this->request->getData('user_id'),'friends_id' =>$this->request->getData('friends_id')]);
        if ($friend->toArray()) {
          echo 'already';
        }
      }
    }
}
