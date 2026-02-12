<?php

namespace App\Repositories;

use App\Models\PeopleUnlogged;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PeopleUnloggedRepository
 * @package App\Repositories
 * @version January 11, 2018, 8:57 am CST
 *
 * @method PeopleUnlogged findWithoutFail($id, $columns = ['*'])
 * @method PeopleUnlogged find($id, $columns = ['*'])
 * @method PeopleUnlogged first($columns = ['*'])
*/
class PeopleUnloggedRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'last_name_1',
        'last_name_2',
        'receipt_id',
        'phone_number',
        'email'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PeopleUnlogged::class;
    }
}
