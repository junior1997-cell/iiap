<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LibrodiarioModel;
use App\Models\RegistrosModel;

class Librodiario extends Controller {
    //lista de todos los campos de prendas
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

                    $Librodiario = new LibrodiarioModel();
                    //$librodiario = $Librodiario->findAll();
                    $librodiario = $Librodiario->getlibro_diario();
                    
                    if (!empty($librodiario)) {

                        $data = array(
                            "Status" => 200,
                            "Total_Resultados" => count($librodiario),
                            "Detalle" => $librodiario
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
                    
                    $Librodiario = new LibrodiarioModel();
                    $prendas = $Librodiario->getdetalle_pedido_prenda($id);
                    if (!empty($prendas)) {

                        $data = array(
                            "Status" => 200,
                            "Número Registro" =>$id,
                            "Detalle" => $prendas
                        );
                         return json_encode($data, true);
                    } else {

                        $data = array(
                            "Status" => 404,
                            "Detalle" => "No hay ningún prendas registrado"
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

                        //CAPTURAMOS TODOS LOS DATOS TIPO ARRAY, ENVIADOS DESDE EL FORMULARIO 
                        $LibrodiarioModel = new LibrodiarioModel();
                        
                        $n_operacion = $request->getVar("n_operacion");
                        $fecha = $request->getVar("fecha");
                        $glosa = $request->getVar("glosa");
                        $id_libro_contable = $request->getVar("id_libro_contable");
                        $doc_sustet = $request->getVar("doc_sustet");
                        $id_plan_contable = $request->getVar("id_plan_contable");
                        $debe = $request->getVar("debe");
                        $haber = $request->getVar("haber");

                        //DECODIFICAMOS EL ARRAY QUE SE HA CAPTURADO COMO STRING
                        $deco_n_operacion =json_decode($n_operacion,true);
                        $deco_fecha = json_decode($fecha,true);
                        $deco_glosa =json_decode($glosa,true);
                        $deco_id_libro_contable = json_decode($id_libro_contable,true);
                        $deco_doc_sustet =json_decode($doc_sustet,true);
                        $deco_id_plan_contable = json_decode($id_plan_contable,true);
                        $deco_debe =json_decode($debe,true);
                        $deco_haber = json_decode($haber,true);
                        var_dump($deco_n_operacion,$deco_fecha,$deco_glosa,$deco_id_libro_contable,$deco_doc_sustet,$deco_id_plan_contable,$deco_debe,$haber);die;
                        return json_encode($deco_haber, true);
                        //print_r($deco_haber);

                        //CREAMOS UN CONTADOR PARA RECORRER EL ARRAY
                        $cont_elementos=0;

                        while ($cont_elementos < count($n_operacion)) {
                            $datitos=array('n_operacion' => $n_operacion[$cont_elementos],
                                        'fecha' => $fecha[$cont_elementos],
                                        'glosa'=>$glosa[$cont_elementos],
                                        'id_libro_contable'=>$id_libro_contable[$cont_elementos],
                                        'doc_sustet'=>$doc_sustet[$cont_elementos],
                                        'id_plan_contable'=>$id_plan_contable[$cont_elementos],
                                        'debe'=>$debe[$cont_elementos],
                                        'haber'=>$haber[$cont_elementos]
                                    );
                            // return json_encode($datitos, true)
                            $detatitos_insert = $LibrodiarioModel->insert($datitos);
                            $cont_elementos=$cont_elementos + 1 ;
                        }
                        $data = array(
                            "Status" => 200,
                            "Detalle" => "Registro exitoso, prendas guardado"
                        );
                         // return json_encode($data, true);
                    } else {

                        $data = array(
                            "Status" => 404,
                            "Detalle" => "Registro con errores"
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

    public function update($id) {
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
                    // Tomar datos      
                    $datos = $this->request->getRawInput();
                    if (!empty($datos)) {
                        //Validar datos
                        $validation->setRules([
                            'imagen' => 'required|string|max_length[255]',
                            'nombre' => 'required|string',
                            'precio' => 'required|max_length[255]'
                            
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

                            $PrendasModel = new PrendasModel($db);
                            $prendas = $PrendasModel->find($id);
                            $datos = array(
                                "imagen" => $datos["imagen"],
                                "nombre" => $datos["nombre"],
                                "precio" => $datos["precio"]
                            
                            );

                            $prendas = $PrendasModel->update($id, $datos);
                            $data = array(
                                "Status" => 200,
                                "Detalle" => "Datos de cliente actualizado"
                            );
                            return json_encode($data, true);
                        }
                    } else {

                        $data = array(
                            "Status" => 404,
                            "Detalle" => "Registro con errores"
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

                    $PrendasModel = new PrendasModel($db);
                    $prendas = $PrendasModel->find($id);


                    if (!empty($prendas)) {
                        $datos = array('estado' => 0);
                        $prendas = $PrendasModel->update($id, $datos);

                        $data = array(
                            "Status" => 200,
                            "Detalle" => "Se ha borrado con éxito"
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

    public function listarvent() {
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

                    $Librodiario = new LibrodiarioModel();
                    //$librodiario = $Librodiario->findAll();
                    $ListarV = $Librodiario->getpedido_prenda();
                    
                    if (!empty($ListarV)) {

                        $data = array(
                            "Status" => 200,
                            "Total_Resultados" => count($ListarV),
                            "Detalle" => $ListarV
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

    public function librocontable() {
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

                    $Librodiario = new LibrodiarioModel();
                    //$librodiario = $Librodiario->findAll();
                    $ListarV = $Librodiario->getlibroContable();
                    
                    if (!empty($ListarV)) {

                        $data = array(
                            "Status" => 200,
                            "Total_Resultados" => count($ListarV),
                            "Detalle" => $ListarV
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

    public function detallespedido($idpedido) {
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

                    $Librodiario = new LibrodiarioModel();
                    //$librodiario = $Librodiario->findAll();
                    $ListarV = $Librodiario->getdetalle_pedido_prenda($idpedido);
                    
                    if (!empty($ListarV)) {

                        $data = array(
                            "Status" => 200,
                            "Total_Resultados" => count($ListarV),
                            "Detalle" => $ListarV
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

    public function total_pedido($id) {
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
                    
                    $Librodiario = new LibrodiarioModel();
                    $prendas = $Librodiario->get_total_pedido_ld($id);
                    if (!empty($prendas)) {

                        $data = array(
                            "Status" => 200,
                            "Número Registro" =>$id,
                            "Detalle" => $prendas
                        );
                         return json_encode($data, true);
                    } else {

                        $data = array(
                            "Status" => 404,
                            "Detalle" => "No hay ningún total pedido registrado"
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