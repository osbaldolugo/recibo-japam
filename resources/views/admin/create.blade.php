<div class="modal fade" id="modal-user">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="modal-title-user">Agregar un nuevo usuario</h4>
                {{--{{ Form::hidden('route-update', null, ['id' => 'route-update']) }}--}}
                {{ Form::hidden('route', route('admin.users.store'), ['id' => 'route']) }}
                {{ Form::hidden('image-default', url('img/man.png'), ['id' => 'image-default']) }}
                {{ Form::hidden('image', URL::to('/') . '/../storage/app/public/user/', ['id' => 'image']) }}
            </div>
            <div class="modal-body">
                <form action="" id="frmUser" data-parsley-validate="true" data-parsley-excluded="[disabled], :hidden">
                    {{ Form::hidden('method', 'POST', ['id' => 'method']) }}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label text-uppercase">Categorías</label>
                                <div class="icheck-inline">
                                    <div class="row">
                                        @foreach($all_categories as $category)
                                            <div class="col-md-6 m-b-5">
                                                {{ Form::checkbox('category[]', $category->id, false, ['id' => 'category' . $category->id, 'class' => 'categories']) }}
                                                <label for="category{{$category->id}}">{{$category->name}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-6 pull-right">
                                    <div class="picture-container">
                                        <div class="picture">
                                            <img src="{{ url('img/man.png') }}" class="picture-src img img-responsive" id="wizardPicturePreview" title=""/>
                                            {!! Form::file('image', ['class' => 'filer', 'id' => 'wizard-picture', 'accept' => 'image/jpeg, image/png']) !!}
                                        </div>
                                        <h6 class="text-center">Elige tu fotografía de perfil</h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase" for="name">Nombre:</label>
                                        {{ Form::text('user[name]', null, ['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Nombre del usuario', 'required', 'data-parsley-error-message' => 'El nombre no puede quedar vacio']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase" for="email">Correo electrónico:</label>
                                        {{ Form::email('user[email]', null, ['id' => 'email', 'class' => 'form-control', 'placeholder' => 'Correo electrónico', 'required', 'data-parsley-error-message' => 'Es necesario establecer el usuario de Inicio de Sesión']) }}
                                    </div>
                                </div>
                                <div class="col-md-6" id="content-password">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase" for="password">Contraseña:</label>
                                        {{ Form::password('user[password]', ['id' => 'password', 'class' => 'form-control', 'placeholder' => 'Contraseña', 'data-parsley-minlength' => '8', 'required', 'data-parsley-error-message' => 'La contraseña no debe contener menos de 8 caracteres']) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            {{--{{ Form::checkbox('ticketit_admin', 1, false, ['id' => 'ticketit_admin']) }}--}}
                                            <input type="checkbox" id="ticketit_admin" value="1" name="user[ticketit_admin]" class="is-admin-all"/>
                                            <label class="control-label text-uppercase" for="ticketit_admin">&nbsp;Administrador</label>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            {{--{{ Form::checkbox('ticketit_agent', 1, false, ['id' => 'ticketit_agent']) }}--}}
                                            <input type="checkbox" id="ticketit_agent" value="1" name="user[ticketit_agent]" class="is-agent-all"/>
                                            <label class="control-label text-uppercase" for="ticketit_agent">&nbsp;Agente (Jefes de Área)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-sm btn-inverse" data-dismiss="modal">Cerrar</a>
                <a href="javascript:;" class="btn btn-sm btn-success" data-show-modal="2" id="btnSave"><i class="fa fa-send"></i>&nbsp;Guardar</a>
            </div>
        </div>
    </div>
</div>