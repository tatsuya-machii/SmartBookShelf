<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Posts Controller
 *
 * @method \App\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PostsController extends AppController
{
  // ページネーションのオプション設定
  public $paginate = [
    'limit' => 10,
    'order' => [
      'create' => 'desc'
    ],
    'contain' => ['Users', 'Books']
  ];

  // コントローラー名以外のモデルを使用する場合（editアクション部分）はloadModelでモデルを読み込む必要がある。
  // このクラス全体で使用するため、initializeメソッドに記述する。
  public function initialize():void
  {
    parent::initialize();
    $this->loadModel('Users');
    $this->loadModel('Books');
  }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
      $this->viewBuilder()->setLayout('beforelogin');

        $posts = $this->paginate($this->Posts);

        $this->set(compact('posts'));
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $post = $this->Posts->get($id, [
            'contain' => ['Users','Books'],
        ]);

        $this->set(compact('post'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $post = $this->Posts->newEmptyEntity();
        if ($this->request->is('post')) {
            $post = $this->Posts->patchEntity($post, $this->request->getData());
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post could not be saved. Please, try again.'));
        }
        $users = $this->Users->find('list');
        $books = $this->Books->find('list');
        $this->set(compact('post', 'users', 'books'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $post = $this->Posts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->Posts->patchEntity($post, $this->request->getData());
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post could not be saved. Please, try again.'));
        }
        $users = $this->Users->find('list');
        $books = $this->Books->find('list');
        $this->set(compact('post', 'users', 'books'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $post = $this->Posts->get($id);
        if ($this->Posts->delete($post)) {
            $this->Flash->success(__('The post has been deleted.'));
        } else {
            $this->Flash->error(__('The post could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // ajax--------------------------------------------------------------------------
    public function ajax(){
      //CakePHPのレンダー機能を無効化する
      $this->autoRender = false;
      //Ajax通信か判定する
      if ($this->request->is('ajax')) {

        // 必要な変数の定義
        $posts = $this->Posts
          ->find()
          ->order(['created'=>'desc'])
          ->join([
            'table'=>'users',
            'alias'=>'u',
            'type'=>'left',
            'conditions'=> 'u.id = Posts.user_id'
          ])->join([
            'table'=>'books',
            'alias'=>'b',
            'type'=>'left',
            'conditions'=> 'b.id = Posts.book_id'
          ])->select([
            'id' => 'Posts.id',
            'username' => 'u.username',
            'userimage' => 'u.image',
            'bookname' => 'b.bookname',
            'bookimage' => 'b.image',
            'recommends' => 'Posts.recommends',
            'created' => 'Posts.created'
          ]);


        $searchTextUserName = $_GET["search_user_name"];
        $searchTextBookName = $_GET["search_book_name"];
        $targetText = "";
        $searchResult = array();

          foreach ($posts as $post) {
            $add_flag=0;
            if (!empty($searchTextUserName)) {
              if (strpos($post["username"], $searchTextUserName) !== false) {
                $add_flag ++;
              };
            }else{
              $add_flag ++;
            }
            if (!empty($searchTextBookName)) {
              if (strpos($post["bookname"], $searchTextBookName) !== false) {
                $add_flag ++;
              };
            }else{
              $add_flag ++;
            }


            // userimage
            if ($post['userimage'] == null) {
              $post['userimage'] = '<i class="fas fa-user small_icon"></i>';
            };
            // userimage
            if ($post['bookimage'] == null) {
              $post['bookimage'] = '<i class="fas fa-book-open small_icon"></i>';
            };
            // star
            $on = null;
            $off = null;
            for ($j=0; $j <= $post["recommends"]; $j++){
              $on .= '<img src="/SBS/webroot/img/base/star-on.png">';
            };
            if ($post["recommends"] < 5) {
              for ($j=$post["recommends"]; $j < 5; $j++){
                $off .= '<img src="/SBS/webroot/img/base/star-off.png">';
              };
            };
            $post["recommends"] = $on.$off;







            if ($add_flag == 2) {
              $post = array(
                'username'=>$post['username'],
                'bookname'=>$post['bookname'],
                'userimage'=>$post['userimage'],
                'bookimage'=>$post['bookimage'],
                'recommends'=>$post['recommends'],
                'created'=>$post['created']
              );
              // // おすすめ度の星表記
              // $on = null;
              // $off = null;
              // for ($j=0; $j <= $post["recommends"]; $j++){
              //   $on .= $thi->Html->image('base/star-on.png');
              // };
              // if ($post["recommends"] < 5) {
              //   for ($j=$post["recommends"]; $j < 5; $j++){
              //     $off .= $thi->Html->image('base/star-off.png');
              //   };
              // };
              // $post["recommends"] = $on.$off;
              $searchResult[] = array_merge($post);
            }
          }

          header("Content-Type: application/json; charset=utf-8");
        // htmlへ渡す配列$resultをjsonに変換する
        echo json_encode($searchResult);
      }

    }
}
