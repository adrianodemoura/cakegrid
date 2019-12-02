<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Municipio Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $uf
 * @property string $codi_estd
 * @property string $desc_estd
 *
 * @property \App\Model\Entity\Usuario[] $usuarios
 */
class Municipio extends Entity
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
        'uf' => true,
        'codi_estd' => true,
        'desc_estd' => true,
        'usuarios' => true
    ];
}
