<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\RegistrosModel;

class Registros extends Controller {

    public function index() {
        $registroModel = new RegistrosModel($db);

        $registro = $registroModel->where('estado', 1 )->findAll();
        if (count($registro) == 0) {

            $respuesta = array('Error' => true, 'Mensaje' => 'No hay elementos');

            $data = json_encode($respuesta);
         } else {

             $r = array(
                            "Status" => 200,
                            "Total_Resultados" => count($registro),
                            "Det" => $registro
                                //"Paginador"=>$paginador
                        );

             $data = json_encode($r);
         }
         return $data;
    }

    public function create() {
        /*obtenemos el servicio de cualquier controlador
        En este caso del archivo Services le desimos que ejecute el metodo request() y el metodo validation()*/
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();

        $datos = array(
            'nombres' => $request->getVar("nombres"),
            'apellidos' => $request->getVar("apellidos"),
            'email' => $request->getVar("email")
        );
        //validacion de los datos
        //empty () verifica si una variable está vacía o no.
        if (!empty($datos)) {
            $validation->setRules([
                'nombres' => 'required|string|max_length[255]',
                'apellidos' => 'required|string|max_length[255]',
                'email' => 'required|valid_email|is_unique[registros.email]'
            ]);

            $validation->withRequest($this->request)
                    ->run();

            if ($validation->getErrors()) {
                $errors = $validation->getErrors();
                $data = array('Status' => 404, 'Detalle' => $errors);
                return json_encode($data, true);
            } else {
                $cli =$datos["nombres"] .' '. $datos["apellidos"] ;
                
                $cliente_id = crypt(
                        $datos["nombres"] . $datos["apellidos"] . $datos["email"],
                        '$2a$07$dfhdfrexfhgdfhdferttgsad$'
                );

                $llave_secreta = crypt(
                        $datos["email"] . $datos["apellidos"] . $datos["nombres"],
                        '$2a$07$dfhdfrexfhgdfhdferttgsad$'
                );

                $datos = array(
                    "nombres" => $datos["nombres"], "apellidos" => $datos["apellidos"], "email" => $datos["email"],
                    "cliente_id" => str_replace('$', 'a', $cliente_id),
                    "llave_secreta" => str_replace('$', 'o', $llave_secreta)
                );

                $registroModel = new RegistrosModel($db);
                $registro = $registroModel->insert($datos);
                $data = array('Status' => 200, 'Detalle' => 'Registro satisfactorio, guarde sus credenciales',
                    'Credenciales' => array("cliente_id" => str_replace('$', 'a', $cliente_id),
                        "llave_secreta" => str_replace('$', 'o', $llave_secreta),
                        'nom'=>$cli
                    )
                );
                return json_encode($data, true);
            }
        } else {

            $data = array('Status' => 404, 'Detalle' => 'Registro con errores');
            return $data;
        }
    }

}
