<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateFriends extends AbstractMigration
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
        $table = $this->table('friends');
        $table
        ->addColumn('user_id', 'integer',[
          'default' => null,
          'limit' => 11,
          'null' => false
        ])
        ->addColumn('friends_id', 'integer',[
          'default' => null,
          'limit' => 11,
          'null' => false
        ])
        ->addColumn('created', 'datetime')
        ->addColumn('modified', 'datetime')
        ->create();
    }
}
