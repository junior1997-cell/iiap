<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PedidosModel;
use App\Models\DetallepedidoprendaModel;
use App\Models\RegistrosModel;

class Pedidos extends Controller {

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

                    $pedidoModel = new PedidosModel();
                    
                    $pedido = $pedidoModel->getPedidosAll();
                    // var_dump($pedido); die;
                    // $lola=count($pedido);
                    if (!empty($pedido)) {

                        $data = array(
                            "Status" => 200,
                            "Total_Resultados" => count($pedido),
                            "Detalle" => $pedido
                                //"Paginador"=>$paginador
                        );
                        return json_encode($data, true);
                    } else {

                        $data = array(
                            "Status" => 404,
                            "Total_Resultados" => 0,
                            "Detalle" => "Ningun registro de pedido cargado"
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
                    
                    $clienteModel = new PedidosModel();
                    $cliente = $clienteModel
                                ->getPedidosOne($id);
                           
                    if (!empty($cliente)) {

                        $data = array(
                            "Status" => 200,
                            "Número Registro" =>$id,
                            "Detalle" => $cliente
                        );

                        // $a=$data['Detalle']['idpedido_prenda'];

                        return json_encode($data, true);
                    } else {

                        $data = array(
                            "Status" => 404,
                            "Detalle" => "No hay ninguuun cliente registrado"
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
                    
                    $datos = array("numero_pedido"=>$request->getVar("numero_pedido"),
                                "id_tipo_pedido" => $request->getVar("id_tipo_pedido"),                                
                                "id_usuario" => $request->getVar("id_usuario"),
                                "id_cliente" => $request->getVar("id_cliente"),
                                "id_tipo_comprobante" => $request->getVar("id_tipo_comprobante"),
                                "serie_comprobante" => $request->getVar("serie_comprobante"),
                                "numero_comprobante" => $request->getVar("numero_comprobante"),
                                "id_tipo_lavado" => $request->getVar("id_tipo_lavado"),                                
                                "id_estado_lavado" => $request->getVar("id_estado_lavado"),
                                "impuesto" => $request->getVar("impuesto"),
                                "comision_por_recogo" => $request->getVar("comision_por_recogo"),
                                "total_pedido" => $request->getVar("total_pedido"),
                                "estado_boleta" => $request->getVar("estado_boleta"),
                                "estado_pedido_prenda" => $request->getVar("estado_pedido_prenda"),
                                "momento_pago" => $request->getVar("momento_pago"), 
                                "fecha_entrega" => $request->getVar("fecha_entrega"), 
                                "id_delivery" => $request->getVar("id_delivery"),
                                                               
                    );
                    // return json_encode($datos, true); 
                    // var_dump($datos); die;

                    if(!empty($datos)){
                         // return json_encode($datos, true);
                        // Validar los datos

                        $validation->setRules([
                            'numero_pedido' => 'string|max_length[255]',                          
                            'id_cliente' => 'string|max_length[255]',                           
                            
                            'id_estado_lavado' => 'string|max_length[255]'                           
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

                            $datos = array("numero_pedido"=>$datos["numero_pedido"],
                                            "id_tipo_pedido" => $datos["id_tipo_pedido"],                                            
                                            "id_usuario" => $datos["id_usuario"],
                                            "id_cliente" => $datos["id_cliente"],
                                            "id_tipo_comprobante" => $datos["id_tipo_comprobante"],
                                            "serie_comprobante" => $datos["serie_comprobante"],
                                            "numero_comprobante" => $datos["numero_comprobante"],
                                            "id_tipo_lavado" => $datos["id_tipo_lavado"],                                            
                                            "id_estado_lavado" => $datos["id_estado_lavado"],
                                            "comision_por_recogo" => $datos["comision_por_recogo"],
                                            "total_pedido" => $datos["total_pedido"],
                                            "estado_boleta" => $datos["estado_boleta"],
                                            "estado_pedido_prenda" => $datos["estado_pedido_prenda"],
                                            "momento_pago" => $datos["momento_pago"],
                                            "fecha_entrega" => $datos["fecha_entrega"],
                                            "id_delivery" => $datos["id_delivery"],
                                             
                                            
                            );
                                       
                            
                            $clienteModel = new PedidosModel($db);
                            $cliente = $clienteModel->insert($datos);
                            $data = array(
                                "Status"=>200,
                                "Detalle"=>"Registro exitoso, Pedido de lavado guardado"
                            ); 
                            //CAPTURAMOS EL ULTIMO "ID"
                            $detalle_ultimo_id = $clienteModel->getUltimoReg();                             
                            // var_dump($detallefindall);die;
                            
                            //CAPTURAMOS EL "ID" EN UNA VARIABLE
                            $id_pedido_prenda=$detalle_ultimo_id[0]['idpedido_prenda'];
                            // var_dump($idpedidolav);die;

                            //INSTANCIAMOS UN OBJETO DE LA CLASE DETALL...
                            $detalleModel = new DetallepedidoprendaModel($db); 

                            //CAPTURAMOS TODOS LOS DATOS TIPO ARRAY, ENVIADOS DESDE EL FORMULARIO
                            $id_prenda =  $request->getVar("id_prenda");
                            $id_color =  $request->getVar("id_color");
                            $cantidad_pedido_prenda =  $request->getVar("cantidad_detalle_pedido_prenda");
                            $descuento_pedido_prenda =  $request->getVar("descuento_detalle_pedido_prenda");
                            //DECODIFICAMOS EL ARRAY QUE SE HA CAPTURADO COMO STRING
                            $deco_id_prenda = json_decode($id_prenda,true);
                            $deco_id_color = json_decode($id_color,true);
                            $deco_cantidad_pedido_prenda=json_decode($cantidad_pedido_prenda,true);
                            $deco_descuento_pedido_prenda=json_decode($descuento_pedido_prenda,true);

                            //CREAMOS UN CONTADOR PARA RECORRER EL ARRAY
                            $cont_elementos=0;
                            while ($cont_elementos < count($deco_id_prenda)) {
                                $datitos=array('id_prenda' => $deco_id_prenda[$cont_elementos],
                                            'id_color' => $deco_id_color[$cont_elementos],
                                            'cantidad_detalle_pedido_prenda'=>$deco_cantidad_pedido_prenda[$cont_elementos],
                                            'descuento_detalle_pedido_prenda'=>$deco_descuento_pedido_prenda[$cont_elementos],
                                            'id_pedido_prenda'=>$id_pedido_prenda
                                        );
                                $detatitos_insert = $detalleModel->insert($datitos);
                                $cont_elementos=$cont_elementos + 1 ;
                            }

                            // $dat=array("precio"=>$no,
                            //             "hola"=> $cont_elementos);
                             // $datitos = array("cantidad_detalle_pedido_prenda"=>$datitoss["cantidad_detalle_pedido_prenda"]);
                            

                            // // $cantidad=$datitos["cantidad_detalle_pedido_prenda"];

                            // var_dump($datitos); die;

                            // $da=array('cantidad_detalle_pedido_prenda' => "7",
                            //         'id_prenda' => "7",
                            //         'id_color' => "7",
                            //         'id_pedido_prenda'=>$id_pedido_prenda,
                            //         'descuento_detalle_pedido_prenda'=>"0");
                            // $detalle = $detalleModel->insert($da);  

                            return json_encode($data, true);  

                              // return json_encode($data, true);
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

                            $clienteModel = new PedidosModel();
                            $cliente = $clienteModel->find($id);
                            
                            $datos = array( "nombre_persona" => $datos["nombre_persona"],
                                "apellidos_persona" => $datos["apellidos_persona"],
                                "id_sexo" => $datos["id_sexo"],
                                "id_tipo_doc" => $datos["id_tipo_doc"],
                                "num_doc_persona" => $datos["num_doc_persona"],
                                "email" => $datos["email"],
                                "direccion" => $datos["direccion"],
                                "id_tipo_lavado" => $datos["id_tipo_lavado"],
                                "celular" => $datos["celular"],
                                "id_cargo" => $datos["id_cargo"],
                                "id_tipo_persona" => $datos["id_tipo_persona"],
                                "id_distrito" => $datos["id_distrito"],
                                "imagen_persona" => $datos["imagen_persona"]
                            );
                                
                            $cliente = $clienteModel->update($id, $datos);

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

     public function delete($id) {
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

                    $clienteModel = new PedidosModel($db);
                    $cliente = $clienteModel->find($id);


                    if (!empty($cliente)) {
                        $datos = array('estado_boleta' => "0");
                        $cliente = $clienteModel->update($id, $datos);

                        $data = array(
                            "Status" => 200,
                            "Detalle" => "Se ha anulado la boleta"
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
     

    public function enviarPedido( $id ){
        $request = \Config\Services::request(); 
        $validation = \Config\Services::validation();

        $headers = $request->getHeaders();

        $registroModel = new RegistrosModel();

        $registro=$registroModel->where('estado', 1)
        ->findAll();

        foreach($registro as $key => $value){

            if(array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){

                if($request->getHeader('Authorization') == 'Authorization: Basic '.base64_encode($value["cliente_id"].":".$value["llave_secreta"])){

                    $clienteModel = new PedidosModel();
                    $cliente = $clienteModel->find($id);
                    

                    if(!empty($cliente)){
                        $datos = array( 'estado_pedido_prenda' => 0 );
                        $cliente = $clienteModel->update($id , $datos);
                        
                        $data = array(

                                "Status"=>200,
                                "Detalle"=>"Se ha enviado el pedido con éxito"
                                
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

    public function realizarPago( $id ){
        $request = \Config\Services::request(); 
        $validation = \Config\Services::validation();

        $headers = $request->getHeaders();

        $registroModel = new RegistrosModel();

        $registro=$registroModel->where('estado', 1)
        ->findAll();

        foreach($registro as $key => $value){

            if(array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){

                if($request->getHeader('Authorization') == 'Authorization: Basic '.base64_encode($value["cliente_id"].":".$value["llave_secreta"])){

                    $clienteModel = new PedidosModel();
                    $cliente = $clienteModel->find($id);
                    

                    if(!empty($cliente)){
                        $datos = array( 'momento_pago' => 1 );
                        $cliente = $clienteModel->update($id , $datos);
                        
                        $data = array(

                                "Status"=>200,
                                "Detalle"=>"Se ha pagado con exito"
                                
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

    public function recuperarPedido($id) {
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

                    $clienteModel = new PedidosModel($db);
                    $cliente = $clienteModel->find($id);


                    if (!empty($cliente)) {
                        $datos = array('estado_pedido_prenda' => 1);
                        $cliente = $clienteModel->update($id, $datos);

                        $data = array(
                            "Status" => 200,
                            "Detalle" => "Se ha recuperado el pedido con éxito"
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

    public function recuperarPago($id) {
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

                    $clienteModel = new PedidosModel($db);
                    $cliente = $clienteModel->find($id);


                    if (!empty($cliente)) {
                        $datos = array('momento_pago' => 0);
                        $cliente = $clienteModel->update($id, $datos);

                        $data = array(
                            "Status" => 200,
                            "Detalle" => "Se ha recuperado el pedido con éxito"
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

    public function ServicioLavadoAll() {
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
                    
                    $usuariosModel = new PedidosModel();
                    $usuarios = $usuariosModel
                                ->getTipoLvadoAll();
                           
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
                            "Detalle" => "No hay ningún tipo de serviciode lavado registrado"
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

    public function TipoPedidoAll() {
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
                    
                    $usuariosModel = new PedidosModel();
                    $usuarios = $usuariosModel
                                ->getTipoPedidoAll();
                           
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
                            "Detalle" => "No hay ningún tipo de serviciode lavado registrado"
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

    public function TipoComprobanteAll() {
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
                    
                    $usuariosModel = new PedidosModel();
                    $usuarios = $usuariosModel
                                ->getTipoComprobanteAll();
                           
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
                            "Detalle" => "No hay ningún tipo de serviciode lavado registrado"
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
