<?php

namespace App\DataTables;

use App\Models\AppUserCard;
use Form;
use Yajra\Datatables\Services\DataTable;
use Auth;

class AppUserCardDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->rawColumns(['action', 'number'])
            ->editColumn('number', function ($data) {

                $cardType = strpos($data->number, '5') === 0 ? url('assets/img/receipt/pay-methods/cards/visa.svg') : url('assets/img/receipt/pay-methods/cards/master.svg');
                $default = $data->default ? '<br/><span style="font-size:10px;" class="m-l-40 badge badge-inverse">Predeterminada</span>' : '';

                return <<<HTML
                <img src="{$cardType}" /> {$data->number}
                {$default}
HTML;
            })
            ->addColumn('action', 'user_panel.app_user_cards.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $appUserCards = AppUserCard::query()
            ->where('app_user_id', Auth::guard('appuser')->user()->id);

        return $this->applyScopes($appUserCards);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->addAction(['width' => '20%'])

            ->ajax('')
            ->parameters([
                'language' => ['url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'],
                'dom' => 'Bfrtip',
                'scrollX' => false,
                'buttons' => [
                    ["extend" => "reload", "text" => "<i class='fa fa-refresh'></i> Recargar"]
                ]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'no_tarjeta' => ['name' => 'number', 'data' => 'number'],
            'titular' => ['name' => 'owner', 'data' => 'owner'],
            'mes_expiracion' => ['name' => 'exp_month', 'data' => 'exp_month'],
            'año_expiracion' => ['name' => 'exp_year', 'data' => 'exp_year']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'appUserCards';
    }
}
