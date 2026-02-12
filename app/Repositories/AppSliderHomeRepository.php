<?php

namespace App\Repositories;

use App\Models\AppSliderHome;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AppSliderHomeRepository
 * @package App\Repositories
 * @version March 1, 2018, 11:42 pm CST
 *
 * @method AppSliderHome findWithoutFail($id, $columns = ['*'])
 * @method AppSliderHome find($id, $columns = ['*'])
 * @method AppSliderHome first($columns = ['*'])
*/
class AppSliderHomeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'image',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AppSliderHome::class;
    }
}
