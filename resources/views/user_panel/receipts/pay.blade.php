@extends('layouts.app-user')

@section('content')

    @include('auth-app-user.terms')
    @include('user_panel.receipts.modals.receiptPdf')

    @if($isPaid && $isPaid->pay_status=='pagado')
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <div class="card text-center">
                    <div class="card-header">
                        Recibo
                    </div>
                    <div class="card-block text-center">
                        <img src="{!! url('assets/img/receipt/icon.png') !!}" alt=""
                             class="img img-responsive img-paid-receipt">
                        <h4 class="card-title">Este recibo ya se encuentra pagado</h4>

                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        No Recibo <b>{{$receiptDetail["receiptId"]}}</b>
                                    </li>
                                    <li class="list-group-item">
                                        Titular <b>{{$receiptDetail["name"]}} </b><br/>
                                            <span class="badge badge-primary">{{$receipt->alias}}</span>
                                    </li>
                                    <li class="list-group-item">
                                        Importe <b>${{$receiptPayment["headers"]["amount"]}}</b>
                                    </li>
                                </ul>
                            </div>
                        </div>


                        <a href="{{route('receipts.indexWeb')}}" class="btn btn-sm btn-primary">Ir a mis recibos</a>
                    </div>

                </div>
            </div>
        </div>

    @else
        <div class="row">
            <div class="col-lg-5">
                @include('user_panel.receipts.receipt-contract')
            </div>
            <div class="col-lg-7">
                @include('user_panel.receipts.pay-method')
            </div>
        </div>

    @endif



    <a id="DATA" data-receipt-status="{{$isPaid && $isPaid->pay_status=='pagado'? 'locked':'free'}}"></a>

@endsection()

@section('css')
    {{Html::style('css/user_panel/receipts/pay.css')}}
    {{Html::style('assets/plugins/parsley/src/parsley.css')}}
    {{Html::style('assets/plugins/bootstrap-toastr/toastr.min.css')}}
    {{Html::style('assets/plugins/switchery/switchery.min.css')}}

@endsection()

@section('scripts')
    {!!Html::script('assets/plugins/bootstrap-toastr/toastr.min.js')!!}
    {!!Html::script('assets/plugins/switchery/switchery.min.js')!!}
    {{Html::script('assets/plugins/parsley/dist/parsley.js')}}
    {{Html::script('assets/plugins/parsley/i18n/es.min.js')}}
    {{Html::script('assets/plugins/blockUI/blockui.min.js')}}
    {{Html::script('js/utils.js')}}
    {{Html::script('js/user_panel/cards/validate.js')}}
    {{Html::script('js/user_panel/receipts/pay.js')}}
@endsection




