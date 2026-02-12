<?php

namespace App\Repositories;

use App\Models\Priority;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PriorityRepository
 * @package App\Repositories
 * @version July 12, 2018, 12:17 pm CDT
 *
 * @method Priority findWithoutFail($id, $columns = ['*'])
 * @method Priority find($id, $columns = ['*'])
 * @method Priority first($columns = ['*'])
*/
class PriorityRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'color',
        'response_time'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Priority::class;
    }
}
