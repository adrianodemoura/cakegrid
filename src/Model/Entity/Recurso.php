<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Recurso Entity
 *
 * @property int $id
 * @property string $url
 * @property string $titulo
 * @property string $menu
 * @property bool $ativo
 * @property int $sistema_id
 */
class Recurso extends Entity
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
        'url' => true,
        'titulo' => true,
        'menu' => true,
        'ativo' => true,
        'sistema_id' => true
    ];
}
