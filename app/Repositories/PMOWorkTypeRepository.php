<?php

namespace App\Repositories;

use App\Models\PMOWorkType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PMOWorkTypeRepository
 * @package App\Repositories
 * @version February 16, 2018, 9:05 am CST
 *
 * @method PMOWorkType findWithoutFail($id, $columns = ['*'])
 * @method PMOWorkType find($id, $columns = ['*'])
 * @method PMOWorkType first($columns = ['*'])
*/
class PMOWorkTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'code',
        'deleted_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PMOWorkType::class;
    }
}
