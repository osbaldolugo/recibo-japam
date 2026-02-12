<?php

namespace App\Repositories;

use App\Models\PMOMaterial;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PMOMaterialRepository
 * @package App\Repositories
 * @version February 15, 2018, 5:55 pm CST
 *
 * @method PMOMaterial findWithoutFail($id, $columns = ['*'])
 * @method PMOMaterial find($id, $columns = ['*'])
 * @method PMOMaterial first($columns = ['*'])
*/
class PMOMaterialRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'unit',
        'description',
        'price'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PMOMaterial::class;
    }
}
