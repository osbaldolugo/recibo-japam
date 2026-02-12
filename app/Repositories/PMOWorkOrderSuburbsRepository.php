<?php

namespace App\Repositories;

use App\Models\PMOWorkOrderSuburbs;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PMOWorkOrderSuburbsRepository
 * @package App\Repositories
 * @version June 5, 2018, 3:11 pm CDT
 *
 * @method PMOWorkOrderSuburbs findWithoutFail($id, $columns = ['*'])
 * @method PMOWorkOrderSuburbs find($id, $columns = ['*'])
 * @method PMOWorkOrderSuburbs first($columns = ['*'])
*/
class PMOWorkOrderSuburbsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pmo_work_table_id',
        'suburb_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PMOWorkOrderSuburbs::class;
    }
}
