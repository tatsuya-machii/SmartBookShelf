<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GoodsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GoodsTable Test Case
 */
class GoodsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GoodsTable
     */
    protected $Goods;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Goods',
        'app.Users',
        'app.Posts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Goods') ? [] : ['className' => GoodsTable::class];
        $this->Goods = $this->getTableLocator()->get('Goods', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Goods);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
