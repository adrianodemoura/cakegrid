<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Auditoria Entity
 *
 * @property int $id
 * @property string $codigo_sistema
 * @property string $ip
 * @property string $motivo
 * @property string $descricao
 * @property int $usuario_id
 * @property \Cake\I18n\FrozenTime $data
 *
 * @property \App\Model\Entity\Usuario $usuario
 */
class Auditoria extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'ip'            => true,
        'motivo'        => true,
        'descricao'     => true,
        'usuario_id'    => true,
        'sistema_id'    => true,
        'data'          => true,
        'usuario'       => true,
        'sistema'       => true
    ];

    /**
     * Retorna o nome do usuário
     *
     * @return  string  $usuario  Nome do usuário
     */
    protected function _getNomeUsuario()
    {
        return $this->usuario->nome;
    }

    /**
     * Retorna o nome do sistema
     *
     * @return  string  $sistema  Nome do sistema.
     */
    protected function _getNomeSistema()
    {
        return $this->sistema->nome;
    }
}
