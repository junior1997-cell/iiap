<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\MiCursoModel;
use App\Models\RegistrosModel;

class Micurso extends Controller {

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

          $MiCursoModel = new MiCursoModel();
          
          $Curso = $MiCursoModel->getMiCursoAll();

            
          if (!empty($Curso)) {

            $data = array(
              "Status" => 200,
              "Total_Resultados" => count($Curso),
              "Detalle" => $Curso
              //"Paginador"=>$paginador
            );
            return json_encode($data, true);
          } else {

            $data = array(
              "Status" => 404,
              "Total_Resultados" => 0,
              "Detalle" => "Ningún registro cargado"
            );
            return json_encode($data, true);
          }
        } else {

          $data = array(
            "Status" => 404,
            "Detalle" => "El token es inválido"
          );
          return json_encode($data, true);
        }
      } else {

        $data = array(
          "Status" => 404,
          "Detalle" => "No está autorizado para recibir los registros"
        );
        return json_encode($data, true);
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
            
          $MiCursoModel = new MiCursoModel();
          
          $Curso = $MiCursoModel->getMiCursoUnic($id);
                 
          if (!empty($Curso)) {

            $data = array(
              "Status" => 200,
              "Número Registro" =>$id,
              "Detalle" => $Curso
            );

            return json_encode($data, true);
          } else {

            $data = array(
              "Status" => 404,
              "Detalle" => "No hay ningun Cursos con Categorias"
            );
            return json_encode($data, true);
          }
        } else {

          $data = array(
            "Status" => 404,
            "Detalle" => "El token es invalido"
          );
          return json_encode($data, true);
        }
      } else {

        $data = array(
          "Status" => 404,
          "Detalle" => "No esta autorizado para recibir los Cursos con Categorias"
        );
        return json_encode($data, true);
      }
    }

    return json_encode($data, true);
  }

}
