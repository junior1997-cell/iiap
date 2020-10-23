<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ClientesModel;
use App\Models\RegistrosModel;

class Clientes extends Controller {

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

                    $clienteModel = new ClientesModel();
                    
                    $cliente = $clienteModel->getclientesAll();

                    
                    if (!empty($cliente)) {

                        $data = array(
                            "Status" => 200,
                            "Total_Resultados" => count($cliente),
                            "Detalle" => $cliente
                                //"Paginador"=>$paginador
                        );
                        return json_encode($data, true);
                    } else {

                        $data = array(
                            "Status" => 404,
                            "Total_Resultados" => 0,
                            "Detalle" => "Ningun registro de cliente cargado"
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

                    $clienteModel = new ClientesModel();
                    
                    $cliente = $clienteModel
                    ->getClienteAll($id);

                    
                    if (!empty($cliente)) {

                        $data = array(
                            "Status" => 200,
                            "Total_Resultados" => count($cliente),
                            "Detalle" => $cliente
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
                    
                    $clienteModel = new ClientesModel();
                    $cliente = $clienteModel
                                ->getclientesOne($id);
                           
                    if (!empty($cliente)) {

                        $data = array(
                            "Status" => 200,
                            "Número Registro" =>$id,
                            "Detalle" => $cliente
                        );
                        return json_encode($data, true);
                    } else {

                        $data = array(
                            "Status" => 404,
                            "Detalle" => "No hay ninguuuuuuuuuuuuun cliente registrado"
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
                    
                    $datos = array("nombre_clientes"=>$request->getVar("nombre_clientes"),
                                "apellidos_clientes" => $request->getVar("apellidos_clientes"),
                                "imagen_clientes" => $request->getVar("imagen_clientes"),
                                "id_sexo_clientes" => $request->getVar("id_sexo_clientes"),
                                "id_tipo_doc_clientes" => $request->getVar("id_tipo_doc_clientes"),
                                "num_doc_clientes" => $request->getVar("num_doc_clientes"),
                                "email_clientes" => $request->getVar("email_clientes"),
                                "password_clientes" => $request->getVar("password_clientes"),
                                "celular_clientes" => $request->getVar("celular_clientes"),
                                "id_cargo_clientes" => $request->getVar("id_cargo_clientes"),
                                "id_distrito_clientes" => $request->getVar("id_distrito_clientes"),
                                "direccion_clientes" => $request->getVar("direccion_clientes"),                               
                    );

                    if(!empty($datos)){

                        // Validar los datos

                        $validation->setRules([
                            'nombre_clientes' => 'string|max_length[255]',                          
                            'id_tipo_doc_clientes' => 'string|max_length[255]',                           
                            'id_cargo_clientes' => 'string|max_length[255]',
                            'id_distrito_clientes' => 'string|max_length[255]'                           
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
                            $datos = array("nombre_clientes"=>$datos["nombre_clientes"],
                                            "apellidos_clientes" => $datos["apellidos_clientes"],
                                            "imagen_clientes" => $datos["imagen_clientes"],
                                            "id_sexo_clientes" => $datos["id_sexo_clientes"],
                                            "id_tipo_doc_clientes" => $datos["id_tipo_doc_clientes"],
                                            "num_doc_clientes" => $datos["num_doc_clientes"],
                                            "email_clientes" => $datos["email_clientes"],
                                            "password_clientes" => $datos["password_clientes"],
                                            "celular_clientes" => $datos["celular_clientes"],
                                            "id_cargo_clientes" => $datos["id_cargo_clientes"],
                                            "id_distrito_clientes" => $datos["id_distrito_clientes"],
                                            "direccion_clientes" => $datos["direccion_clientes"],
                                             
                                            
                            );
                                       
                            
                            $clienteModel = new ClientesModel($db);
                            $cliente = $clienteModel->insert($datos);
                            $data = array(
                                "Status"=>200,
                                "Detalle"=>"Registro exitoso, cliente guardado"
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
                            'nombre_clientes' => 'required|string|max_length[255]'
                             
                               
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

                            $clienteModel = new ClientesModel();
                            $cliente = $clienteModel->getclientesOne($id);

                            if(empty($cliente)){
                                $data = array(
                                    "Status"=>404,
                                    "Detalle"=>"esta vacio"
                                ); 
                            
                                return json_encode($data, true); 
                            }else{
                                
                                $datos = array( "nombre_clientes" => $datos["nombre_clientes"],
                                    "apellidos_clientes" => $datos["apellidos_clientes"],
                                    "id_sexo_clientes" => $datos["id_sexo_clientes"],
                                    "id_tipo_doc_clientes" => $datos["id_tipo_doc_clientes"],
                                    "num_doc_clientes" => $datos["num_doc_clientes"],
                                    "email_clientes" => $datos["email_clientes"],
                                    "direccion_clientes" => $datos["direccion_clientes"],
                                    "password_clientes" => $datos["password_clientes"],
                                    "celular_clientes" => $datos["celular_clientes"],
                                    "id_cargo_clientes" => $datos["id_cargo_clientes"],
                                    "id_tipo_clientes" => $datos["id_tipo_clientes"],
                                    "id_distrito_clientes" => $datos["id_distrito_clientes"],
                                    "imagen_clientes" => $datos["imagen_clientes"]
                                );
                                    
                                $cliente = $clienteModel->update($id, $datos);

                                $data = array(
                                    "Status"=>200,
                                    "Detalle"=>"Datos de cliente actualizado"

                                ); 
                                    
                                return json_encode($data, true);
                            }

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

                    $clienteModel = new ClientesModel();
                    $cliente = $clienteModel->find($id);
                    

                    if(!empty($cliente)){
                        $datos = array( 'estado_clientes' => 0 );
                        $cliente = $clienteModel->update($id , $datos);
                        
                        $data = array(

                                "Status"=>200,
                                "Detalle"=>"Se ha borrado con éxito"
                                
                        );

                        return json_encode($data, true);    

                    }else{

                        $data = array(

                            "Status"=>404,
                            "Detalle"=>"El cliente no existe"
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

                    $clienteModel = new ClientesModel($db);
                    $cliente = $clienteModel->find($id);


                    if (!empty($cliente)) {
                        $datos = array('estado_clientes' => 1);
                        $cliente = $clienteModel->update($id, $datos);

                        $data = array(
                            "Status" => 200,
                            "Detalle" => "Se ha recuperado con éxito"
                        );

                        return json_encode($data, true);
                    } else {

                        $data = array(
                            "Status" => 404,
                            "Detalle" => "El cliente no existe"
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

    public function cargocliente() {
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
                    
                    $usuariosModel = new ClientesModel();
                    $usuarios = $usuariosModel
                                ->getCargoCliente();
                           
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



}
