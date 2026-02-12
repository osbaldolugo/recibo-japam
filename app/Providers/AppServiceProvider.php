<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ToolsController;
use App\Models\Agent;
use App\Models\Comment;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\TicketitNotification;
use Auth;
use Collective\Html\FormFacade as CollectiveForm;
use DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Date\Date;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
        Schema::defaultStringLength(191);
        Date::setLocale('es');


        \Form::macro('notificaciones',function() use(& $html){

            $sum_comment= TicketitNotification::select(DB::raw("COUNT(id) AS sum_comment"))
                ->where("user_receipt_id","=",Auth::user()->id)
                ->where("view","=",0)->first();


            $notificaciones= TicketitNotification::with("comment")
                ->where("user_receipt_id","=",Auth::user()->id)
                ->where("view","=",0)
                ->take(5)
                ->orderBy('created_at','desc')->get();

            $html = "<li class='dropdown'>
                        <a href='javascript:;' data-toggle='dropdown' class='dropdown-toggle icon' aria-expanded='false'>
                            <i class='ion-ios-bell'></i>
                            <span class='label' id='notificaciones_number' data-count='".$sum_comment["sum_comment"]."'>".$sum_comment["sum_comment"]."</span>
                        </a>
                        <ul class='dropdown-menu media-list pull-right animated fadeInDown' id='notificaciones'>
                            <li class='dropdown-header'>Notificaciones</li>";

            foreach ($notificaciones as $notificacion){
                $html .= $notificacion->comment['html_notification'];
            }

            $html .= "<li class='dropdown-footer text-center'>
                                <a href='javascript:;'>Ver más</a>
                            </li>
                        </ul>
                    </li>";

            return $html;

        });


        function choose_action($notificaciones){
            $html ="";
            switch ($notificaciones["tipo_accion"]){
                case "create":
                    $html .=
                        '<i class="fa fa-plus text-green"></i> '. $notificaciones["descripcion"] .
                        '</div>'.
                        '</li>';
                    break;
                case "update":
                    $html .=
                        '<i class="fa fa-edit text-blue"></i> '. $notificaciones["descripcion"] .
                        '</div>'.
                        '</li>';
                    break;
                case "request":
                    $html .=
                        '<i class="fa fa-check-square-o text-red"></i> '. $notificaciones["descripcion"] .
                        '</div>'.
                        '</li>';
                    break;
            }

            return $html;

        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
