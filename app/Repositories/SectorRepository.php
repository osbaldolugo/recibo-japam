<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 10/01/2018
 * Time: 12:52 PM
 */

namespace App\Repositories;

use App\Models\Sector;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SectorRepository
 * @package App\Repositories
 * @version January 10, 2018, 11:03 am CST
 *
 * @method Sector findWithoutFail($id, $columns = ['*'])
 * @method Sector find($id, $columns = ['*'])
 * @method Sector first($columns = ['*'])
 */

class SectorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'name',
        'background'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Sector::class;
    }
}