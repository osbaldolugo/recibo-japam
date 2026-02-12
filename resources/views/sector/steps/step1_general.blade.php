<fieldset>
    <legend class="pull-left width-full">Información General</legend>
    <!-- begin row -->
    <div class="form-horizontal">
        <!-- begin col-4 -->
        <!-- Code Field -->
        <div class="form-group col-sm-12">
            <!-- id_sector Field -->
            <div class="form-group col-sm-4 hidden">
                {!! Form::label('id_sector', 'id_sector:') !!}
                {!! Form::text('sector[id_sector]', isset($sector["id"])?$sector["id"]:null, ["id"=>'id_sector','class' => 'form-control',"data-parsley-group" =>"wizard-step-1"]) !!}
            </div>

            <!-- code Field -->
            <div class="form-group col-sm-4">
                {!! Form::label('code', 'Código:') !!}
                {!! Form::text('sector[code]', isset($sector["code"])?$sector["code"]:null, ['class' => 'form-control',"data-parsley-group" =>"wizard-step-1","required"=>"true"]) !!}
            </div>

            <!-- name Field -->
            <div class="form-group col-sm-4 col-sm-push-1">
                {!! Form::label('name', 'Nombre:') !!}
                {!! Form::text('sector[name]', isset($sector["name"])?$sector["name"]:null, ['class' => 'form-control',"data-parsley-group" =>"wizard-step-1","required"=>"true"]) !!}
            </div>

            <!-- background Field -->
            <div class="form-group col-sm-2 col-sm-push-2">
                {!! Form::label('background', 'Color:') !!}
                {!! Form::text('sector[background]', isset($sector["background"])?$sector["background"]:null, ['id'=>'colorpicker','class' => 'form-control colorpicker-element',"data-parsley-group" =>"wizard-step-1"]) !!}
            </div>
        </div>
        <div class="form-group col-sm-12">
            {!! Form::label('dotsSection', 'Mapa de la sección:') !!}
            <div id="map" style="height: 500px !important" class="height-md width-full col-md-12"></div>

            <table id="tableDots" class="hidden">
                <tbody>
                @if(isset($sectorDots))
                    @foreach ($sectorDots as $d => $dot)
                        <tr>
                            <td><input name="sectorDots[lat][{{$d}}]" value="{{ $dot->lat }}" /></td>
                            <td><input name="sectorDots[lng][{{$d}}]" value="{{ $dot->lng }}" /></td>
                        </tr>
                    @endforeach

                @endif
                </tbody>
            </table>

            <table id="tableDotsAux">
                <tbody>
                </tbody>
            </table>
        </div>

        <!-- end col-4 -->
    </div>


    <!-- end row -->
</fieldset>
