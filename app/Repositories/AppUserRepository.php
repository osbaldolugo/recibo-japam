<?php

namespace App\Repositories;

use App\Models\AppUser;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AppUserRepository
 * @package App\Repositories
 * @version January 4, 2018, 4:01 pm CST
 *
 * @method AppUser findWithoutFail($id, $columns = ['*'])
 * @method AppUser find($id, $columns = ['*'])
 * @method AppUser first($columns = ['*'])
*/
class AppUserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'people_id',
        'email',
        'password',
        'phone_number',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AppUser::class;
    }
}
