<?php

namespace App\Repositories;

use App\Models\Complaint;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ComplaintRepository
 * @package App\Repositories
 * @version April 3, 2018, 9:35 am CDT
 *
 * @method Complaint findWithoutFail($id, $columns = ['*'])
 * @method Complaint find($id, $columns = ['*'])
 * @method Complaint first($columns = ['*'])
*/
class ComplaintRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'app_user_id',
        'people_unlogged_id',
        'description',
        'created_at',
        'updated_at',
        'phone_number',
        'recibo',
        'contrato',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Complaint::class;
    }
}
