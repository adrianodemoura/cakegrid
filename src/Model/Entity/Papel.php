<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Papel Entity
 *
 * @property int $id
 * @property string $nome
 * @property bool $ativo
 * @property int $sistema_id
 *
 * @property \App\Model\Entity\Sistema $sistema
 * @property \App\Model\Entity\Recurso[] $recursos
 */
class Papel extends Entity
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
        'nome' => true,
        'ativo' => true,
        'sistema_id' => true,
        'sistema' => true,
        'recursos' => true
    ];
}
