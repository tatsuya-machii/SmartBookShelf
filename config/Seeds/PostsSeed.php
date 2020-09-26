<?php
declare(strict_types=1);

use Migrations\AbstractSeed;
use Authentication\PasswordHasher\DefaultPasswordHasher; // この行を追加

/**
 * Posts seed.
 */
class PostsSeed extends AbstractSeed
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
            'recommends' => 1,
            'description' => 'description1',
            'impression' => 'impression1',
            'user_id' => 1,
            'book_id' => 1,
            'created' => '2020-09-11 10:00:01',
            'modified' => '2020-09-11 10:00:01'
          ],[
            'recommends' => 2,
            'description' => '',
            'impression' => 'impression2',
            'user_id' => 1,
            'book_id' => 2,
            'created' => '2020-09-11 10:00:02',
            'modified' => '2020-09-11 10:00:02'
          ],[
            'recommends' => 3,
            'description' => 'description3',
            'impression' => '',
            'user_id' => 1,
            'book_id' => 3,
            'created' => '2020-09-11 10:00:03',
            'modified' => '2020-09-11 10:00:03'
          ],[
            'recommends' => 4,
            'description' => 'description4',
            'impression' => 'impression4',
            'user_id' => 1,
            'book_id' => 4,
            'created' => '2020-09-11 10:00:04',
            'modified' => '2020-09-11 10:00:04'
          ],[
            'recommends' => 5,
            'description' => 'description5',
            'impression' => 'impression5',
            'user_id' => 2,
            'book_id' => 1,
            'created' => '2020-09-11 10:00:05',
            'modified' => '2020-09-11 10:00:05'
          ],
        ];

        $table = $this->table('posts');
        $table->insert($data)->save();
    }

}
