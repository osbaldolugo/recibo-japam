@extends(Auth::guard('appuser')->user() ? 'layouts.app-user' : 'layouts.app-guest')

@section('content')
    <div class="row">
        <div class="panel panel-inverse" data-sortable-id="ui-general-2">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                {{--<h4 class="panel-title">Solicitar una cita</h4>--}}
            </div>
            <div class="panel-body">
                    <!-- begin #content -->
                    <div id="content" class="content">
                        <!-- begin breadcrumb -->
                        <!-- end breadcrumb -->
                        <!-- begin page-header -->
                        <h1 class="page-header">Perfil de usuario <small>Información principal del usuario</small></h1>
                        <!-- end page-header -->
                        <!-- begin profile-container -->
                        <div class="profile-container">
                            <!-- begin profile-section -->
                            <div class="profile-section">
                                <!-- begin profile-left -->
                                <div class="profile-left">
                                    <!-- begin profile-image -->
                                    <div class="profile-image">
                                        <img src="assets/img/profile-cover.jpg" />
                                        <i class="fa fa-user hide"></i>
                                    </div>
                                    <!-- end profile-image -->
                                    <div class="m-b-10">
                                        {{--<a href="#" class="btn btn-warning btn-block btn-sm">Change Picture</a>--}}
                                    </div>
                                    <!-- begin profile-highlight -->
                                    <div class="profile-highlight">
                                        <h4><i class="fa fa-cog"></i> Only My Contacts</h4>

                                    </div>
                                    <!-- end profile-highlight -->
                                </div>
                                <!-- end profile-left -->
                                <!-- begin profile-right -->
                                <div class="profile-right">
                                    <!-- begin profile-info -->
                                    <div class="profile-info">
                                        <!-- begin table -->
                                        <div class="table-responsive">
                                            <table class="table table-profile">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>
                                                        <h4>Micheal	Meyer <small>Lorraine Stokes <a href="#" class="m-l-5">Edit</a></small></h4>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="field">Teléfono</td>
                                                    <td><i class="fa fa-mobile fa-lg m-r-5"></i> +1-(847)- 367-8924 <a href="#" class="m-l-5">Edit</a></td>
                                                </tr>
                                                <tr class="divider">
                                                    <td colspan="2"></td>
                                                </tr>
                                                <tr class="highlight">
                                                    <td class="field">E-mail</td>
                                                    <td><a href="#"></a></td>
                                                </tr>
                                                <tr class="divider">
                                                    <td colspan="2"></td>
                                                </tr>

                                                {{--<tr>
                                                    <td class="field">Gender</td>
                                                    <td>
                                                        <select class="form-control input-inline input-xs" name="gender">
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                        </select>
                                                    </td>
                                                </tr>--}}

                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- end table -->
                                    </div>
                                    <!-- end profile-info -->
                                </div>
                                <!-- end profile-right -->
                            </div>
                            <!-- end profile-section -->
                            <!-- begin profile-section -->
                            <div class="profile-section">
                                <!-- begin row -->
                                <div class="row">
                                    <!-- begin col-4 -->
                                    <div class="col-md-6">
                                        <h4 class="title">Recibos <small>Dados de alta</small></h4>
                                        <!-- begin scrollbar -->
                                        <div data-scrollbar="true" data-height="280px" class="bg-silver">
                                            <!-- begin table -->
                                            <table class="table table-condensed">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Product</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="col-md-1 p-r-5">
                                                        <a href="javascript:;" class="pull-left">
                                                            <img src="assets/img/product/product-1.png" width="40px" alt="">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <h5 class="m-t-0 m-b-5">iPad Air 3</h5>
                                                    </td>
                                                    <td>$349.00</td>
                                                    <td>13/02/2013</td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-1 p-r-5">
                                                        <a href="javascript:;" class="pull-left">
                                                            <img src="assets/img/product/product-2.png" width="40px" alt="">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <h5 class="m-t-0 m-b-5">Iphone6</h5>
                                                    </td>
                                                    <td>$399.00</td>
                                                    <td>13/02/2013</td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-1 p-r-5">
                                                        <a href="javascript:;" class="pull-left">
                                                            <img src="assets/img/product/product-3.png" width="40px" alt="">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <h5 class="m-t-0 m-b-5">Macbook Pro</h5>
                                                    </td>
                                                    <td>$499.00</td>
                                                    <td>13/02/2013</td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-1 p-r-5">
                                                        <a href="javascript:;">
                                                            <img src="assets/img/product/product-4.png" width="40px" alt="">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <h5 class="m-t-0 m-b-5">Samsung Galaxy s4</h5>
                                                    </td>
                                                    <td>$230.00</td>
                                                    <td>13/02/2013</td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-1 p-r-5">
                                                        <a href="javascript:;" class="pull-left">
                                                            <img src="assets/img/product/product-5.png" width="40px" alt="">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <h5 class="m-t-0 m-b-5">Samsung Note 4</h5>
                                                    </td>
                                                    <td>$500.00</td>
                                                    <td>13/02/2013</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!-- end table -->
                                        </div>
                                        <!-- end scrollbar -->
                                    </div>
                                    <!-- end col-4 -->
                                    <!-- begin col-4 -->
                                    <div class="col-md-6">
                                        <h4 class="title">Quejas Realizadas <small></small></h4>
                                        <!-- begin scrollbar -->
                                        <div data-scrollbar="true" data-height="280px" class="bg-silver">
                                            <!-- begin table -->
                                            <table class="table table-condensed">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Product</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="col-md-1 p-r-5">
                                                        <a href="javascript:;" class="pull-left">
                                                            <img src="assets/img/product/product-1.png" width="40px" alt="">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <h5 class="m-t-0 m-b-5">iPad Air 3</h5>
                                                    </td>
                                                    <td>$349.00</td>
                                                    <td>13/02/2013</td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-1 p-r-5">
                                                        <a href="javascript:;" class="pull-left">
                                                            <img src="assets/img/product/product-2.png" width="40px" alt="">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <h5 class="m-t-0 m-b-5">Iphone6</h5>
                                                    </td>
                                                    <td>$399.00</td>
                                                    <td>13/02/2013</td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-1 p-r-5">
                                                        <a href="javascript:;" class="pull-left">
                                                            <img src="assets/img/product/product-3.png" width="40px" alt="">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <h5 class="m-t-0 m-b-5">Macbook Pro</h5>
                                                    </td>
                                                    <td>$499.00</td>
                                                    <td>13/02/2013</td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-1 p-r-5">
                                                        <a href="javascript:;">
                                                            <img src="assets/img/product/product-4.png" width="40px" alt="">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <h5 class="m-t-0 m-b-5">Samsung Galaxy s4</h5>
                                                    </td>
                                                    <td>$230.00</td>
                                                    <td>13/02/2013</td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-1 p-r-5">
                                                        <a href="javascript:;" class="pull-left">
                                                            <img src="assets/img/product/product-5.png" width="40px" alt="">
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <h5 class="m-t-0 m-b-5">Samsung Note 4</h5>
                                                    </td>
                                                    <td>$500.00</td>
                                                    <td>13/02/2013</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!-- end table -->
                                        </div>
                                        <!-- end scrollbar -->
                                    </div>
                                    <!-- end col-4 -->
                                </div>
                                <!-- end row -->
                            </div>
                            <!-- end profile-section -->
                        </div>
                        <!-- end profile-container -->
                    </div>
                    <!-- end #content -->
                </div>
                <!-- end page container -->
            </div>
        </div>
    </div>
@endsection
