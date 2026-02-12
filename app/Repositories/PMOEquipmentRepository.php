<?php

namespace App\Repositories;

use App\Models\PMOEquipment;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PMOEquipmentRepository
 * @package App\Repositories
 * @version February 16, 2018, 9:14 am CST
 *
 * @method PMOEquipment findWithoutFail($id, $columns = ['*'])
 * @method PMOEquipment find($id, $columns = ['*'])
 * @method PMOEquipment first($columns = ['*'])
*/
class PMOEquipmentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'description',
        'code',
        'deleted_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PMOEquipment::class;
    }
}
