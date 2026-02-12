<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 10/01/2018
 * Time: 04:18 PM
 */

namespace App\Repositories;

use App\Models\Suburb;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SuburbRepository
 * @package App\Repositories
 * @version January 10, 2018, 11:03 am CST
 *
 * @method Suburb findWithoutFail($id, $columns = ['*'])
 * @method Suburb find($id, $columns = ['*'])
 * @method Suburb first($columns = ['*'])
 */

class SuburbRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'suburb',
        'sector_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Suburb::class;
    }
}