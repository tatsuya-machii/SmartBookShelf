<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateBooks extends AbstractMigration
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
        $table = $this->table('books');
        $table
        ->addColumn('bookname', 'string',[
        'default' => null,
        'limit' => 50,
        'null' => false,
      ])
      ->addColumn('author', 'string',[
        'default' => null,
        'limit' => 50,
        'null' => false,
      ])
      ->addColumn('publisher', 'string',[
        'default' => null,
        'limit' => 50,
        'null' => false,
      ])
      ->addColumn('image', 'string',[
        'default' => null,
        'limit' => 255,
        'null' => true,
      ])
      ->addColumn('status', 'integer',[
        'default' => 0,
        'limit' => 1,
        'null' => false,
      ])
      ->addColumn('created', 'datetime')
      ->addColumn('modified', 'datetime')
      ->create();
    }
}
