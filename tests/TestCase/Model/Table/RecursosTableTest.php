<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RecursosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RecursosTable Test Case
 */
class RecursosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RecursosTable
     */
    public $Recursos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::getTableLocator()->exists('Recursos') ? [] : ['className' => RecursosTable::class];
        $this->Recursos = TableRegistry::getTableLocator()->get('Recursos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Recursos);

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
