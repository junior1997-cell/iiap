<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\DeliveryModel;
use App\Models\RegistrosModel;

class Delivery extends Controller {
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

                    $Deliverym = new DeliveryModel();
                    $delivery = $Deliverym
                            ->findAll();
                    
                    if (!empty($delivery)) {

                        $data = array(
                            "Status" => 200,
                            "Total_Resultados" => count($delivery),
                            "Detalle" => $delivery
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
                    $datos = array("nombre" => $request->getVar("nombre"));

                    if (!empty($datos)) {

                        // Validar los datos

                        $validation->setRules(['nombre' => 'required|string|max_length[255]']);

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
                            $datos = array("nombre" => $datos["nombre"]);

                            $Deliverym = new DeliveryModel($db);
                            $delivery = $Deliverym->insert($datos);
                            $data = array(
                                "Status" => 200,
                                "Detalle" => "Registro exitoso, delivery guardado"
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

}