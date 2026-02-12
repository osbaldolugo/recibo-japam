<?php

namespace App\Repositories;

use App\Models\PMOSpeciality;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PMOSpecialityRepository
 * @package App\Repositories
 * @version February 23, 2018, 11:27 am CST
 *
 * @method PMOSpeciality findWithoutFail($id, $columns = ['*'])
 * @method PMOSpeciality find($id, $columns = ['*'])
 * @method PMOSpeciality first($columns = ['*'])
*/
class PMOSpecialityRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'speciality',
        'created_at',
        'deleted_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PMOSpeciality::class;
    }
}
