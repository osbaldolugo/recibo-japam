<div class="row">
    <div class="col-lg-6">
        <!-- Title Field -->
        <div class="form-group col-lg-8">
            {!! Form::label('titlePush', 'Titulo') !!}
            {!! Form::text('titlePush', null, ['class' => 'form-control', 'id'=>'txtTitlePush', 'maxlength'=>30, 'required'=>true,
                'data-parsley-trigger'=>'keyup', 'data-parsley-minlength' => '5', 'data-parsley-maxlength' => '30',
                'data-parsley-minlength-message' => 'Ingresa por lo menos 10 caracteres', 'data-parsley-validation-threshold' => '5'
            ]) !!}
            <span style="display:inline;"></span>
        </div>
        <!-- Description Field -->
        <div class="form-group col-sm-12 col-lg-12">
            {!! Form::label('bodyPush', 'Mensaje') !!}
            {!! Form::textarea('bodyPush', null, ['class' => 'form-control input-sm', 'rows' => '1', 'id'=>'txtBodyPush','maxlength'=>90, 'required'=>true]) !!}
        </div>
    </div>
    <div class="col-lg-6">
        <div id="iphone" style="display: block;">
            <div id="ios-push-container">
                <p id="ios-push-appname" class="push-p">Japam Móvil</p>
                <p id="ios-push-body" class="push-p">
                    <b id="textTitlePush"></b><br>
                    <span id="textBodyPush"></span>
                </p>
            </div>
        </div>
    </div>
</div>