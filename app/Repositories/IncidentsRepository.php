<?php

namespace App\Repositories;

use App\Models\Incidents;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class IncidentsRepository
 * @package App\Repositories
 * @version January 10, 2018, 11:06 am CST
 *
 * @method Incidents findWithoutFail($id, $columns = ['*'])
 * @method Incidents find($id, $columns = ['*'])
 * @method Incidents first($columns = ['*'])
*/
class IncidentsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'ticket',
        'complaint',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Incidents::class;
    }
}
