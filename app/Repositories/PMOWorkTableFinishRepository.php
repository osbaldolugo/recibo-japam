<?php

namespace App\Repositories;

use App\Models\PMOWorkTableFinish;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PMOWorkTableFinishRepository
 * @package App\Repositories
 * @version March 1, 2018, 10:57 am CST
 *
 * @method PMOWorkTableFinish findWithoutFail($id, $columns = ['*'])
 * @method PMOWorkTableFinish find($id, $columns = ['*'])
 * @method PMOWorkTableFinish first($columns = ['*'])
*/
class PMOWorkTableFinishRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pmo_work_table_id',
        'work_time',
        'cause_id',
        'supervisory_id',
        'captured_id',
        'tools_cost',
        'other_cost'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PMOWorkTableFinish::class;
    }
}
