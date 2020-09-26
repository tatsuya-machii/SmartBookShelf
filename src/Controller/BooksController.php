<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Books Controller
 *
 * @property \App\Model\Table\BooksTable $Books
 * @method \App\Model\Entity\Book[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BooksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $books = $this->paginate($this->Books);

        $this->set(compact('books'));
    }

    // /**
    //  * View method
    //  *
    //  * @param string|null $id Book id.
    //  * @return \Cake\Http\Response|null|void Renders view
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function view($id = null)
    // {
    //     $book = $this->Books->get($id, [
    //         'contain' => ['Posts'],
    //     ]);
    //
    //     $this->set(compact('book'));
    // }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $book = $this->Books->newEmptyEntity();
        if ($this->request->is('post')) {
            $book = $this->Books->patchEntity($book, $this->request->getData());
            if ($recoad = $this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['controller'=>'Posts', 'action' => 'add', $recoad->id]);
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }
        $this->set(compact('book'));
    }


    // /**
    //  * Edit method
    //  *
    //  * @param string|null $id Book id.
    //  * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function edit($id = null)
    // {
    //     $book = $this->Books->get($id, [
    //         'contain' => [],
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $book = $this->Books->patchEntity($book, $this->request->getData());
    //         if ($this->Books->save($book)) {
    //             $this->Flash->success(__('The book has been saved.'));
    //
    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The book could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('book'));
    // }

    // /**
    //  * Delete method
    //  *
    //  * @param string|null $id Book id.
    //  * @return \Cake\Http\Response|null|void Redirects to index.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $book = $this->Books->get($id);
    //     if ($this->Books->delete($book)) {
    //         $this->Flash->success(__('The book has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The book could not be deleted. Please, try again.'));
    //     }
    //
    //     return $this->redirect(['action' => 'index']);
    // }

    public function search(){
      //CakePHPのレンダー機能を無効化する
      $this->autoRender = false;
      //Ajax通信か判定する
      if ($this->request->is('ajax')) {

        // 必要な変数の定義
        $books = $this->Books
          ->find()
          ->order(['created'=>'desc']);

          $searchTextName = $_POST["book_name"];
          $searchTextAuthor = $_POST["author"];
          $targetText = "";
          $searchResult = array();

            foreach ($books as $book) {
              $add_flag=0;
              if (!empty($searchTextName)) {
                if (strpos($book["bookname"], $searchTextName) !== false) {
                  $add_flag ++;
                };
              }else{
                $add_flag ++;
              }
              if (!empty($searchTextAuthor)) {
                if (strpos($book["author"], $searchTextAuthor) !== false) {
                  $add_flag ++;
                };
              }else{
                $add_flag ++;
              }

              if (empty($searchTextName) && empty($searchTextAuthor)) {
                $add_flag = 0;
              }



              // image
              if ($book['image'] == null) {
                $book['image'] = '<i class="fas fa-book-open small_icon"></i>';
              };

              if ($add_flag == 2) {
                $book = array(
                  'id'=>$book['id'],
                  'bookname'=>$book['bookname'],
                  'author'=>$book['author'],
                  'publisher'=>$book['publisher'],
                  'image'=>$book['image'],
                  'created'=>$book['created']
                );

                $searchResult[] = array_merge($book);
              }

          }
          header("Content-Type: application/json; charset=utf-8");

          echo json_encode($searchResult);

      }

    }
}
