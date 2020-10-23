<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\BalanceModel;
use App\Models\RegistrosModel;

class balance extends Controller {
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

                    $balanceModel = new BalanceModel($db);
                    $total = $balanceModel->gettotaldebe();
                    
                    if (!empty($total)) {

                        $data = array(
                            "Status" => 200,
                            "Total_Resultados" => count($total),
                            "Detalle" => $total
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

    public function totaldetotal() {
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

                    $balanceModel = new BalanceModel($db);
                    $total10 = $balanceModel->get_total_debehaber_10();
                    $total12 = $balanceModel->get_total_debehaber_12();
                    $total14 = $balanceModel->get_total_debehaber_14();
                    $total20 = $balanceModel->get_total_debehaber_20();
                    $total33 = $balanceModel->get_total_debehaber_33();
                    $total40 = $balanceModel->get_total_debehaber_40();
                    $total41 = $balanceModel->get_total_debehaber_41();
                    $total42 = $balanceModel->get_total_debehaber_42();
                    $total45 = $balanceModel->get_total_debehaber_45();
                    $total46 = $balanceModel->get_total_debehaber_46();

                    $total50 = $balanceModel->get_total_debehaber_50();
                    $total59 = $balanceModel->get_total_debehaber_59();
                    $total60 = $balanceModel->get_total_debehaber_60();
                    $total61 = $balanceModel->get_total_debehaber_61();
                    $total62 = $balanceModel->get_total_debehaber_62();
                    $total63 = $balanceModel->get_total_debehaber_63();
                    $total69 = $balanceModel->get_total_debehaber_69();
                    $total70 = $balanceModel->get_total_debehaber_70();
                    $total79 = $balanceModel->get_total_debehaber_79();
                    $total94 = $balanceModel->get_total_debehaber_94();
                    $total95 = $balanceModel->get_total_debehaber_95();
                   // $total46 = $balanceModel->get_total_debehaber_46();

                    
                    if (!empty($total10)) {

                        $data = array(
                            "Status" => 200,
                            "Total_Resultados" => count($total10),
                            "Detalle10" => $total10,
                            "Detalle12" => $total12,
                            "Detalle14" => $total14,
                            "Detalle20" => $total20,
                            "Detalle33" => $total33,

                            "Detalle40" => $total40,
                            "Detalle41" => $total41,
                            "Detalle42" => $total42,
                            "Detalle45" => $total45,
                            "Detalle46" => $total46,

                            "Detalle50" => $total50,
                            "Detalle59" => $total59,
                            "Detalle60" => $total60,
                            "Detalle61" => $total61,
                            "Detalle62" => $total62,

                            "Detalle63" => $total63,
                            "Detalle69" => $total69,
                            "Detalle70" => $total70,
                            "Detalle79" => $total79,

                            "Detalle94" => $total94,
                            "Detalle95" => $total95

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
                    
                    $PrendasModel = new PrendasModel();
                    $prendas = $PrendasModel->find($id);
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
                    $datos = array("imagen_prenda" => $request->getVar("imagen_prenda"),
                        "nombre_prenda" => $request->getVar("nombre_prenda"),
                        "precio_prenda" => $request->getVar("precio_prenda")
                        );

                    if (!empty($datos)) {

                        // Validar los datos

                        $validation->setRules([
                            'nombre_prenda' => 'required|string',
                            'precio_prenda' => 'required|max_length[255]'
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
                            $datos = array("imagen_prenda" => $datos["imagen_prenda"],
                                "nombre_prenda" => $datos["nombre_prenda"],
                                "precio_prenda" => $datos["precio_prenda"]);

                            $PrendasModel = new PrendasModel($db);
                            $prendas = $PrendasModel->insert($datos);
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
                            'nombre_prenda' => 'required|string',
                            'precio_prenda' => 'required|max_length[255]'
                            
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
                                "imagen_prenda" => $datos["imagen_prenda"],
                                "nombre_prenda" => $datos["nombre_prenda"],
                                "precio_prenda" => $datos["precio_prenda"]
                            
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
                        $datos = array('estado_prenda' => 0);
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


}