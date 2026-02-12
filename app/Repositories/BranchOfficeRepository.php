<?php

namespace App\Repositories;

use App\Models\BranchOffice;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BranchOfficeRepository
 * @package App\Repositories
 * @version January 4, 2018, 3:56 pm CST
 *
 * @method BranchOffice findWithoutFail($id, $columns = ['*'])
 * @method BranchOffice find($id, $columns = ['*'])
 * @method BranchOffice first($columns = ['*'])
*/
class BranchOfficeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'description',
        'street',
        'inside_number',
        'outside_number',
        'settlement',
        'cp',
        'latitude',
        'longitude',
        'image',
        'number_phone',
        'extension'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BranchOffice::class;
    }
}
