<?php

namespace App\Repositories;

use App\Models\AppTicket;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AppTicketRepository
 * @package App\Repositories
 * @version January 10, 2018, 11:03 am CST
 *
 * @method AppTicket findWithoutFail($id, $columns = ['*'])
 * @method AppTicket find($id, $columns = ['*'])
 * @method AppTicket first($columns = ['*'])
*/
class AppTicketRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'incidents_id',
        'app_user_id',
        'people_unlogged_id',
        'description',
        'latitude',
        'longitude',
        'street',
        'outside_number',
        'inside_number',
        'suburb_id',
        'cp',
        'origen'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AppTicket::class;
    }
}
