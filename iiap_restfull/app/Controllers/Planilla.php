<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PlanillaModel;
use App\Models\RegistrosModel;

class Planilla extends Controller {
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

                    $Planilla = new PlanillaModel();
                    //$librodiario = $Librodiario->findAll();
                    $Planilla = $Planilla->getplanilla();
                    
                    if (!empty($Planilla)) {    

                        $data = array(
                            "Status" => 200,
                            "Total_Resultados" => count($Planilla),
                            "Detalle" => $Planilla
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
                    
                    $Planilla = new PlanillaModel();
                    $prendas = $Planilla->getdetalle_pedido_prenda($id);
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
                    //El getVar()método extraerá de $ _REQUEST, por lo que devolverá cualquier dato de $ _GET, $ POST 
                    $datos = array(
                            "codigo_planilla" => $request->getVar("codigo_planilla"),
                            "nombres_planilla" => $request->getVar("nombres_planilla"),
                            "id_cargo_ocupacion" => $request->getVar("id_cargo_ocupacion"),
                            "asig_familiar_planilla" => $request->getVar("asig_familiar_planilla"),
                            "sueldo_basico_planilla" => $request->getVar("sueldo_basico_planilla"),
                            "monto_asig_familiar_planilla" => $request->getVar("monto_asig_familiar_planilla"),
                            "otros_planilla" => $request->getVar("otros_planilla"),
                            "total_remunera_bruta_planilla" => $request->getVar("total_remunera_bruta_planilla"),
                            "snp_onp_planilla" => $request->getVar("snp_onp_planilla"),
                            "monto_onp" => $request->getVar("monto_onp"),
                            "id_afp" => $request->getVar("id_afp"),
                            "aporte_obligatorio_planilla" => $request->getVar("aporte_obligatorio_planilla"),
                            "comision_sobre_ra_planilla" => $request->getVar("comision_sobre_ra_planilla"),
                            "prima_seguro_planilla" => $request->getVar("prima_seguro_planilla"),
                            "total_descuento_planilla" => $request->getVar("total_descuento_planilla"),
                            "remuneracion_neta_planilla" => $request->getVar("remuneracion_neta_planilla"),
                            "aporte_salud_planilla" => $request->getVar("aporte_salud_planilla"),
                            "aporte_sctr_planilla" => $request->getVar("aporte_sctr_planilla"),
                            "aporte_total_planilla" => $request->getVar("aporte_total_planilla"),
                            "fecha_planilla" => $request->getVar("fecha_planilla")
                    );

                    if (!empty($datos)) {

                        // Validar los datos

                        $validation->setRules([
                            'nombres_planilla' => 'required|string|max_length[255]'

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
                            $datos = array(
                            "codigo_planilla" => $datos["codigo_planilla"],
                            "nombres_planilla" => $datos["nombres_planilla"],
                            "id_cargo_ocupacion" => $datos["id_cargo_ocupacion"],
                            "asig_familiar_planilla" => $datos["asig_familiar_planilla"],
                            "sueldo_basico_planilla" => $datos["sueldo_basico_planilla"],
                            "monto_asig_familiar_planilla" => $datos["monto_asig_familiar_planilla"],
                            "otros_planilla" => $datos["otros_planilla"],
                            "total_remunera_bruta_planilla" => $datos["total_remunera_bruta_planilla"],
                            "snp_onp_planilla" => $datos["snp_onp_planilla"],
                            "monto_onp" => $datos["monto_onp"],
                            "id_afp" => $datos["id_afp"],
                            "aporte_obligatorio_planilla" => $datos["aporte_obligatorio_planilla"],
                            "comision_sobre_ra_planilla" => $datos["comision_sobre_ra_planilla"],
                            "prima_seguro_planilla" => $datos["prima_seguro_planilla"],
                            "total_descuento_planilla" => $datos["total_descuento_planilla"],
                            "remuneracion_neta_planilla" => $datos["remuneracion_neta_planilla"],
                            "aporte_salud_planilla" => $datos["aporte_salud_planilla"],
                            "aporte_sctr_planilla" => $datos["aporte_sctr_planilla"],
                            "aporte_total_planilla" => $datos["aporte_total_planilla"],
                            "fecha_planilla" => $datos["fecha_planilla"]

                            );

                           // var_dump($datos); die;

                            $Planillamodel = new PlanillaModel($db);
                            $planilla = $Planillamodel->insert($datos);
                            $data = array(
                                "Status" => 200,
                                "Detalle" => "Registro exitoso, Planilla guardado"
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

    public function usuarioselect() {
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

                    $Planilla = new PlanillaModel();
                    //$librodiario = $Librodiario->findAll();
                    $ListarV = $Planilla->get_usuarios();
                    
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

    public function listarplanilla() {
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

                    $Planilla = new PlanillaModel();
                    //$librodiario = $Librodiario->findAll();
                    $ListarV = $Planilla->getplanilla();
                    
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


    public function afpselect() {
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

                    $Planilla = new PlanillaModel();
                    //$librodiario = $Librodiario->findAll();
                    $ListarV = $Planilla->get_afp();
                    
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

    public function cargoselect() {
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

                    $Planilla = new PlanillaModel();
                    //$librodiario = $Librodiario->findAll();
                    $ListarV = $Planilla->get_cargo();
                    
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


