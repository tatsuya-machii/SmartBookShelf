<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreatePosts extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('posts');
        $table
        ->addColumn('recommends', 'integer',[
          'default' => 1,
          'limit' => 1,
          'null' => false,
        ])
        ->addColumn('description', 'text',[
          'default' => null,
          'limit' => 512,
          'null' => true,
        ])
        ->addColumn('impression', 'text',[
          'default' => null,
          'limit' => 512,
          'null' => true,
        ])
        ->addColumn('user_id', 'integer',[
          'default' => null,
          'limit' => 11,
          'null' => false,
        ])
        ->addColumn('book_id', 'integer',[
          'default' => null,
          'limit' => 11,
          'null' => false,
        ])
        ->addColumn('created', 'datetime')
        ->addColumn('modified', 'datetime')
        ->create();
    }
}
