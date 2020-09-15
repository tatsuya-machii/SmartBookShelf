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

    /**
     * View method
     *
     * @param string|null $id Good id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $good = $this->Goods->get($id, [
            'contain' => ['Users', 'Posts'],
        ]);

        $this->set(compact('good'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $good = $this->Goods->newEmptyEntity();
        if ($this->request->is('post')) {
            $good = $this->Goods->patchEntity($good, $this->request->getData());
            if ($this->Goods->save($good)) {
                $this->Flash->success(__('The good has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The good could not be saved. Please, try again.'));
        }
        $users = $this->Goods->Users->find('list', ['limit' => 200]);
        $posts = $this->Goods->Posts->find('list', ['limit' => 200]);
        $this->set(compact('good', 'users', 'posts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Good id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $good = $this->Goods->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $good = $this->Goods->patchEntity($good, $this->request->getData());
            if ($this->Goods->save($good)) {
                $this->Flash->success(__('The good has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The good could not be saved. Please, try again.'));
        }
        $users = $this->Goods->Users->find('list', ['limit' => 200]);
        $posts = $this->Goods->Posts->find('list', ['limit' => 200]);
        $this->set(compact('good', 'users', 'posts'));
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
}
