<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .contenedor-footer {
            background: #71cae6;
            color: white;
            display: flex;
            transform: translateY(18px);
            flex-wrap: wrap;
            max-width: 100%;
        }

        .col-generica {
            width: 20%;
            min-width:260px;
            display: grid;
            height: 130px;
            margin: auto 0px;
            justify-content: center;
            align-content: baseline;
            padding-top: 10px;
            padding-bottom: 10px;
            margin-right: auto;
            margin-left: auto;
        }

        .contenedor-footer ul {
            list-style-type: disc;
            font-family: 'Lato', Helvetica, Arial, Lucida, sans-serif;
            padding-top: 10px;
        }

        .links {
            
            color: white;
            font-weight: 500;
            line-height: 1em;
            font-weight: 900;
        }

        .ayuntamiento-logo {
            width: 18%;
            margin: auto;
        }

        .municipio-logo {

            width: 29%;
            margin: auto;
        }

        .japam-logo {

            width: 50%;
            margin: auto;
        }

        li {
            padding:7px;
            font-size: 15px;
        }
        li:hover{
            color:white;
        }

        a {
            text-decoration: none;
            transition:all 80ms ease-out ;
            padding: 7px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        a:focus, a:hover{
             color:white;
             
            border: 1px solid rgb(57, 105, 239);
        }
         a:hover{
             text-decoration:none;
            border: 1px solid white;
        }
        .movile{
            display:none;
        }
        .desktop{
            display:flex;
        }
        .flex{
            display:flex;
        }
         @media only screen and (max-width: 600px) {
        .movile{
            display:grid;
        }
        .desktop{
            display:none;
        }
        .col-generica{
            height: 110px;
        }
        .col-flex{
            display:flex;
            height: 105px;
            align-items: center;
            margin: auto;
            margin-top: 32px;
        }
        .ayuntamiento-logo2{
            height:69px;
            margin:50px;
        }
        .municipio-logo2{
            height:69px;
            margin-left: 30px;
        }
        li {
            padding-top: 2px;
            font-size: 15px;
        }
        }
    </style>
</head>

<body>
    <div class="contenedor-footer desktop ">
        <div class="col-generica">
            <img src="https://www.japammovil.com/tcs/public/img/footer/jap.png" alt="logotipo" class="japam-logo">
        </div>
        <div class="col-generica">
            <ul>
                <li>
                    <a class="links" href="https://japammovil.gob.mx/msj-del-director/">Mensaje del director</a>
                </li>
                <li>
                    <a class="links" href="https://japammovil.gob.mx/aviso-de-privacidad">Aviso de privacidad</a>
                </li>
                <li>
                    <a class="links" href="https://japammovil.gob.mx/politica-de-privacidad">Política de privacidad</a>
                </li>
            </ul>
        </div>
        <div class="col-generica">
            <ul>
                <li>
                    <a class="links" href="https://japammovil.gob.mx/politicas-de-devolucion">Política de devolución</a>
                </li>
                <li>
                    <a class="links" href="https://japammovil.gob.mx/terminos-y-condiciones">Términos y condiciones</a>
                </li>
                <li>
                    <a class="links" href="https://japammovil.gob.mx/sucursales">Módulos de atención</a>
                </li>
            </ul>
        </div>
        <div class="col-generica ">
            <div class="flex ">
                <img src="https://www.japammovil.com/tcs/public/img/footer/ayuntamiento.png" alt="logotipo del ayuntamiento"
                class="ayuntamiento-logo">
                 <img src="https://www.japammovil.com/tcs/public/img/footer/san-juan.png" alt="logotipo del municipio"
                class="municipio-logo">
             </div>
        </div>
     
    </div>
    
    <div class="contenedor-footer movile ">
        <div class="col-generica">
            <img src="https://www.japammovil.com/tcs/public/img/footer/jap.png" alt="logotipo" class="japam-logo">
        </div>
        <div class="col-generica">
            <ul>
                <li>
                    <a class="links" href="https://japammovil.gob.mx/msj-del-director/">Mensaje del director</a>
                </li>
                <li>
                    <a class="links" href="https://japammovil.gob.mx/aviso-de-privacidad">Aviso de privacidad</a>
                </li>
                <li>
                    <a class="links" href="https://japammovil.gob.mx/politica-de-privacidad">Política de privacidad</a>
                </li>
            </ul>
        </div>
        <div class="col-generica">
            <ul>
                <li>
                    <a class="links" href="https://japammovil.gob.mx/politicas-de-devolucion">Política de devolución</a>
                </li>
                <li>
                    <a class="links" href="https://japammovil.gob.mx/terminos-y-condiciones">Términos y condiciones</a>
                </li>
                <li>
                    <a class="links" href="https://japammovil.gob.mx/sucursales">Módulos de atención</a>
                </li>
            </ul>
        </div>
        <div class="col-flex">
            <img src="https://www.japammovil.com/tcs/public/img/footer/ayuntamiento.png" alt="logotipo del ayuntamiento"
                class="ayuntamiento-logo2">
        
            <img src="https://www.japammovil.com/tcs/public/img/footer/san-juan.png" alt="logotipo del municipio"
                class="municipio-logo2">
        </div>
    </div>
</body>

</html>