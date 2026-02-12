<?php

namespace App\Repositories;

use App\Models\PMOWork;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PMOWorkRepository
 * @package App\Repositories
 * @version February 15, 2018, 5:58 pm CST
 *
 * @method PMOWork findWithoutFail($id, $columns = ['*'])
 * @method PMOWork find($id, $columns = ['*'])
 * @method PMOWork first($columns = ['*'])
*/
class PMOWorkRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'description',
        'code',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PMOWork::class;
    }
}
