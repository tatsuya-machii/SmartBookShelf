<?php
declare(strict_types=1);

namespace App\Controller;
/**
 * Users Controller
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

  // ページネーションのオプション設定
  public $paginate = [
    'limit' => 8,
    'order' => [
      'create' => 'desc'
    ],
    'contain' => ['Posts', 'Books']
  ];

  // コントローラー名以外のモデルを使用する場合（editアクション部分）はloadModelでモデルを読み込む必要がある。
  // このクラス全体で使用するため、initializeメソッドに記述する。
  public function initialize():void
  {
    parent::initialize();
    $this->loadModel('Posts');
    $this->loadModel('Books');
  }

  public function beforeFilter(\Cake\Event\EventInterface $event)
  {
      parent::beforeFilter($event);
      // 認証を必要としないログインアクションを構成し、
      // 無限リダイレクトループの問題を防ぎます
      $this->Authentication->addUnauthenticatedActions(['login', 'add', 'forget']);
  }

    // /**
    //  * Index method
    //  *
    //  * @return \Cake\Http\Response|null|void Renders view
    //  */
    // public function index()
    // {
    //     $users = $this->paginate($this->Users);
    //
    //     $this->set(compact('users'));
    // }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
      $this->viewBuilder()->setLayout('beforelogin');

        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function main(){
      $this->viewBuilder()->setLayout('main');

      if (isset($_GET['id'])) {
        $id = $_GET['id'];
      }else{
        $user = $this->request->getAttribute('identity');
        $id = $user->id;
      }
      $posts = $this->Posts
        ->find()
        ->order(['created'=>'desc'])
        ->where(['user_id' => $id])
        ->join([
          'table'=>'books',
          'alias'=>'b',
          'type'=>'left',
          'conditions'=> 'b.id = Posts.book_id'
        ])->select([
          'id' => 'Posts.id',
          'bookname' => 'b.bookname',
          'image' => 'b.image',
          'recommends' => 'Posts.recommends',
          'created' => 'Posts.created'
        ]);
      //sqlでposts取得、joinでbooks.image取得

      $this->set(compact('posts'));

    }

    public function login()
    {
      $this->viewBuilder()->setLayout('beforelogin');

        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // POST, GET を問わず、ユーザーがログインしている場合はリダイレクトします
        if ($result->isValid()) {
            // redirect to /articles after login success
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'users',
                'action' => 'main',
            ]);

            return $this->redirect($redirect);
        }
        // ユーザーが submit 後、認証失敗した場合は、エラーを表示します
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        // POST, GET を問わず、ユーザーがログインしている場合はリダイレクトします
        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    public function forget(){
      $this->viewBuilder()->setLayout('beforelogin');

    }




}
