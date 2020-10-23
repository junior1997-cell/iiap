<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CargoModel;
use App\Models\RegistrosModel;

class Cargo extends Controller {

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

                    $cargoModel = new CargoModel();
                    
                    $cargo = $cargoModel->where('estado_cargo',1)
                            ->findAll();

                    
                    if (!empty($cargo)) {

                        $data = array(
                            "Status" => 200,
                            "Total_Resultados" => count($cargo),
                            "Detalle" => $cargo
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
                    $cliente = $clienteModel->where('estado', 1)
                            ->find($id);
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
                    $datos = array("nombre" => $request->getVar("nombre"),
                        "correo" => $request->getVar("correo"),
                        "zip" => $request->getVar("zip"),
                        "telefono1" => $request->getVar("telefono1"),
                        "telefono2" => $request->getVar("telefono2"),
                        "pais" => $request->getVar("pais"),
                        "direccion" => $request->getVar("direccion")
                    );

                    if (!empty($datos)) {

                        // Validar los datos

                        $validation->setRules([
                            'nombre' => 'required|string|max_length[255]',
                            'correo' => 'required|valid_email',
                            'zip' => 'required|string|max_length[255]',
                            'telefono1' => 'required|string|max_length[255]',
                            'telefono2' => 'required|string|max_length[255]',
                            'pais' => 'required|string|max_length[255]',
                            'direccion' => 'required|string|max_length[255]'
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
                            $datos = array("nombre" => $datos["nombre"],
                                "correo" => $datos["correo"],
                                "zip" => $datos["zip"],
                                "telefono1" => $datos["telefono1"],
                                "telefono2" => $datos["telefono2"],
                                "pais" => $datos["pais"],
                                "direccion" => $value["direccion"]);

                            $clienteModel = new ClientesModel($db);
                            $cliente = $clienteModel->insert($datos);
                            $data = array(
                                "Status" => 200,
                                "Detalle" => "Registro exitoso, cliente guardado"
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
                            'nombre' => 'required|string|max_length[255]',
                            'correo' => 'required|valid_email',
                            'zip' => 'required|string|max_length[255]',
                            'telefono1' => 'required|string|max_length[255]', 'telefono2' => 'required|string|max_length[255]',
                            'pais' => 'required|string|max_length[255]',
                            'direccion' => 'required|string|max_length[255]'
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

                            $clienteModel = new ClientesModel($db);
                            $cliente = $clienteModel->find($id);
                            $datos = array(
                                "nombre" => $datos["nombre"],
                                "correo" => $datos["correo"],
                                "zip" => $datos["zip"],
                                "telefono1" => $datos["telefono1"],
                                "telefono2" => $datos["telefono2"],
                                "pais" => $datos["pais"],
                                "direccion" => $datos["direccion"]
                            );

                            $cliente = $clienteModel->update($id, $datos);
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

                    $clienteModel = new ClientesModel($db);
                    $cliente = $clienteModel->find($id);


                    if (!empty($cliente)) {
                        $datos = array('activo' => 0);
                        $cliente = $clienteModel->update($id, $datos);

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

}
