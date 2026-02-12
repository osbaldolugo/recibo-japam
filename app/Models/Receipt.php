<?php

namespace App\Models;

use Eloquent as Model;
use DB;
use App\Libraries\ApiJapam;


/**
 * Class Receipt
 * @package App\Models
 * @version January 4, 2018, 4:42 pm CST
 *
 * @property \Illuminate\Database\Eloquent\Collection branchOfficeSchedule
 * @property \Illuminate\Database\Eloquent\Collection ReceiptUser
 * @property string contract
 * @property string meter
 * @property string barcode
 */
class Receipt extends Model
{

    public $table = 'receipt';

    public $timestamps = false;


    protected $primaryKey = 'id';

    public $fillable = [
        'contract',
        /*'barcode',*/
        'alias',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'contract' => 'string',
        /*'barcode' => 'string',*/
        'alias' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function receiptUsers()
    {
        return $this->hasMany(\App\Models\ReceiptUser::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function peopleUnlogged()
    {
        return $this->Hasmany(\App\Models\PeopleUnlogged::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user() {
        return $this->belongsToMany('App\Models\AppUser', 'receipt_user', 'receipt_id', 'app_user_id');
    }

    public static function createReceipt($data, $appUser)
    {
        $apiJapam = new ApiJapam();

        try {
            DB::beginTransaction();
            $isValidContract = $apiJapam->receiptGeneralDetails($data["contract"]/*, $data["barcode"]*/);

            if (empty($isValidContract)) {
                return response()->json(['errors' => 'La información ingresada no es válida'])->setStatusCode(422);
            } else {
                $existContract = $appUser->receipts()->where('contract', '=', $data["contract"])->first();

                if ($existContract) {
                    return response()->json(['errors' => ["contract" => 'El recibo ' . $data['contract'] . ' ya ha sido registrado.']])->setStatusCode(422);
                }
                $receipt = Receipt::create($data);
                $receiptUser = ReceiptUser::create(['receipt_id' => $receipt->id, 'app_user_id' => $appUser->id]);
            }
            DB::commit();
            return response()->json([
                'success' => 1,
                'message' => 'Recibo ' . $data['contract'] . ' registrado correctamente.',
                'msg' => 'Recibo ' . $data['contract'] . ' registrado correctamente.'
            ]);
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json([
                'success' => 0,
                'message' => 'El Recibo ' . $data['contract'] . ' no se registro.',
                'msg' => 'El Recibo ' . $data['contract'] . ' no se registro.'
            ]);
        }
    }
}
