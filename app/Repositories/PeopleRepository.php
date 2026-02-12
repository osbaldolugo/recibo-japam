<?php

namespace App\Repositories;

use App\Models\People;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PeopleRepository
 * @package App\Repositories
 * @version January 4, 2018, 3:48 pm CST
 *
 * @method People findWithoutFail($id, $columns = ['*'])
 * @method People find($id, $columns = ['*'])
 * @method People first($columns = ['*'])
*/
class PeopleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'last_name_1',
        'last_name_2'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return People::class;
    }
}
