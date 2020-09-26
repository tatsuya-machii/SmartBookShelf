<?php
declare(strict_types=1);
namespace App\Controller;
require "../../vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
use Cake\Mailer\Mailer;


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
    $this->loadModel('Friends');

  }

  public function beforeFilter(\Cake\Event\EventInterface $event)
  {
      parent::beforeFilter($event);
      // 認証を必要としないログインアクションを構成し、
      // 無限リダイレクトループの問題を防ぎます
      $this->Authentication->addUnauthenticatedActions(['login', 'add', 'forget', 'callback', 'forgetPass', 'createNewPass']);
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

                return $this->redirect(['action' => 'main']);
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

            // イメージファイルのアップロード
            $file = $this->request->getData('image');
            if( $file->getClientFilename() ) {
              $file = $this->request->getData('image');
              $filePath = "../webroot/img/users/". $id.".".pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
              $file->moveTo($filePath);
              $data = $this->request->getData();
              $data['image'] = $id.".".pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
            }else{
              $data = $this->request->getData();
              unset($data['image']);
            }

            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
              unset($_SESSION['Auth']);
              $_SESSION['Auth']= $user;
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'main']);
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



    public function main($id=null){
      $this->viewBuilder()->setLayout('main');
      // 表示するユーザーの特定
      if (empty($id)) {
        $user = $this->request->getAttribute('identity');
        $id = $_SESSION['Auth']['id'];
      }
      $user = $this->Users->get($id, [
          'contain' => [],
      ]);

      // ユーザーの投稿履歴を取得
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

      $friends = $this->Friends
        ->find()
        ->Where(['user_id'=>$id]);

      $count = $friends->count();


      $this->set(compact('user','posts', 'count'));

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

      if ($this->request->is('post')) {

        $user = $this->Users->find()->Where(['email'=>$this->request->getData('email')]);
        if ($user = $user->toArray()) {
          $user = $user[0];
          $email = $user->email;
          $_SESSION['email']= $email;
          // ここで仮パスワードを作成し、DBを更新
          $temporary_password = substr(base_convert(md5(uniqid()), 16, 36), 0, 10);
          $user['temporary_password'] = $temporary_password;
          $user = $this->Users->patchEntity($user, ['temporary_password' => $temporary_password]);
          $this->Users->save($user);

          $mailer = new Mailer();
          $mailer->setProfile('default')
              ->setFrom(['SBS@example.com' => 'Smart Book Shelf'])
              ->setTo($email)
              ->setSubject("仮パスワードのお知らせ\n[SmartBookShelf]");
          $mailer->deliver("仮パスワードを発行しました。以下のURLにアクセスし、仮パスワードを入力して、新しいパスワードを登録してください。\n仮パスワード：".$temporary_password."\nurl:http://192.168.33.10/SBS/users/create-new-pass");
              $this->Flash->success(__('We sent Email for'.$email.'. please check the email.'));
              return $this->redirect(['action' => 'createNewPass']);
        }

        $this->Flash->error(__('The user could not be find. Please, try again.'));
        return $this->redirect(['action' => 'forgetPass']);
      }

    }

    public function createNewPass(){
      if ($this->request->is(['patch', 'post', 'put'])) {
        // メールアドレスからユーザーを検索
        $user = $this->Users->find()->Where(['email'=>$this->request->getData('email')]);
        if ($user = $user->toArray()) {
          $user = $user[0];
          // 仮パスワードの照合
          if ($user->temporary_password == $this->request->getData('temporary_password')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            // ユーザー情報の更新
            $user->temporary_password = null;
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));

          }else{
            $this->Flash->error(__('temporary_password is wrong. Please, try again.'));
          }
        }else{
        $this->Flash->error(__('The user could not find. Please, try again.'));
        }
      }
    }

    public function tw_login(){

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
      // callback後、認証失敗した場合は、エラーを表示します
      if ($this->request->is('post') && !$result->isValid()) {
          $this->Flash->error(__('Invalid username or password'));
          $redirect = $this->request->getQuery('redirect', [
              'controller' => 'users',
              'action' => 'login',
          ]);

          return $this->redirect($redirect);
      }

    }

    public function callback(){
      //Twitterのコンシュマーキー(APIキー)等読み込み
      define('TWITTER_API_KEY', '6f2GcwbdYhwua09KJxiYG2KvN');//Consumer Key (API Key)
      define('TWITTER_API_SECRET', 'xJTKZ9mN60TaiOvX0jm2eEgN5XIrVRCZJ0alKJ7fxK52cQKWh3');//Consumer Secret (API Secret)

      //リクエストトークンを使い、アクセストークンを取得する
      $twitter_connect = new TwitterOAuth(TWITTER_API_KEY, TWITTER_API_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
      $access_token = $twitter_connect->oauth('oauth/access_token', array('oauth_verifier' => $_GET['oauth_verifier'], 'oauth_token'=> $_GET['oauth_token']));

      //アクセストークンからユーザの情報を取得する
      $user_connect = new TwitterOAuth(TWITTER_API_KEY, TWITTER_API_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
      $user_info = $user_connect->get('account/verify_credentials');//アカウントの有効性を確認するためのエンドポイント

      if (empty($user_info)) {
        // code...
        echo "アクセストークンがからです。";
        print_r($access_token);
        $this->Flash->error(__('The user could not find.'));
        return $this->redirect(['action' => 'login']);

      }else{

        // ユーザーをクリエイト（name= $access_token["screen_name"]）
        $username = $user_info->name;
        $twitter_id = $user_info->id;
        $query = $this->Users->find()->Where(["username" => $username, "twitter_id" => $twitter_id]);

        if ($user = $query->toArray()) {
          unset($_SESSION['Auth']);
          $_SESSION['Auth']= $user[0];
          $this->Flash->success(__('success to Twitter_login.'));

          return $this->redirect(['action' => 'main']);
        }else{
          $arr = array("username" => $username, "twitter_id" => $twitter_id);

          $user = $this->Users->newEmptyEntity();
              $user = $this->Users->patchEntity($user, $arr);
              if ($this->Users->save($user)) {
                $_SESSION['Auth'] = $user;
                  $this->Flash->success(__('The user has been saved.please registration your email and password.'));
                  return $this->redirect(['action' => 'main']);
              }
              $this->Flash->error(__('The user could not be saved. Please, try again.'));
              return $this->redirect(['action' => 'login']);
        }
      }
    }







}
