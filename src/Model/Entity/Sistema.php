<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sistema Entity
 *
 * @property int $id
 * @property string $nome
 * @property bool $ativo
 *
 * @property \App\Model\Entity\Papei[] $papeis
 * @property \App\Model\Entity\Recurso[] $recursos
 * @property \App\Model\Entity\Vinculaco[] $vinculacoes
 */
class Sistema extends Entity
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
        'papeis' => true,
        'recursos' => true,
        'vinculacoes' => true
    ];
}
