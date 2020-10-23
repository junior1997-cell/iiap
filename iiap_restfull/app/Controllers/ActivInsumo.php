<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\InsumosModel;
use App\Models\RegistrosModel;

class activInsumo extends Controller {

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

                    $InsumosModel = new InsumosModel($db);
                    $insumo = $InsumosModel->find($id);


                    if (!empty($insumo)) {
                        $datos = array('estado' => 1);
                        $insumo = $InsumosModel->update($id, $datos);

                        $data = array(
                            "Status" => 200,
                            "Detalle" => "Actualizado con éxito"
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