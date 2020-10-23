<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\TipoLavadoModel;
use App\Models\RegistrosModel;

class TipoLavado extends Controller {
    
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

                    $TipoLavadoModel = new TipoLavadoModel($db);
                    $tipo = $TipoLavadoModel
                            ->findAll();
                    
                    if (!empty($tipo)) {

                        $data = array(
                            "Status" => 200,
                            "Total_Resultados" => count($tipo),
                            "Detalle" => $tipo
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
                    
                    $TipoLavadoModel = new TipoLavadoModel();
                    $tipo = $TipoLavadoModel->getTipoLavadoOne($id);
                    if (!empty($tipo)) {

                        $data = array(
                            "Status" => 200,
                            "Número Registro" =>$id,
                            "Detalle" => $tipo
                        );
                         return json_encode($data, true);
                    } else {

                        $data = array(
                            "Status" => 404,
                            "Detalle" => "No hay ningún Tipo d  registrado"
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
                        "nombre_tipo_lavado" => $request->getVar("nombre_tipo_lavado"),
                        "precio_tipo_lavado" => $request->getVar("precio_tipo_lavado")
                        );

                    if (!empty($datos)) {

                        // Validar los datos

                        $validation->setRules([
                            'nombre_tipo_lavado' => 'required',
                            'precio_tipo_lavado' => 'required|max_length[255]'
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
                                "nombre_tipo_lavado" => $datos["nombre_tipo_lavado"],
                                "precio_tipo_lavado" => $datos["precio_tipo_lavado"]);

                            $TipoLavadoModel = new TipoLavadoModel($db);
                            $prendas = $TipoLavadoModel->insert($datos);
                            $data = array(
                                "Status" => 200,
                                "Detalle" => "Registro exitoso, prendas guardado"
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
                            'nombre_tipo_lavado' => 'max_length[255]',
                            'precio_tipo_lavado' => 'max_length[255]'
                            
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

                            $TipoLavadoModel = new TipoLavadoModel($db);
                            $prendas = $TipoLavadoModel->find($id);
                            $datos = array(
                                "nombre_tipo_lavado" => $datos["nombre_tipo_lavado"],
                                "precio_tipo_lavado" => $datos["precio_tipo_lavado"]
                            
                            );

                            $prendas = $TipoLavadoModel->update($id, $datos);
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

                    $TipoLavadoModel = new TipoLavadoModel($db);
                    $prendas = $TipoLavadoModel->find($id);


                    if (!empty($prendas)) {
                        $datos = array('estado_tipo_lavado' => 0);
                        $prendas = $TipoLavadoModel->update($id, $datos);

                        $data = array(
                            "Status" => 200,
                            "Detalle" => $prendas
                        );

                        return json_encode($data, true);
                    } else {

                        $data = array(
                            "Status" => 404,
                            "Detalle" => "El tipo lavado a borrar no existe"
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

                    $TipoLavadoModel = new TipoLavadoModel($db);
                    $prendas = $TipoLavadoModel->find($id);


                    if (!empty($prendas)) {
                        $datos = array('estado_tipo_lavado' => 1);
                        $prendas = $TipoLavadoModel->update($id, $datos);

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




}