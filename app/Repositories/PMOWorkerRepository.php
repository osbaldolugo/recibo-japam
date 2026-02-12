<?php

namespace App\Repositories;

use App\Models\PMOWorker;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PMOWorkerRepository
 * @package App\Repositories
 * @version February 15, 2018, 5:49 pm CST
 *
 * @method PMOWorker findWithoutFail($id, $columns = ['*'])
 * @method PMOWorker find($id, $columns = ['*'])
 * @method PMOWorker first($columns = ['*'])
*/
class PMOWorkerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nom_id',
        'speciality_id',
        'dairy_salary',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PMOWorker::class;
    }
}
