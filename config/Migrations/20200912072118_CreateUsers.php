<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
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
        $table = $this->table('users');
        $table
        ->addColumn('username', 'string',[
          'default' => null,
          'limit' => 50,
          'null' => false,
        ])
        ->addColumn('email', 'string',[
          'default' => null,
          'limit' => 255,
          'null' => true,
        ])
        ->addColumn('password', 'string',[
          'default' => null,
          'limit' => 255,
          'null' => true,
        ])
        ->addColumn('temporary_password', 'string',[
          'default' => null,
          'limit' => 255,
          'null' => true,
        ])
        ->addColumn('twitter_id', 'biginteger',[
          'default' => null,
          'null' => true,
        ])
        ->addColumn('image', 'string',[
          'default' => null,
          'limit' => 255,
          'null' => true,
        ])
        ->addColumn('role', 'integer',[
          'default' => 0,
          'limit' => 1,
          'null' => false,
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
