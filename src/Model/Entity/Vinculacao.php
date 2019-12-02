<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vinculacao Entity
 *
 * @property int $id
 * @property int $sistema_id
 * @property int $unidade_id
 * @property int $usuario_id
 * @property int $papel_id
 *
 * @property \App\Model\Entity\Sistema $sistema
 * @property \App\Model\Entity\Unidade $unidade
 * @property \App\Model\Entity\Usuario $usuario
 * @property \App\Model\Entity\Papel $papei
 */
class Vinculacao extends Entity
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
        'sistema_id' => true,
        'unidade_id' => true,
        'usuario_id' => true,
        'papel_id' => true,
        'sistema' => true,
        'unidade' => true,
        'usuario' => true,
        'papei' => true
    ];
}
