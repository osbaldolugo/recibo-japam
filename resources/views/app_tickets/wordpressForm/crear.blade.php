<form action="{{route('onclicks.save')}}" method="post" class="col-md-12">
    {!! csrf_field() !!}
    @if(session('message'))
        <div class="alert alert-success">
            {{session('message')}}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
@endif
<!--titulo-->
    <div class="form-group col-md-12">
        <div class="col-md-3 sel">
            <label for="title">Titulo</label>
        </div>
        <div class="col-md-9">
            <input autocomplete="off" type="text" class="form-control bg-silver" id="click_consulta_web" name="click_consulta_web" value="0"/>
        </div>
    </div>
    <div class="form-group col-md-12">
        <div class="col-md-3 sel">
            <label for="title">Titulo</label>
        </div>
        <div class="col-md-9">
            <input autocomplete="off" type="text" class="form-control bg-silver" id="click_consulta_app" name="click_consulta_app" value="0"/>
        </div>
    </div>
    <div class="form-group col-md-12">
        <div class="col-md-3 sel">
            <label for="title">Titulo</label>
        </div>
        <div class="col-md-9">
            <input autocomplete="off" type="text" class="form-control bg-silver" id="click_pagolink_web" name="click_pagolink_web" value="1"/>
        </div>
    </div>
    <div class="form-group col-md-12">
        <div class="col-md-3 sel">
            <label for="title">Titulo</label>
        </div>
        <div class="col-md-9">
            <input autocomplete="off" type="text" class="form-control bg-silver" id="click_pagolink_app" name="click_pagolink_app" value="0"/>
        </div>
    </div>

    <hr>
    <div class="boton">
        <button style="margin: 5%; width: 30%" type="submit" class="btn btn-success">Hacer token</button>
    </div>
</form>