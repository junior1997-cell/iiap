<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CursosModel;
use App\Models\RegistrosModel;

class Cursos extends Controller {

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

          $CursosModel = new CursosModel();
          
          $Curso = $CursosModel->getCursoAll();

            
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



  public function one_curso($id) {
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
            
          $CursosModel = new CursosModel();
          
          $Curso = $CursosModel->getCursoOne($id);
                 
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

  //cursos  mas valorados
  public function cursos_mas_valorados($id) {
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
            
          $CursosModel = new CursosModel();
          
          $Curso = $CursosModel->getCursoMejorValorados($id);
                 
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

  //Contando cuantas categorias existen
  public function count_alumno() {
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
            $mayor = 0;
          $CursosModel = new CursosModel();
          
          $cant_categoria = $CursosModel->getCategoriaCount();
                 
          if (!empty($cant_categoria)) {

            foreach ($cant_categoria as $key => $value) {
                $curso_alumno_cat = $CursosModel->postCursoAlumno($value['id_categorias']);
                foreach ($curso_alumno_cat as $key => $val) {
                  if($val['cant_estudiantes_curso']>$mayor){
                    $mayor = $val['cant_estudiantes_curso'];
                  } 
                   $curso_datos = $CursosModel->postCursoAlumnoDatos($mayor);
            $data = array(
              "Status" => 200,
              "Número Registro" =>count($curso_alumno_cat),
              "Detalle" => $curso_alumno_cat
            );
                }
                      
            }

           

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

  //CUANTOS CURSOS POR CATEGORIAS HAY
  public function count_categoria() {
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
            
          $CursosModel = new CursosModel();
          
          $Curso = $CursosModel->getCategoriaCount();
                 
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

  //CURSOS DE CATEGORIA AGRICULTURA-----------------------------------------------
  public function listaAgricultura($id) {
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
            
          $CursosModel = new CursosModel();
          
          $Curso = $CursosModel->listaAgricultura($id);
                 
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

  // Lista de cursos ACUICOLA---------------------------
  public function listaAcuicola($id) {
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
            
          $CursosModel = new CursosModel();
          
          $Curso = $CursosModel->listaAcuicola($id);
                 
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

  // Lista de cursos ZOOTECNIA---------------------------
  public function listaZootecnia($id) {
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
            
          $CursosModel = new CursosModel();
          
          $Curso = $CursosModel->listaZootecnia($id);
                 
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
