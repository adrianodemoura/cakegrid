<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * VinculacoesFixture
 */
class VinculacoesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'sistema_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'unidade_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'usuario_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'papel_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'sistema_id' => ['type' => 'index', 'columns' => ['sistema_id'], 'length' => []],
            'unidade_id' => ['type' => 'index', 'columns' => ['unidade_id'], 'length' => []],
            'usuario_id' => ['type' => 'index', 'columns' => ['usuario_id'], 'length' => []],
            'papel_id' => ['type' => 'index', 'columns' => ['papel_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'vinculacoes_ibfk_1' => ['type' => 'foreign', 'columns' => ['sistema_id'], 'references' => ['sistemas', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'vinculacoes_ibfk_2' => ['type' => 'foreign', 'columns' => ['unidade_id'], 'references' => ['unidades', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'vinculacoes_ibfk_3' => ['type' => 'foreign', 'columns' => ['usuario_id'], 'references' => ['usuarios', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'vinculacoes_ibfk_4' => ['type' => 'foreign', 'columns' => ['papel_id'], 'references' => ['papeis', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'sistema_id' => 1,
                'unidade_id' => 1,
                'usuario_id' => 1,
                'papel_id' => 1
            ],
        ];
        parent::init();
    }
}
