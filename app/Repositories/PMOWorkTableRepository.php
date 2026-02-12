<?php

namespace App\Repositories;

use App\Models\PMOWorkTable;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PMOWorkTableRepository
 * @package App\Repositories
 * @version February 28, 2018, 11:04 am CST
 *
 * @method PMOWorkTable findWithoutFail($id, $columns = ['*'])
 * @method PMOWorkTable find($id, $columns = ['*'])
 * @method PMOWorkTable first($columns = ['*'])
*/
class PMOWorkTableRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ticket_id',
        'user_id',
        'folio',
        'work_id',
        'equipment_id',
        'worktype_id',
        'status',
        'deadline',
        'executor_category_id',
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
        return PMOWorkTable::class;
    }
}
