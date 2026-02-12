<?php

namespace App\Console\Commands;

use DB;
use Log;
use Carbon\Carbon;
use App\Models\PayControl;
use App\Libraries\ApiSrPago;
use Illuminate\Console\Command;

class CheckPays extends Command
{
    private $apiSrPago;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pays:checkpay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if payments have been made at convenience stores';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->apiSrPago = new ApiSrPago();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data['startDate'] = Carbon::now()->firstOfMonth()->toDateString();
        $data['endDate'] = Carbon::now()->lastOfMonth()->toDateString();
        $data['paymentMethod'] = 'OXX';
        $operations = $this->apiSrPago->operations($data);
        try
        {
            DB::beginTransaction();
            foreach ($operations['operations'] as $pay) {
                $reference = explode('#',$pay['reference']['description']);
                $reference = explode('.',$reference[1]);
                $contract = $reference[0];

                $payControl = PayControl::where('contract', $contract)->get()->last();

                if(!is_null($payControl))
                {
                    $payControl->update(['pay_date'=>$pay['timestamp'], 'pay_status'=>'pagado']);
                }
                unset($payControl);
            }
            DB::commit();
            Log::info("Pagos activados correctamente");
            echo 'Pagos activados correctamente';
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error("Ocurrio un error al activar el pago: ".$e);
        }
    }
}
