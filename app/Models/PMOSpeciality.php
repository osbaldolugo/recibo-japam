<?php

namespace App\Models;

use App\Models\Traits\DatesTranslator;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PMOSpeciality
 * @package App\Models
 * @version February 23, 2018, 11:27 am CST
 *
 * @property \Illuminate\Database\Eloquent\Collection appTicket
 * @property \Illuminate\Database\Eloquent\Collection appTicketImages
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection pmoMaterialWorktable
 * @property \Illuminate\Database\Eloquent\Collection PmoWorker
 * @property \Illuminate\Database\Eloquent\Collection pmoWorkerWorktable
 * @property \Illuminate\Database\Eloquent\Collection pmoWorkorderSuburbs
 * @property \Illuminate\Database\Eloquent\Collection publishChannel
 * @property \Illuminate\Database\Eloquent\Collection receiptUser
 * @property \Illuminate\Database\Eloquent\Collection suscribeChannel
 * @property \Illuminate\Database\Eloquent\Collection ticketitAudits
 * @property \Illuminate\Database\Eloquent\Collection ticketitCategoriesUsers
 * @property \Illuminate\Database\Eloquent\Collection ticketitComments
 * @property \Illuminate\Database\Eloquent\Collection ticketitNotification
 * @property \Illuminate\Database\Eloquent\Collection ticketitsApp
 * @property string speciality
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon deleted_at
 */
class PMOSpeciality extends Model
{
    use DatesTranslator;
    use SoftDeletes;
    public $table = 'pmo_speciality';
    protected $dates = ['created_at', 'deleted_at'];

    public $timestamps = false;

    public $fillable = [
        'speciality',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'speciality' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function pmoWorkers()
    {
        return $this->hasMany(\App\Models\PmoWorker::class, 'speciality_id', 'id');
    }
}
