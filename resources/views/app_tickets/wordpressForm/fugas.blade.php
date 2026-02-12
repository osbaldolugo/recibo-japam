@extends('layouts.app-user')
@section('css')
    <style>
        .barra_azul{
            padding: 23px;
            font-size: 1.5em;background-image:  linear-gradient(180deg,#013ca6 59%,#0898d5 100%); border-radius: 15px 15px 15px 15px; overflow: hidden;
        }
        .padding-imagenes{
            padding-left: 4vw;
        }
        .switchBtn {
            position: relative;
            display: inline-block;
            width: 110px;
            height: 34px;
        }
        .switchBtn input {display:none;}
        .slide {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            padding: 8px;
            color: #fff;
        }
        .slide:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 78px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }
        input:checked + .slide {
            background-color: #5da5e8;
            padding-left: 40px;
        }
        input:focus + .slide {
            box-shadow: 0 0 1px #01aeed;
        }
        input:checked + .slide:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
            left: -20px;
        }
        .slide.round {
            border-radius: 34px;
        }
        .slide.round:before {
            border-radius: 50%;
        }


        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .btn {
            cursor: pointer;
            border: 1px dashed #aaabac;
            color: #393939;
            padding: 8px 20px;
            border-radius: 4px;
            font-size: 17px;
            transition:all ease-out 80ms;
            margin-bottom:2px;
            margin-right: 8px;
        }
        .btn:hover{
            border: 1px solid #3daee9;
        }

        .upload-btn-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }
        .ocultar{
            display:none;
            cursor:pointer;
        }
        .centrado{
            text-align:center;
        }
        .margen-divs{
            margin: 30px auto;
        }
        .comentario{
            font-size: 13x;
            color: gray;
            font-weight: 400;
        }
        .flex{
            display:flex;
            max-width: 330px;
            margin: auto;
            align-items: end;
        }
        .fuente-formulario{
            font-size: 16px;
            font-weight: 400;
        }
        .fuente-formulario label{
         
            font-weight: 600;
        }
        .hijo{
            color: #065098;
            margin-bottom: 25px;
        }
        .cuerpo-panel{
            background-color: white;
            border-radius: 5px;
            padding: 15px;
        }
        .labels{
            font-size: 16px;
            font-weight:600;
            color: #393939;
        }
        .text-area{
            font-size: 17px;
            color: black;
            line-height: 31px;
            height: 136px;
        }
        .inputs{
            font-size: 17px;
            color: black;
            line-height: 31px;
            padding: 19px;
            margin-bottom: 3px;
        }
        .btn.btn-info {
            color: #71cae6;
            border: 1px solid #06509861;
            background: white;
        }
        .btn-crear-reporte{
            
            color: #fff ;
            background: #71cae6;
            border: 1px solid #fffc;
            
            padding: 8px 20px;
            border-radius: 4px;
            font-size: 17px;
            cursor:pointer;
            transition: all 80ms ease-in;
        }
        .btn-crear-reporte:hover{
            
            color: #fff ;
            background: #0b7ad5;
            border: 1px solid #fffc;
            box-shadow: 0 0 21px #0c71c394;
            
        }
        .texto-aceptar-terminos{
            font-weight: 400;
            padding-top: 15px;
        }
        .select-tipo{
            color: #fff;
            background: #71cae6 !important;
      
            cursor: pointer;

          
            padding: 8px 20px;
            border-radius: 4px;
            font-size: 17px;
            transition: all ease-out 80ms;
            margin-bottom: 2px;
            margin-right: 8px;
        }
        .col-md-3{
            width: 25%;
            text-align:right;
        }
          .div-links{
            text-align:center; margin-bottom: 30px;display: flex;width: 100%;
        }
        @media only screen and (max-width: 600px) {
                .cuerpo-panel{
                
                padding: 5px;
            }
            .div-links{
                text-align:left;
                margin-bottom: 30px;
                display: grid;
                width: 100%;
            }
            .col-md-3 {
                width: 100%;
                text-align: left;
            }
            .col-md-12{
                padding-right: 6px;
                padding-left: 6px;
            }
            .page-header-fixed {
                padding-top: 12px;
            }
        }
    </style>
@endsection
@section('scripts')

@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div style="border-radius: 10px" class="col-md-10 ">
                <h2 class="hijo">Reportar Fuga</h2>
            </div>
            
            <div style="margin-top: 5%;" class="text-center">
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
            </div>
            <div class="div-links" >
            </div>
            <div class="panel-body cuerpo-panel ">

                <form action="{{route('guardarreporteFuga')}}" method="post" enctype="multipart/form-data" class="col-md-12 fuente-formulario">
                    {!! csrf_field() !!}

                    <!-- Selección del tipo de fuga -->
                    <div style="margin-top: 5%;" class="col-md-12 margen-divs">
                        <div class="col-md-3">
                            <label for="type">Seleccione el tipo de fuga</label>
                        </div>
                        <div id="res" style="border: none; " class="col-md-9 sel ">
                            <select  class="select-tipo" name="report_type">
                                <option>Fuga en medidor</option>
                                <option>Fuga en banqueta</option>
                                <option>Fuga en la calle</option>
                            </select>
                        </div>
                    </div>

                        <input style="display: none" autocomplete="off" type="text" class="form-control " id="type" name="type" value="Reporte"/>
                        <!--domicilio-->
                    <div style="" class="form-group col-md-12 margen-divs">
                        <div class="col-md-3 sel">
                            <label for="description">Domicilio</label>
                        </div>
                        <div class="col-md-9 ">
                            <input class="form-control inputs"  maxlength="250" id="address" name="address" placeholder="Calle, número y colonia">
                            <input style="display: none" class="form-control " id="latitude" name="latitude" value="20.388830">
                            <input style="display: none" class="form-control " id="longitude" name="longitude" value="-99.996432">
                            <input style="display: none" readonly class="form-control " id="origen" name="origen" value="web">

                        </div>


                    </div>

                    <!--Número de contrato-->
                    <div style=";" class="form-group col-md-12 margen-divs           ">
                        <div class="col-md-3 sel">
                            <label for="description">Número de contrato</label>
                        </div>
                        <div class="col-md-9">
                            <input class="form-control  inputs "  maxlength="20" id="contract" name="contract" placeholder="Número de contrato">
                        </div>
                    </div>

                    <!--medidor-->
                    <div style="" class="form-group col-md-12 margen-divs">
                        <div class="col-md-3 sel">
                            <label for="description">Medidor</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control inputs " id="meter"  maxlength="15" name="meter" placeholder="Número del medidor">
                        </div>
                    </div>
                    <!--nombre-->
                    <div style=";" class="form-group col-md-12 margen-divs">
                        <div class="col-md-3 sel">
                            <label for="description">Nombre</label>
                        </div>

                        <div class="col-md-9">
                            <div class="col-md-4">
                                <input class=" form-control inputs" id="name" name="name" placeholder="Nombre(s)">
                            </div>
                            <div class="col-md-4">
                                <input class=" form-control inputs" id="last_name1" name="last_name_1" placeholder="Apellido paterno">
                            </div>
                            <div class="col-md-4">
                                <input class=" form-control inputs" id="last_name2" name="last_name_2" placeholder="Apellido materno">
                            </div>
                        </div>
                    </div>
                    <!--email-->
                    <div style="" class="form-group col-md-12 margen-divs">
                        <div class="col-md-3 sel">
                            <label for="description">Correo electrónico</label>
                        </div>
                        <div class="col-md-9">
                            <input type="email" class="form-control inputs" id="email" name="email" placeholder="E-mail">
                        </div>
                    </div>
                    <!--telefono--> 
                    <div style="" class="form-group col-md-12 margen-divs">
                        <div class="col-md-3 sel">
                            <label for="description">Telefono celular</label>
                        </div>
                        <div class="col-md-9">
                            <input type="number" class="form-control inputs" id="phone_number" name="phone_number" placeholder="Número de teléfono">
                        </div>
                    </div>
                    <!--imagen-->
                    <div style="" class="form-group col-md-12 margen-divs">
                        <div class="col-md-3 sel">
                            <label for="image" class="labels">Imagen <span class="comentario "> (Opcional) </span> </label>
                            <label class="comentario" style="font-size: 14px;">
                                Seleccione una imagen<br>
                                
                                    Tamaño máximo 15MB
                                    Tipos permitidos: jpg, jpeg, png
                                
                            </label>
                        </div>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                        
                        <div class="upload-btn-wrapper margen-divs" style="margin-left: 15px;">
                            
                             <div class="input-group" onclick="readURL()" class="btn">
                                <label class="input-group-btn btn ">
                                    <span class="">
                                      <i class="fa fa-picture-o"></i>    Adjunta una imagen  <input multiple="multiple" type="file" name="url_image" id="url_image" class="ocultar">
                                    </span>
                                </label>
                               
                            </div>
                        </div>
                        <script>
                            function readURL(input) {
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();

                                    reader.onload = function(e) {
                                        $('#blah').attr('src', e.target.result);
                                    }

                                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                                }
                            }

                            $("#url_image").change(function() {
                                readURL(this);
                            });
                        </script>
                    </div>
                    <!--description-->
                    <div style="margin-top: 5%;" class="form-group col-md-12 margen-divs">
                        <div class="col-md-3 sel">
                            <label for="description">Descripción</label>
                        </div>
                        <div class="col-md-9">
                            <textarea spellcheck="false" class="text-area form-control "  maxlength="250" id="description" name="description" placeholder="Describe brevemente tu inconveniente" required></textarea>
                        </div>
                    </div>
                    <!--terminos y condiciones-->
                    <div style="" class="form-group col-md-12 margen-divs">
                         <div class="flex ">
                        <div class=" sel" style="width:70px;">
                            <input type="checkbox" class="form-control bg-silver" required>
                        </div>
                        <div class=" centrado "><label class=" centrado texto-aceptar-terminos" style="" for="description">Acepta terminos y condiciones</label></div>     
                        </div>
                        

                    </div>

                    <hr>
                    
                    <div class="boton centrado">
                        <button style="margin-bottom: 50px;" type="submit" class="btn-crear-reporte">Crear reporte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @includeIf('app_tickets.wordpressForm.barraInferior')

@endsection
