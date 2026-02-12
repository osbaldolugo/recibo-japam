<?php

namespace App\Repositories;

use App\Models\AppUserCard;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AppUserCardRepository
 * @package App\Repositories
 * @version March 7, 2018, 10:16 am CST
 *
 * @method AppUserCard findWithoutFail($id, $columns = ['*'])
 * @method AppUserCard find($id, $columns = ['*'])
 * @method AppUserCard first($columns = ['*'])
*/
class AppUserCardRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'app_user_id',
        'owner',
        'number',
        'exp_month',
        'exp_year'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AppUserCard::class;
    }
}
