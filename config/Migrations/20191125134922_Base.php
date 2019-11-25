<?php
/**
 * Class Base
 *
 * @package     cakegrid.Config.Migrations
 */
use Migrations\AbstractMigration;
/**
 * Mantém o banco de dados inicial.
 *
 * $ bin/cake migrations create Base // este comando irá criar as tabelas, não rode aqui.
 * $ bin/cake migrations migrate
 * $ bin/cake migrations rollback
 * $ bin/cake migrations status
 */
class Base extends AbstractMigration {
    /**
     * Migrate Up.
     */
    public function up()
    {
        // tabela municípios
        $this->table('municipios')
            ->addColumn('nome',         'string', ['default' => '-', 'limit' => 100, 'null' => false])
            ->addColumn('uf',           'string', ['default' => '-', 'limit' => 2, 'null' => false])
            ->addColumn('codi_estd',    'string', ['default' => '-', 'limit' => 2,'null' => false])
            ->addColumn('desc_estd',    'string', ['default' => '-', 'limit' => 50, 'null' => false])
            ->addIndex(['uf', 'nome'])
            ->create();
        $this->updateMunicipios();

        // tabela usuaários
        $this->table('usuarios')
            ->addColumn('nome',          'string', ['default' => '', 'limit' => 100, 'null' => false])
            ->addColumn('email',         'string', ['default' => '', 'limit' => 100, 'null' => false])
            ->addColumn('senha',         'string', ['default' => '', 'limit' => 100, 'null' => false])
            ->addColumn('municipio_id', 'integer',['default' => 3106200, 'limit' => 11, 'null' => false])
            ->addIndex(['municipio_id'])
            ->create();
        $this->table('usuarios')
            ->addForeignKey('municipio_id', 'municipios', 'id', ['update' => 'CASCADE', 'delete' => 'CASCADE'])
            ->update();
    }
 
    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('usuarios')->dropForeignKey('municipio_id')->save();
        $this->table('municipios')->drop()->save();
        $this->table('usuarios')->drop()->save();
    }

    /**
     * Atualiza a tabela de municipios
     *
     * @return  void
     */
    private function updateMunicipios()
    {
        $data   = [];
        $arq    = ROOT . DS . 'config' . DS . 'schema' . DS . 'municipios.csv';
        $csvFile= file($arq);
        foreach ($csvFile as $_l => $_linha)
        {
            if ($_l)
            {
                $arrCmps = str_getcsv($_linha);
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
                {
                    $arrCmps[1] = utf8_decode($arrCmps[1]);
                    $arrCmps[4] = utf8_decode($arrCmps[4]);
                }
                $data[] = 
                [
                    'id'        => (int)$arrCmps[0], 
                    'nome'      => trim($arrCmps[1]), 
                    'uf'        => trim($arrCmps[2]), 
                    'codi_estd' => (int)$arrCmps[3], 
                    'desc_estd' => trim($arrCmps[4])
                ];
            }
        }
        $this->execute('delete from municipios');
        $table = $this->table('municipios');
        $table->insert($data)->save();
    }
}
