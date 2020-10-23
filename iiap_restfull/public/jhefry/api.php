<?php

    $curl = curl_init();
    if($_SERVER["REQUEST_METHOD"]=="POST"){

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://localhost/git/lavadora/drive_restfull/index.php/registros",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => 
          "nombres=".$_POST["nombres"].
            "&apellidos=".$_POST["apellidos"].
            "&email=".$_POST["email"],
          CURLOPT_HTTPHEADER => array(
            "Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VITi5yb3hMT1dZbkV6bXV0VGFScExVaTQyOFltaUsuOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlbEVLa3hFSkt0d0FPSnd4aExXU3E4TUNPZXB2eHFpaQ==",
            "Content-Type: application/x-www-form-urlencoded"
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $datos= json_decode($response,true);
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>API Contabilidad</title>
        <!-- CSS only -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    </head>
    <body class="text-justify">
        <div class="container-fluid">
            <div class="row">
                <h1 class="col-xl-12 text-center">API Junior - UPeU</h1>
                <h2 class="col-xl-12 text-center">Desarrollo de Aplicaciones Distribuidas</h2>
                <h3 class="col-xl-12 text-center">Ciclo Académico 2020 - I</h3>
                <div class="row col-xl-10 offset-1 alert alert-light">
                    <p>Bienvenidos, la presente plataforma contiene la API desarrollada para 
                        los proyectos integradores del presente ciclo académico para la Escuela 
                        Profesional de Ingeniería de Sistemas sede Tarapoto. La API permite el 
                        acceso directo al trabajo con la información de nuestra base de datos desde 
                        tu aplicación. Usa una interfaz RESTful y retorna los datos en formato JSON.
                        La información invocadas a través de la API proveen un acceso estándar online
                        a datos contenidos en páginas HTML y otros archivos similares disponibles en 
                        Internet. Registre sus datos y consiga la autorización para trabajar en 
                        nuestra plataforma, ya que requiere de datos de autorización, la puedes solicitar 
                        a través del siguiente formulario:
                    </p>        
                </div>
                <div id="ocultar">
                    <div class="row col-xl-8 offset-2 bg-dark text-white font-weight-bold">
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            print_r($datos['Detalle']);
                        }
                        ?>
                    </div>
                    <div class="row col-xl-8 offset-2 bg-success text-white font-weight-bold">
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {

                            print_r($datos['Credenciales']['cliente_id']);
                        }
                        ?>
                    </div>
                    <div class="row col-xl-8 offset-2 bg-info text-white font-weight-bold">

                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            print_r("Llave secreta: ".$datos['Credenciales']['llave_secreta']);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>      
    <seccion>
        <div class="container">
            <div class="row text-center text-uppercase">
                <div class="col pt-3">
                    <h3>Solicitud de Acceso a Datos</h3>
                    <small></small>
                </div>
            </div>
            <div class="row col-xl-12 offset-2">
                <form method="post" class="col-sm-8">
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <input type="text" name="nombres" placeholder="Nombres" class="form-control form-control-sm" required >
                        </div>
                        <div class="form-group col-sm-6 ">
                            <input type="text" name="apellidos" placeholder="Apellidos" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group col-sm-12">
                            <input type="email" name="email" placeholder="E-mail" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-9">
                            <button type="submit" class="btn btn-success btn-sm btn-block registrar" id="registrar">Registrar</button>
                        </div>
                        <div class="form-group col-sm-3">
                            <button type="button" class="btn btn-danger btn-sm btn-block"data-toggle="modal" data-target=".bd-example-modal-lg">Verificar</button>
                        </div>
                    
                    </div>
                </form>
            </div>
        </div>
           
    </seccion>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="x" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                 <div class="modal-header" style=" background: #5DADE2;">
                    <div class="row col-xl-11 offset-0 p-3 mb-2 bg-white text-dark" style="margin-left: .1rem!important; background: #5DADE2!important;">
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            print_r($datos['Detalle']);
                        }
                        ?>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                      <div class="modal-body">
                        <div class="row col-xl-12 offset-0 p-3 mb-2 bg-info text-dark" style="margin-left: .1rem!important; background: #FEF9E7!important;" >
                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                print_r("Cliente id: ".$datos['Credenciales']['cliente_id']);
                                //echo "Aquie el cliente id de la api";
                            }
                            ?>
                        </div>
                        <div class="row col-xl-12 offset-0 p-3 mb-2 bg-secondary text-dark" style="margin-left: .1rem!important; background: #FEF9E7!important;">

                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                print_r("Llave secreta: ".$datos['Credenciales']['llave_secreta']);
                            }
                           // echo "hola soy soy tu ";
                            ?>
                        </div>
                  </div>
                        <div class="modal-footer">
                  </div>
            </div>
          </div>
</div>
      
    </body>
</html>

<script>
    
    $('#ocultar').hide();

    $(document).ready(function(){ 

  
   
  $("#btn3").click(function(){
          VanillaToasts.create({
              title: 'Message Title',
              text: 'Notification text',
              type: 'error',
              icon: 'img/error.png',
               timeout: 6000
          });
      });       
    
    $("#registrar").click(function(){
        VanillaToasts.create({
            title: 'Message Title',
            text: 'Notification text',
            type: 'success',
            icon: 'img/success.png',
             timeout: 6000
        });
    });  
});     
</script>