<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PapeisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PapeisTable Test Case
 */
class PapeisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PapeisTable
     */
    public $Papeis;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Papeis',
        'app.Sistemas',
        'app.Recursos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Papeis') ? [] : ['className' => PapeisTable::class];
        $this->Papeis = TableRegistry::getTableLocator()->get('Papeis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Papeis);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
