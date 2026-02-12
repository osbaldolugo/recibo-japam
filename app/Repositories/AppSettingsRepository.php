<?php

namespace App\Repositories;

use App\Models\AppSettings;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AppSettingsRepository
 * @package App\Repositories
 * @version April 19, 2018, 1:54 pm CDT
 *
 * @method AppSettings findWithoutFail($id, $columns = ['*'])
 * @method AppSettings find($id, $columns = ['*'])
 * @method AppSettings first($columns = ['*'])
*/
class AppSettingsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pay_control'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AppSettings::class;
    }
}
