<?php
declare(strict_types=1);

use Migrations\AbstractSeed;
use Authentication\PasswordHasher\DefaultPasswordHasher; // この行を追加

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
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
            'username' => 'admin',
            'email' => 'admin@com',
            'password' => $this->_setPassword('admin'),
            'role' => 1,
            'created' => '2020-09-11 10:00:00',
            'modified' => '2020-09-11 10:00:00'
          ],[
            'username' => 'user1',
            'email' => 'user1@com',
            'password' => $this->_setPassword('user1'),
            'created' => '2020-09-11 10:00:00',
            'modified' => '2020-09-11 10:00:00'
          ],[
            'username' => 'user2',
            'email' => 'user2@com',
            'password' => $this->_setPassword('user2'),
            'created' => '2020-09-11 10:00:00',
            'modified' => '2020-09-11 10:00:00'
          ],[
            'username' => 'user3',
            'email' => 'user3@com',
            'password' => $this->_setPassword('user3'),
            'created' => '2020-09-11 10:00:00',
            'modified' => '2020-09-11 10:00:00'
          ],[
            'username' => 'user4',
            'email' => 'user4@com',
            'password' => $this->_setPassword('user4'),
            'created' => '2020-09-11 10:00:00',
            'modified' => '2020-09-11 10:00:00'
          ]

        ];

        $table = $this->table('users');
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
