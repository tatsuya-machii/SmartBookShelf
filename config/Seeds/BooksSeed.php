<?php
declare(strict_types=1);

use Migrations\AbstractSeed;
use Authentication\PasswordHasher\DefaultPasswordHasher; // この行を追加

/**
 * Books seed.
 */
class BooksSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
          [
            'bookname' => 'book1',
            'author' => 'author1',
            'publisher' => 'publisher1',
            'created' => '2020-09-11 10:00:00',
            'modified' => '2020-09-11 10:00:00'
          ],[
            'bookname' => 'book2',
            'author' => 'author2',
            'publisher' => 'publisher2',
            'created' => '2020-09-11 10:00:00',
            'modified' => '2020-09-11 10:00:00'
          ],[
            'bookname' => 'book3',
            'author' => 'author3',
            'publisher' => 'publisher3',
            'created' => '2020-09-11 10:00:00',
            'modified' => '2020-09-11 10:00:00'
          ],[
            'bookname' => 'book4',
            'author' => 'author1',
            'publisher' => 'publisher1',
            'created' => '2020-09-11 10:00:00',
            'modified' => '2020-09-11 10:00:00'
          ],[
            'bookname' => 'book5',
            'author' => 'author1',
            'publisher' => 'publisher2',
            'created' => '2020-09-11 10:00:00',
            'modified' => '2020-09-11 10:00:00'
          ],[
            'bookname' => 'book1',
            'author' => 'author1',
            'publisher' => 'publisher3',
            'created' => '2020-09-11 10:00:00',
            'modified' => '2020-09-11 10:00:00'
          ],

        ];

        $table = $this->table('books');
        $table->insert($data)->save();
    }
    // このメソッドを追加
    protected function _setPassword(string $password) : ?string
    {
      if (strlen($password) > 0) {
        return (new DefaultPasswordHasher())->hash($password);
      }
    }

}
