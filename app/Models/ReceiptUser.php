<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class ReceiptUser
 * @package App\Models
 * @version January 4, 2018, 4:43 pm CST
 *
 * @property \App\Models\Receipt receipt
 * @property \App\Models\AppUser appUser
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property integer receipt_id
 * @property integer app_user_id
 */
class ReceiptUser extends Model
{

    public $table = 'receipt_user';
    
    public $timestamps = false;


    protected $primaryKey = 'id';

    public $fillable = [
        'receipt_id',
        'app_user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'receipt_id' => 'integer',
        'app_user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function receipt()
    {
        return $this->belongsTo(\App\Models\Receipt::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function appUser()
    {
        return $this->belongsTo(\App\Models\AppUser::class);
    }
}
