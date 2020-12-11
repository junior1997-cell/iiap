<?php

  namespace App\Controllers;

  use CodeIgniter\Controller;
  use App\Models\UsuariosModel;
  use App\Models\RegistrosModel;

  class Usuarios extends Controller {

    public function index() {
        //realiza solicitud a services y le decimos que ejecute el metodo request()
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();

        $registroModel = new RegistrosModel($db);
        $registro = $registroModel->where('estado', 1)
                ->findAll();

        //$db = \Config\Database::connect();
        //$pager = \Config\Services::pager();
        foreach ($registro as $key => $value) {

            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {

                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value["cliente_id"] . ":" . $value["llave_secreta"])) {

                    $usuariosModel = new UsuariosModel();
                    
                    $usuarios = $usuariosModel->getPersonaAll();

                    
                    if (!empty($usuarios)) {

                        $data = array(
                            "Status" => 200,
                            "Total_Resultados" => count($usuarios),
                            "Detalle" => $usuarios
                                //"Paginador"=>$paginador
                        );
                        return json_encode($data, true);

                    } else {

                        $data = array(
                            "Status" => 404,
                            "Total_Resultados" => 0,
                            "Detalle" => "Ningún registro cargado"
                        );
                    }
                } else {

                    $data = array(
                        "Status" => 404,
                        "Detalle" => "El token es inválido"
                    );
                }
            } else {

                $data = array(
                    "Status" => 404,
                    "Detalle" => "No está autorizado para recibir los registros"
                );
            }
        }

        return json_encode($data, true);
    }

    public function clienteall($id) {
        //realiza solicitud a services y le decimos que ejecute el metodo request()
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();

        $registroModel = new RegistrosModel($db);
        $registro = $registroModel->where('estado', 1)
                ->findAll();

        //$db = \Config\Database::connect();
        //$pager = \Config\Services::pager();
        foreach ($registro as $key => $value) {

            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {

                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value["cliente_id"] . ":" . $value["llave_secreta"])) {

                    $clienteModel = new UsuariosModel();
                    
                    $cliente = $clienteModel
                    ->getClienteAll($id);

                    
                    if (!empty($cliente)) {

                        $data = array(
                            "Status" => 200,
                            "Total_Resultados" => count($cliente),
                            "Detalle" => $cliente
                                //"Paginador"=>$paginador
                        );

                    } else {

                        $data = array(
                            "Status" => 404,
                            "Total_Resultados" => 0,
                            "Detalle" => "Ningún registro cargado"
                        );
                    }
                } else {

                    $data = array(
                        "Status" => 404,
                        "Detalle" => "El token es inválido"
                    );
                }
            } else {

                $data = array(
                    "Status" => 404,
                    "Detalle" => "No está autorizado para recibir los registros"
                );
            }
        }

        return json_encode($data, true);
    }

    public function show($id) {
        //realiza solicitud a services y le decimos que ejecute el metodo request()
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();

        $registroModel = new RegistrosModel($db);
        $registro = $registroModel->where('estado', 1)
                ->findAll();

        foreach ($registro as $key => $value) {
            //verificacion del toquen de seguridad 
            if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {

                if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value["cliente_id"] . ":" . $value["llave_secreta"])) {
                    
                    $usuariosModel = new UsuariosModel();
                    $usuarios = $usuariosModel->getPersonaOne($id);
                    //var_dump($usuarios);die;
                    if (!empty($usuarios)) {

                        $data = array(
                            "Status" => 200,
                            "Número Registro" =>$id,
                            "Detalle" => $usuarios
                        );
                        return json_encode($data, true);
                    } else {

                        $data = array(
                            "Status" => 404,
                            "Detalle" => "No hay ningún cliente registrado"
                        );
                    }
                } else {

                    $data = array(
                        "Status" => 404,
                        "Detalle" => "El token es inválido"
                    );
                }
            } else {

                $data = array(
                    "Status" => 404,
                    "Detalle" => "No está autorizado para recibir los registros"
                );
            }
        }

        return json_encode($data, true);
    }

    public function create() {
      //realiza solicitud a services y le decimos que ejecute el metodo request()
      $request = \Config\Services::request();
      $validation = \Config\Services::validation();
      $headers = $request->getHeaders();

      $registroModel = new RegistrosModel($db);
      $registro = $registroModel->where('estado', 1)
              ->findAll();
      foreach ($registro as $key => $value) {

          if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {

              if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value["cliente_id"] . ":" . $value["llave_secreta"])) {

                  // Registro de datos
                  //El getVar()método extraerá de $ _REQUEST, por lo que devolverá cualquier dato de $ _GET, $ POST 
                  $datos = array(
                    "nombre_persona" => $request->getVar("nombre_persona"),
                    "apellidos_persona" => $request->getVar("apellidos_persona"),
                    "correo_persona" => $request->getVar("correo_persona"),
                    "password_persona" => $request->getVar("password_persona"),
                    "idcargo" => $request->getVar("idcargo")
                  );

                  if (!empty($datos)) {

                      // Validar los datos

                      $validation->setRules([
                          'nombre_persona' => 'required',
                          'apellidos_persona' => 'required|max_length[255]'
                      ]);

                      $validation->withRequest($this->request)
                              ->run();

                      if ($validation->getErrors()) {
                          $errors = $validation->getErrors();
                          $data = array(
                              "Status" => 404,
                              "Detalle" => $errors
                          );
                          return json_encode($data, true);
                      } else {

                          $correo= $datos["correo_persona"];
                         
                          $UsuariosModel = new UsuariosModel($db);
                          $user = $UsuariosModel->VerficarEmail($correo);

                        //verificamos si existe el usuario
                        if (empty($user)) {
                          # code...                        
                          $datos = array(
                              "nombre_persona" => $datos["nombre_persona"],
                              "apellidos_persona" => $datos["apellidos_persona"],
                              "correo_persona" => $datos["correo_persona"],
                              "password_persona" => $datos["password_persona"],
                              "idcargo" => $datos["idcargo"]
                            );
                          
                          $user = $UsuariosModel->insert($datos);
                        
                          $data = array(
                              "Status" => 200,
                              "exito" => true,
                              "Detalle" => "Registro exitoso, Usuario guardado"
                            );
                          return json_encode($data, true);
                        }else{

                          $data = array(
                              "Status" => 200,
                              "exito" => false,
                              "Detalle" => "Registro fallido, Usuario existe"
                            );
                          return json_encode($data, true);
                        }
                      }
                  } else {

                      $data = array(
                              "Status" => 200,
                              "exito" => false,
                              "Detalle" => "Registro exitoso, Usuario guardado"
                            );
                      return json_encode($data, true);
                  }
              } else {

                  $data = array(
                      "Status" => 404,
                      "Detalles" => "El token es inválido"
                  );
              }
          } else {

              $data = array(
                  "Status" => 404,
                  "Detalles" => "No está autorizado para guardar los registros"
              );
          }
      }

      return json_encode($data, true);
    }

    public function login_usuario() {
      //realiza solicitud a services y le decimos que ejecute el metodo request()
      $request = \Config\Services::request();
      $validation = \Config\Services::validation();
      $headers = $request->getHeaders();

      $registroModel = new RegistrosModel($db);
      $registro = $registroModel->where('estado', 1)
              ->findAll();
      foreach ($registro as $key => $value) {

          if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {

              if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value["cliente_id"] . ":" . $value["llave_secreta"])) {

                  // Registro de datos
                  //El getVar()método extraerá de $ _REQUEST, por lo que devolverá cualquier dato de $ _GET, $ POST 
                  $datos = array(
                    "correo_persona" => $request->getVar("correo_persona"),
                    "password_persona" => $request->getVar("password_persona"),
                    
                  );

                  if (!empty($datos)) {

                      // Validar los datos

                      $validation->setRules([
                          'correo_persona' => 'required',
                          'password_persona' => 'required|max_length[255]'
                      ]);

                      $validation->withRequest($this->request)
                              ->run();

                      if ($validation->getErrors()) {
                          $errors = $validation->getErrors();
                          $data = array(
                              "Status" => 404,
                              "Detalle" => $errors
                          );
                          return json_encode($data, true);
                      } else {
                          
                          $correo= $datos["correo_persona"];
                          $password = $datos["password_persona"];                            
                          // var_dump($correo,$password); die;
                          // $usuariosModel = new UsuariosModel();
                          $UsuariosModel = new UsuariosModel($db);
                          $user = $UsuariosModel->Login($correo,$password);
                          // var_dump($user); die;
                          if (!empty($user)) {
                            $data = array(
                              "Status" => 200,
                              "exito" => true,
                              "Detalle" => "Logeo exitoso, Usuario validado"
                            );
                          }else{
                            $data = array(
                              "Status" => 403,
                              "exito" => false,
                              "Detalle" => "Logeo fallido, Usuario no encontrado"
                            );
                          }
                          
                          return json_encode($data, true);
                      }
                  } else {

                      $data = array(
                          "Status" => 404,
                          "Detalle" => "Logeo con errores"
                      );

                      return json_encode($data, true);
                  }
              } else {

                  $data = array(
                      "Status" => 404,
                      "Detalles" => "El token es inválido"
                  );
              }
          } else {

              $data = array(
                  "Status" => 404,
                  "Detalles" => "No está autorizado para guardar los registros"
              );
          }
      }

      return json_encode($data, true);
    }



    public function Update($id){
      //var_dump($id);die;
      $request = \Config\Services::request(); 
      $validation = \Config\Services::validation();

      $headers = $request->getHeaders();

      $registroModel = new RegistrosModel();
      $registro=$registroModel->where('estado', 1)
      ->findAll();

      foreach($registro as $key => $value){

        if(array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){

            if($request->getHeader('Authorization') == 'Authorization: Basic '.base64_encode($value["cliente_id"].":".$value["llave_secreta"])){
                // Tomar datos                    
              $datos = $this->request->getRawInput();
              //var_dump($datos);die;
              if(!empty($datos)){

                //Validar datos

                $validation->setRules([
                    'nombre_persona' => 'required|string|max_length[255]',                              
                ]);

                $validation->withRequest($this->request)
                ->run();

                  if($validation->getErrors()){

                    $errors = $validation->getErrors();

                    $data = array(
                      "Status"=>404,
                      "Detalle"=>$errors,
                      "Metodo"=>"update,"
                    ); 
                    
                    return json_encode($data, true);
                  }else{

                    $usuariosModel = new UsuariosModel();
                    $usuarios = $usuariosModel->getPersonaOne($id);
                    //validamos si el ID existe
                    //var_dump($usuarios);die;
                    if (!empty($usuarios)) {
                      # code...
                      $datos = array( 
                        "nombre_persona" => $datos["nombre_persona"],
                        "apellidos_persona" => $datos["apellidos_persona"],
                        "correo_persona" => $datos["correo_persona"],
                        "password_persona" => $datos["password_persona"],
                        "foto_persona" => $datos["foto_persona"],
                        "idcargo" => $datos["idcargo"]
                      );
                          
                      $usuarios = $usuariosModel->update($id, $datos);

                      $data = array(
                        "Status"=>200,
                        "Detalle"=>"Datos de usuario actualizado"
                      );
                    }else{

                      $data = array(
                        "Status"=>404,
                        "Metodo"=>"update",
                        "Detalle"=>"Usuario para Actualizacion NO ENCONTRADO"
                      );                        
                    }
                    return json_encode($data, true);
                  }
              }else{

                $data = array(

                  "Status"=>404,
                  "Detalle"=>"Actualizacion de usuario con errores"
                );

                return json_encode($data, true);                
              }                
            }else{

              $data = array(

                "Status"=>404,
                "Detalles"=>"El token es inválido"                      
              );
            }
        }else{

          $data = array(

            "Status"=>404,
            "Detalles"=>"No está autorizado para editar los registros"                  
          );
        }
      }
      return json_encode($data, true);
    }

    public function delete( $id ){
      //var_dump($id);die;
      $request = \Config\Services::request(); 
      $validation = \Config\Services::validation();

      $headers = $request->getHeaders();

      $registroModel = new RegistrosModel();

      $registro=$registroModel->where('estado', 1)
      ->findAll();

      foreach($registro as $key => $value){
        //verificar si esxiste la llave
        if(array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
          //Validando la llave *apikey* con la BD
          if($request->getHeader('Authorization') == 'Authorization: Basic '.base64_encode($value["cliente_id"].":".$value["llave_secreta"])){

            $usuariosModel = new UsuariosModel();
            $usuarios = $usuariosModel->find($id);                  
            //var_dump($id);die;
            if(!empty($usuarios)){

              $datos = array( 'estado_persona' => 0 );
              $usuarios = $usuariosModel->update($id , $datos);
              
              $data = array(
                "Status"=>200,
                "Detalle"=>"Se ha borrado con éxito"                             
              );

              return json_encode($data, true);
            }else{

              $data = array(
                "Status"=>404,
                "Detalle"=>"El usuario no existe"
              );

              return json_encode($data, true);
            }
          }else{

            $data = array(
              "Status"=>404,
              "Detalles"=>"El token es inválido"                    
            );
          }
        }else{

          $data = array(
            "Status"=>404,
            "Detalles"=>"No está autorizado para editar los registros"                    
          );       
        }      
      }

      return json_encode($data, true);
    }

     //  public function recuperar($id) {
     //      //realiza solicitud a services y le decimos que ejecute el metodo request()
     //      $request = \Config\Services::request();
     //      $validation = \Config\Services::validation();

     //      $headers = $request->getHeaders();

     //      $registroModel = new RegistrosModel($db);

     //      $registro = $registroModel->where('estado', 1)
     //              ->findAll();

     //      foreach ($registro as $key => $value) {

     //          if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {

     //              if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value["cliente_id"] . ":" . $value["llave_secreta"])) {

     //                  $usuariosModel = new UsuariosModel($db);
     //                  $usuarios = $usuariosModel->find($id);


     //                  if (!empty($usuarios)) {
     //                      $datos = array('estado_persona' => 1);
     //                      $usuarios = $usuariosModel->update($id, $datos);

     //                      $data = array(
     //                          "Status" => 200,
     //                          "Detalle" => "Se ha recuperado con éxito"
     //                      );

     //                      return json_encode($data, true);
     //                  } else {

     //                      $data = array(
     //                          "Status" => 404,
     //                          "Detalle" => "El usuario no existe"
     //                      );

     //                      return json_encode($data, true);
     //                  }
     //              } else {

     //                  $data = array(
     //                      "Status" => 404,
     //                      "Detalles" => "El token es inválido"
     //                  );
     //              }
     //          } else {

     //              $data = array(
     //                  "Status" => 404,
     //                  "Detalles" => "No está autorizado para editar los registros"
     //              );
     //          }
     //      }

     //      return json_encode($data, true);
     //  }

  }
