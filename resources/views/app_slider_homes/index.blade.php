@extends('layouts.app')

@section('content')
        @include('app_slider_homes.modal_app_slider_home')
        <div class="row">
                <div class="col-sm-12 col-lg-12 ui-sortable">
                        <div class="panel panel-default">
                                <div class="panel-heading">
                                        <div class="panel-heading-btn">
                                                <a class="btn btn-primary btn-xs pull-right bg-color-2 text-white" id="btnAddImage"><i class="glyphicon glyphicon-plus">&nbsp;</i>Agregar nueva</a>
                                        </div>
                                        <h4 class="panel-title"><i class="fa fa-image">&nbsp;</i>Slider Home</h4>
                                </div>

                                <div class="panel-body loading-content-index-slider-home">
                                        <div class="row col-lg-12 col-sm-12">
                                                <div class="clearfix"></div>
                                                @include('flash::message')
                                                <div class="clearfix"></div>
                                        </div>
                                        <div class="row col-lg-12 col-sm-12">
                                                <div class="mini-layout fluid">
                                                        <div class="mini-layout-body col-sm-12 col-lg-9">
                                                                @include('app_slider_homes.table')
                                                        </div>
                                                        <div class="mini-layout-sidebar col-sm-12 col-lg-3 bg-black p-0" style="border-radius: 5px;">
                                                                <div class="text-center p-t-5">
                                                                        <i class="fa fa-ellipsis-h fa-2x"></i>
                                                                </div>
                                                                <div class="p-t-5 p-r-10 p-l-10">
                                                                        <div>
                                                                                <img style="display: block; width: 100%" src="{{URL::to('img/app_slider_home/top.png')}}" alt="">
                                                                        </div>
                                                                </div>
                                                                <div class="owl-carousel p-r-10 p-l-10" style="height: 125px !important;">
                                                                        {{-- Slider --}}
                                                                </div>
                                                                <div class="p-b-10 p-r-10 p-l-10">
                                                                        <div>
                                                                                <img style="display: block; width: 100%" src="{{URL::to('img/app_slider_home/bottom.png')}}" alt="">
                                                                        </div>
                                                                </div>
                                                                <div class="text-center p-b-10">
                                                                        <i class="fa fa-circle-thin fa-3x text-white"></i>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
@endsection
