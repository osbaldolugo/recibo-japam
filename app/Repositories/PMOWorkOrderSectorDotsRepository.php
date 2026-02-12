<?php

namespace App\Repositories;

use App\Models\PMOWorkOrderSectorDots;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PMOWorkOrderSectorDotsRepository
 * @package App\Repositories
 * @version June 5, 2018, 2:10 pm CDT
 *
 * @method PMOWorkOrderSectorDots findWithoutFail($id, $columns = ['*'])
 * @method PMOWorkOrderSectorDots find($id, $columns = ['*'])
 * @method PMOWorkOrderSectorDots first($columns = ['*'])
*/
class PMOWorkOrderSectorDotsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pmo_work_table_id',
        'lat',
        'lng'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PMOWorkOrderSectorDots::class;
    }
}
