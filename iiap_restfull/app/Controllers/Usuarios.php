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
                    $usuarios = $usuariosModel
                                ->getPersonaOne($id);
                           
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

   public function create(){
        $request = \Config\Services::request(); 
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();

        $registroModel = new RegistrosModel($db);
        $registro=$registroModel->where('estado', 1)
        ->findAll();
        foreach($registro as $key => $value){

            if(array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){

                if($request->getHeader('Authorization') == 'Authorization: Basic '.base64_encode($value["cliente_id"].":".$value["llave_secreta"])){

                    // Registro de datos
                    
                    $datos = array("nombre_persona"=>$request->getVar("nombre_persona"),
                                "apellidos_persona" => $request->getVar("apellidos_persona"),
                                "imagen_persona" => $request->getVar("imagen_persona"),
                                "id_sexo" => $request->getVar("id_sexo"),
                                "id_tipo_doc" => $request->getVar("id_tipo_doc"),
                                "num_doc_persona" => $request->getVar("num_doc_persona"),
                                "email" => $request->getVar("email"),
                                "password" => $request->getVar("password"),
                                "celular" => $request->getVar("celular"),
                                "id_cargo" => $request->getVar("id_cargo"),
                                "id_distrito" => $request->getVar("id_distrito"),
                                "direccion" => $request->getVar("direccion"),                               
                    );

                    if(!empty($datos)){

                        // Validar los datos

                        $validation->setRules([
                            'nombre_persona' => 'string|max_length[255]',                          
                            'id_tipo_doc' => 'string|max_length[255]',                           
                            'id_cargo' => 'string|max_length[255]',
                            'id_distrito' => 'string|max_length[255]'                           
                        ]);

                        $validation->withRequest($this->request)
                           ->run();

                        if($validation->getErrors()){
                            $errors = $validation->getErrors();
                            $data = array(
                                "Status"=>404,
                                "Detalle"=>$errors
                            );                          
                            return json_encode($data, true); 
                        }else{
                            $datos = array("nombre_persona"=>$datos["nombre_persona"],
                                            "apellidos_persona" => $datos["apellidos_persona"],
                                            "imagen_persona" => $datos["imagen_persona"],
                                            "id_sexo" => $datos["id_sexo"],
                                            "id_tipo_doc" => $datos["id_tipo_doc"],
                                            "num_doc_persona" => $datos["num_doc_persona"],
                                            "email" => $datos["email"],
                                            "password" => $datos["password"],
                                            "celular" => $datos["celular"],
                                            "id_cargo" => $datos["id_cargo"],
                                            "id_distrito" => $datos["id_distrito"],
                                            "direccion" => $datos["direccion"],
                                             
                                            
                            );
                                       
                            
                            $usuariosModel = new UsuariosModel($db);
                            $usuarios = $usuariosModel->insert($datos);


                             //CAPTURAMOS EL ULTIMO "ID"
                            $usuari_ultimo_id = $usuariosModel->getUltimoUsu();                             
                            // var_dump($usuari_ultimo_id);die;                            
                            //CAPTURAMOS EL "ID" EN UNA VARIABLE
                            $id_person=$usuari_ultimo_id[0]['idpersona'];
                            // var_dump($id_person);die; 
                            //LLAMAMOS AL MODELO DONDE SE VA HACER LA INCERCION
                            $usupermiModel = new UsuariopermisoModel($db); 
                            //CAPTURAMOS TODOS LOS DATOS TIPO ARRAY, ENVIADOS DESDE EL FORMULARIO
                            $permiso =  $request->getVar("permiso");
                            //DECODIFICAMOS EL ARRAY QUE SE HA CAPTURADO COMO STRING
                            $deco_permiso = json_decode($permiso,true);
                             // return json_encode($deco_permiso, true);
                            // var_dump($deco_permiso);die; 
                            //CREAMOS UN CONTADOR PARA RECORRER EL ARRAY
                            $cont_elementos=0;
                            while ($cont_elementos < count($deco_permiso)) {
                                $datitos=array('id_usuario' => $id_person,
                                                'id_permiso' => $deco_permiso[$cont_elementos]
                                            
                                        );
                                $permiso_insert = $usupermiModel->insert($datitos);
                                $cont_elementos=$cont_elementos + 1 ;
                            }

                            $data = array(
                                "Status"=>200,
                                "Detalle"=>"Registro exitoso, usuario guardado"
                            );              
                             return json_encode($data, true);
                        }

                    }else{

                        $data = array(

                            "Status"=>404,
                            "Detalle"=>"Registro con errores"
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
                    "Detalles"=>"No está autorizado para guardar los registros"
                    
                );      

            }

        }

        return json_encode($data, true);
        
    }


   public function update( $id ){
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
                                "Detalle"=>$errors
                            ); 
                            
                            return json_encode($data, true); 

                        }else{

                            $usuariosModel = new UsuariosModel();
                            $usuarios = $usuariosModel->find($id);
                            
                            $datos = array( "nombre_persona" => $datos["nombre_persona"],
                                "apellidos_persona" => $datos["apellidos_persona"],
                                "id_sexo" => $datos["id_sexo"],
                                "id_tipo_doc" => $datos["id_tipo_doc"],
                                "num_doc_persona" => $datos["num_doc_persona"],
                                "email" => $datos["email"],
                                "direccion" => $datos["direccion"],
                                "password" => $datos["password"],
                                "celular" => $datos["celular"],
                                "id_cargo" => $datos["id_cargo"],
                                "id_tipo_persona" => $datos["id_tipo_persona"],
                                "id_distrito" => $datos["id_distrito"],
                                "imagen_persona" => $datos["imagen_persona"]
                            );
                                
                            $usuarios = $usuariosModel->update($id, $datos);

                            $data = array(
                                "Status"=>200,
                                "Detalle"=>"Datos de usuario actualizado"

                            ); 
                                
                            return json_encode($data, true);

                        }

                    }else{

                        $data = array(

                            "Status"=>404,
                            "Detalle"=>"Actualizacion de usuario Registro con errores"
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
        $request = \Config\Services::request(); 
        $validation = \Config\Services::validation();

        $headers = $request->getHeaders();

        $registroModel = new RegistrosModel();

        $registro=$registroModel->where('estado', 1)
        ->findAll();

        foreach($registro as $key => $value){

            if(array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){

                if($request->getHeader('Authorization') == 'Authorization: Basic '.base64_encode($value["cliente_id"].":".$value["llave_secreta"])){

                    $usuariosModel = new UsuariosModel();
                    $usuarios = $usuariosModel->find($id);
                    

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

    public function recuperar($id) {
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

                    $usuariosModel = new UsuariosModel($db);
                    $usuarios = $usuariosModel->find($id);


                    if (!empty($usuarios)) {
                        $datos = array('estado_persona' => 1);
                        $usuarios = $usuariosModel->update($id, $datos);

                        $data = array(
                            "Status" => 200,
                            "Detalle" => "Se ha recuperado con éxito"
                        );

                        return json_encode($data, true);
                    } else {

                        $data = array(
                            "Status" => 404,
                            "Detalle" => "El usuario no existe"
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
                    "Detalles" => "No está autorizado para editar los registros"
                );
            }
        }

        return json_encode($data, true);
    }

    public function cargo($id) {
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
                    $usuarios = $usuariosModel
                                ->getCargoPersona($id);
                           
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

    // public function permisoAll($id) {
    //     //realiza solicitud a services y le decimos que ejecute el metodo request()
    //     $request = \Config\Services::request();
    //     $validation = \Config\Services::validation();
    //     $headers = $request->getHeaders();

    //     $registroModel = new RegistrosModel($db);
    //     $registro = $registroModel->where('estado', 1)
    //             ->findAll();

    //     foreach ($registro as $key => $value) {
    //         //verificacion del toquen de seguridad 
    //         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {

    //             if ($request->getHeader('Authorization') == 'Authorization: Basic ' . base64_encode($value["cliente_id"] . ":" . $value["llave_secreta"])) {
                    
    //                 $usuariosModel = new UsuariosModel();
    //                 $usuarios = $usuariosModel
    //                             ->getCargoPersona($id);
                           
    //                 if (!empty($usuarios)) {

    //                     $data = array(
    //                         "Status" => 200,
    //                         "Número Registro" =>$id,
    //                         "Detalle" => $usuarios
    //                     );
    //                     return json_encode($data, true);
    //                 } else {

    //                     $data = array(
    //                         "Status" => 404,
    //                         "Detalle" => "No hay ningún cliente registrado"
    //                     );
    //                 }
    //             } else {

    //                 $data = array(
    //                     "Status" => 404,
    //                     "Detalle" => "El token es inválido"
    //                 );
    //             }
    //         } else {

    //             $data = array(
    //                 "Status" => 404,
    //                 "Detalle" => "No está autorizado para recibir los registros"
    //             );
    //         }
    //     }

    //     return json_encode($data, true);
    // }



}
