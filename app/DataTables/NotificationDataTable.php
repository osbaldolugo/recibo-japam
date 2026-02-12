<?php

namespace App\DataTables;

use App\Models\Notification;
use Form;
use Yajra\Datatables\Services\DataTable;

class NotificationDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'notifications.datatables_actions')
            ->rawColumns(['url_image', 'begin_date', 'end_date', 'action'])
            ->editColumn('url_image', function ($notification) {
                $notification = url('../storage/app/japam/notification/'.$notification->url_image);
                return '<img src="'.$notification.'" style="width: 70px; height:50px; margin: 0 auto; border-radius: 5px;">';
            })
            ->editColumn('begin_date', function ($notification) {
                $beginDate = (!empty($notification->begin_date)) ? date("d-m-Y", strtotime($notification->begin_date)) : "N/A";
                return $beginDate;
            })
            ->editColumn('end_date', function ($notification) {
                $endDate = (!empty($notification->end_date)) ? date("d-m-Y", strtotime($notification->end_date)) : "N/A";
                return $endDate;
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $notifications = Notification::query();

        return $this->applyScopes($notifications);
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
            ->addAction(['width' => '10%'])
            ->ajax('')
            ->parameters([
                'responsive'=>true,
                'language' =>[
                    'url' =>url('assets/plugins/DataTables/lang/es.json')
                ],
                'dom' => 'Bfrtip',
                'scrollX' => false,
                'buttons' => [
                    ['extend' => 'reload', 'className' => 'btn btn-xs btn-white-without-border', 'text' => '<i class="fa fa-repeat"></i> Recargar'],
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
            'Imagen' => ['name' => 'url_image', 'data' => 'url_image'],
            'T&iacute;tulo' => ['name' => 'title', 'data' => 'title'],
            'Descripci&oacute;n' => ['name' => 'description', 'data' => 'description'],
            'Informaci&oacute;n Adicional' => ['name' => 'url_info', 'data' => 'url_info'],
            'FechaInicio' => ['name' => 'begin_date', 'data' => 'begin_date'],
            'FechaFin' => ['name' => 'end_date', 'data' => 'end_date']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'notifications';
    }
}
