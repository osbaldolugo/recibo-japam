@extends('layouts.app-user')
@section('title', 'Crear Cuenta')
@section('content')

    <style type="text/css">
    .eme{
        width:100%;
    }
        .emergente{
            position: fixed;
            width: 100vw;
           
            background: black;
            z-index: 14;
            box-shadow: 0 0 10px black;
            left: 0;
            top:45px ;
            opacity:0;
            height:0;
            
        }
        .oculto{
            opacity:0;
        }
        .btn-pimary2{
            background:#71cae6;
        }
    </style>
    <div id="emergente" class="emergente">
        <object id="svg" type="image/svg+xml" data="img/registro/gracias.svg" style="width: 100%;max-height: calc(100vh - 50px);height: 0;"></object>

  
        </div>
    <!-- begin register-content -->
    <div class="card">
        <div class="col-md-2"></div>
        <div style="background-color: white;border-left: 16px solid white;border-right: 16px solid white;" class=" login-content">
            <div style="background-color: #71cae6; width: calc(100% + 32px);transform: translateX(-16px);" class="card-header">
                <p style="color: #ffffff;">Registrar nuevo usuario</p>
            </div>
            <form id="formulario" class="form-horizontal" role="form" method="POST" action="{{ url(route('appUser.register')) }}">
            {!! csrf_field() !!}
            <!--<form action="http://seantheme.com/color-admin-v3.0/admin/apple/index.html" method="POST" class="margin-bottom-0">-->
                <label class="control-label">
                     <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="transform: rotate(360deg) translateY(2px);width: 25px;height: 25px;" preserveAspectRatio="xMidYMid meet" viewBox="0 0 26 26"><path d="M16.563 15.9c-.159-.052-1.164-.505-.536-2.414h-.009c1.637-1.686 2.888-4.399 2.888-7.07c0-4.107-2.731-6.26-5.905-6.26c-3.176 0-5.892 2.152-5.892 6.26c0 2.682 1.244 5.406 2.891 7.088c.642 1.684-.506 2.309-.746 2.397c-3.324 1.202-7.224 3.393-7.224 5.556v.811c0 2.947 5.714 3.617 11.002 3.617c5.296 0 10.938-.67 10.938-3.617v-.811c0-2.228-3.919-4.402-7.407-5.557z" fill="#043CA5 "/></svg>
                     Nombre(s) <span class="text-danger">*</span></label>
                <div class="row row-space-10">
                    <div class="col-md-6 m-b-15">
                        <input type="text" minlength="3" maxlength="24" class="form-control" placeholder="Nombre" required name="name" value="{{ old('name') }}"/>
                    </div>
                    <div class="col-md-6 m-b-15">
                        <input type="text" class="form-control"  minlength="3" maxlength="24" placeholder="Apellidos" required name="lastnames" value="{{ old('lastnames') }}"/>
                    </div>
                </div>
                <label class="control-label">
                     <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="transform: rotate(360deg) translateY(6px);width: 30px;height: 30px;" preserveAspectRatio="xMidYMid meet" viewBox="0 0 36 36"><path d="M25 4H11a2 2 0 0 0-2 2v24a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zM11 6h14v18H11zm0 24v-4h14v4z" class="clr-i-outline clr-i-outline-path-1" fill="#043CA5 "/><path class="clr-i-outline clr-i-outline-path-2" d="M17 27h2v2h-2z" fill="#043CA5 "/></svg>
                     Número de Celular <span class="text-danger">*</span></label>
                <div class="row m-b-15">
                    <div class="col-md-12">
                        <input type="number" class="form-control" placeholder="Número de Celular" required  name="phoneNumber" value="{{ old('phoneNumber') }}" placeholder="(427) 129-0073" title="427-129-0073" data-inputmask='"mask": "999-999-9999"' data-mask/>
                    </div>
                </div>
                <label class="control-label">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="transform:rotate(320deg) translate(2px,0px);width: 25px;height: 25px;" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M16.484 11.976l6.151-5.344v10.627zm-7.926.905l2.16 1.875c.339.288.781.462 1.264.462h.017h-.001h.014c.484 0 .926-.175 1.269-.465l-.003.002l2.16-1.875l6.566 5.639H1.995zM1.986 5.365h20.03l-9.621 8.356a.612.612 0 0 1-.38.132h-.014h.001h-.014a.61.61 0 0 1-.381-.133l.001.001zm-.621 1.266l6.15 5.344l-6.15 5.28zm21.6-2.441c-.24-.12-.522-.19-.821-.19H1.859a1.87 1.87 0 0 0-.835.197l.011-.005A1.856 1.856 0 0 0 0 5.855V18.027a1.86 1.86 0 0 0 1.858 1.858h20.283a1.86 1.86 0 0 0 1.858-1.858V5.859v-.004c0-.727-.419-1.357-1.029-1.66l-.011-.005z" fill="#043CA5 "/></svg>
                    
                     Correo Electrónico <span class="text-danger">*</span></label>
                <div class="row m-b-15 {{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <input onkeyup="checar_emails();" type="text" class="form-control" placeholder="Correo Electrónico" required name="email" id="email_1" value="{{ old('email') }}"/>
                        @if ($errors->has('email'))
                            <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                 <label class="control-label"> 
                 <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="transform: rotate(320deg) translate(2px,0px);width: 25px;height: 25px;" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M16.484 11.976l6.151-5.344v10.627zm-7.926.905l2.16 1.875c.339.288.781.462 1.264.462h.017h-.001h.014c.484 0 .926-.175 1.269-.465l-.003.002l2.16-1.875l6.566 5.639H1.995zM1.986 5.365h20.03l-9.621 8.356a.612.612 0 0 1-.38.132h-.014h.001h-.014a.61.61 0 0 1-.381-.133l.001.001zm-.621 1.266l6.15 5.344l-6.15 5.28zm21.6-2.441c-.24-.12-.522-.19-.821-.19H1.859a1.87 1.87 0 0 0-.835.197l.011-.005A1.856 1.856 0 0 0 0 5.855V18.027a1.86 1.86 0 0 0 1.858 1.858h20.283a1.86 1.86 0 0 0 1.858-1.858V5.859v-.004c0-.727-.419-1.357-1.029-1.66l-.011-.005z" fill="#043CA5 "/></svg>
                 
                  Confirmar Correo <span class="text-danger">*</span></label>
                <div class="row m-b-15">
                    <div class="col-md-12">
                        <input  onkeyup="checar_emails();" type="text" class="form-control" placeholder="Confirmar Correo Electrónico" id="email_2" required name="email_confirmation"/>
                    </div>
                    <div class="col-md-12">
                        <span class="text-danger" id="mensaje_emails"></span>
                    </div>
                </div>
                <label class="control-label">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="transform: rotate(360deg) translateY(6px);width: 25px;height: 25px;" preserveAspectRatio="xMidYMid meet" viewBox="0 0 15 15"><g fill="none"><path d="M12.5 8.5v-1a1 1 0 0 0-1-1h-10a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-1m0-4h-4a2 2 0 1 0 0 4h4m0-4a2 2 0 1 1 0 4m-9-6v-3a3 3 0 0 1 6 0v3m2.5 4h1m-3 0h1m-3 0h1" stroke="#043CA5 "/></g></svg> 
                    Contraseña <span class="text-danger">*</span></label>
                <div class="row m-b-15 {{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <input type="password" class="form-control" placeholder="*****" required name="password"/>
                        @if ($errors->has('password'))
                            <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <label class="control-label">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="transform: rotate(360deg) translateY(6px);width: 25px;height: 25px;" preserveAspectRatio="xMidYMid meet" viewBox="0 0 15 15"><g fill="none"><path d="M12.5 8.5v-1a1 1 0 0 0-1-1h-10a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-1m0-4h-4a2 2 0 1 0 0 4h4m0-4a2 2 0 1 1 0 4m-9-6v-3a3 3 0 0 1 6 0v3m2.5 4h1m-3 0h1m-3 0h1" stroke="#043CA5 "/></g></svg>
                    Confirmar Contraseña <span class="text-danger">*</span></label>
                <div class="row m-b-15">
                    <div class="col-md-12">
                        <input type="password" class="form-control" placeholder="*****" required name="password_confirmation"/>
                    </div>
                </div>
                <div class="checkbox m-b-20 ">
                    <label>
                        <input type="checkbox" required /> Acepto los <a data-toggle="modal" href="#terminosYCondiciones">Terminos y Condiciones de Uso</a>.
                    </label>
                </div>
                
                <div  style="opacity: 0;" class="checkbox m-b-20">
                    <label>
                        <input checked="true" type="checkbox" name="challenge"/>Acepto el Reto y deseo afiliarme al Nuevo Recibo Digital.</a>.
                    </label>
                </div>
                <div class="m-b-20">
                    <div class="alert alert-success" role="alert" style="text-align: center">
                        <p style="color: black">JAPAM enviara un correo electrónico de confirmación para activar su cuenta.</p> <small style="color: black">Nota: Si no visualiza el correo, revise la bandeja de correos no deseados.</small>
                    </div>
                </div>
                <div class="register-buttons">
                    <button type="submit" id="boton_registrar" onclick="aparecer();" class="btn btn-primary2 btn-block btn-lg">Registrarse</button>
                   
                </div>
                
               
            </form>
             <button id="boton_registrar2" onclick="aparecer();" class="btn btn-pimary2 btn-block btn-lg">Registrarse</button>
              <div class="m-t-20 text-inverse">
                    ¿Ya es usuario? Haga clic <a href="{!! url(route('appUser.login.view')) !!}">aquí</a> para ingresar.
                </div>

                <hr />
                <p class="text-center">
                    <strong>Copyright © {!! date('Y') !!} <a target="_blank" href="https://japammovil.gob.mx/">JAPAM</a>.</strong> Todos los derechos reservados.
                </p>
        </div>
    </div>
    <div class="">
                    
                </div>
                
                
    
    <script>
    
        function checar_emails(){
            let email1= document.getElementById('email_1');
            let email2= document.getElementById('email_2');
            let boton = document.getElementById('boton_registrar');
            let mensaje_emails= document.getElementById('mensaje_emails');
            if(email1.value != email2.value){
                boton.disabled = true;
                mensaje_emails.innerHTML = 'Los correos no coinciden';
            }
            else{
                boton.disabled = false;
                mensaje_emails.innerHTML = '';
            }
            
        }
     
        let email2= document.getElementById('email_2');
        
        email2.addEventListener("keydown", event => {
          if (event.keyCode ===86 && event.ctrlKey) {
            setTimeout(()=>{
               email2.value='' ;
               alert('Por favor escriba el correo manualmente');
               checar_emails();
            },300)
          }
  
});



    function checar_inputs(){
        let name = document.getElementsByName("name")[0];
        let lastnames = document.getElementsByName("lastnames")[0];
        let phoneNumber = document.getElementsByName("phoneNumber")[0];
        let email = document.getElementsByName("email")[0];
        let email_confirmation = document.getElementsByName("email_confirmation")[0];
        let password = document.getElementsByName("password")[0];
        let password_confirmation = document.getElementsByName("password_confirmation")[0];
        if(name.value=="")return false;
        if(lastnames.value=="")return false;
        if(phoneNumber.value=="")return false;
        if(email.value=="")return false;
        if(email_confirmation.value=="")return false;
        if(password.value=="")return false;
        if(password_confirmation.value=="")return false;
        return true;
    }

  
    function aparecer(event){
        let listo = checar_inputs();
        if(listo ==false){
            alert("Hacen falta datos");
            return
        }
        if(event)
        event.preventDefault();
        let sidebar = document.getElementById("sidebar")

        sidebar.style.opacity=0
        sidebar.nextSibling.nextElementSibling.style.opacity = 0
        var emergente = document.getElementById("emergente")

        emergente.style.opacity =1;
        emergente.style.height = "100vh";
        setTimeout(()=>{
            
           emergente.style.display="none"
           btn_nuevo.disabled=true;
           
        let formulario = document.getElementById("formulario");
        formulario.submit();
        },8000)
        
    }
    
    let btn
    let btn_nuevo
    let svg
    function ocultar_registrar_btn(){
      setTimeout(()=>{
        btn = document.getElementById("boton_registrar");
        btn_nuevo = document.getElementById("boton_registrar2");
        
        svg = document.getElementById("svg")
        console.log("intetnado");
        if(!btn || !btn_nuevo)
        return false;
        
         console.log(btn);
        console.log("se supone que si existe");
            btn_nuevo.style.opacity = 1
            svg.style.height="100%";
            
            btn.style.position="absolute";
            btn.style.display="none"
            return true;
        },200);
        
    }
    
    var intervalo = null;
    async function iterador(){
        if(await ocultar_registrar_btn() == false)
            return;
        else{
            console.log("terminando");
            clearInterval(intervalo);
        }
    }
        intervalo = setInterval(iterador,400);
    </script>


    @include('auth-app-user.terms')
    <!-- end register-content -->
@endsection

