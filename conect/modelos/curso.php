<?php 

	Class Curso_iiap{
		//Implementamos nuestro constructor
		public function __construct()
		{

		}		

		//Listar todos los curso
		public function listar_curso_all(){

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://localhost/iiap/iiap_restfull/index.php/Cursos",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    "Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VUU2hUQnZPZ2R2SHI5UG5DdExGbXlUZy53Lmc1Y01pOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlY2ZpLi90RmxTRFhPOS9NOTlFNGxWS0xNOGdodzhOeQ=="
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$data = json_decode( $response, true);
			// var_dump($data); die;
			return $data;
		}

		//Listar un curso
		public function listar_curso_one($id){

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://localhost/iiap/iiap_restfull/index.php/Cursos/one_curso/".$id,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_HTTPHEADER => array(
			    "Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VUU2hUQnZPZ2R2SHI5UG5DdExGbXlUZy53Lmc1Y01pOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlY2ZpLi90RmxTRFhPOS9NOTlFNGxWS0xNOGdodzhOeQ=="
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$data = json_decode( $response, true);
			// var_dump($data); die;
			return $data;
		}
		//Listar cursos
		public function listar_curso_valorado($id){

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://localhost/iiap/iiap_restfull/index.php/Cursos/one_curso/".$id,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_HTTPHEADER => array(
			    "Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VUU2hUQnZPZ2R2SHI5UG5DdExGbXlUZy53Lmc1Y01pOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlY2ZpLi90RmxTRFhPOS9NOTlFNGxWS0xNOGdodzhOeQ=="
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$data = json_decode( $response, true);
			// var_dump($data); die;
			return $data;
		}
		//Listar cursos de Agricultura
		public function listar_curso_agricultura(){

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://192.168.10.104/iiap/iiap_restfull/index.php/Cursos/listaAgricultura/3",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_HTTPHEADER => array(
			    "Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VUU2hUQnZPZ2R2SHI5UG5DdExGbXlUZy53Lmc1Y01pOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlY2ZpLi90RmxTRFhPOS9NOTlFNGxWS0xNOGdodzhOeQ=="
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$data = json_decode( $response, true);
			// var_dump($data); die;
			return $data;
		}
		//Listar cursos de Agricultura
		public function listar_curso_acuicola(){

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://192.168.10.104/iiap/iiap_restfull/index.php/Cursos/listaAcuicola/3",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_HTTPHEADER => array(
			    "Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VUU2hUQnZPZ2R2SHI5UG5DdExGbXlUZy53Lmc1Y01pOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlY2ZpLi90RmxTRFhPOS9NOTlFNGxWS0xNOGdodzhOeQ=="
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$data = json_decode( $response, true);
			// var_dump($data); die;
			return $data;
		}

		//Listar cursos de Zootecnia
		public function listar_curso_zootecnia(){

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://192.168.10.104/iiap/iiap_restfull/index.php/Cursos/listaZootecnia/3",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_HTTPHEADER => array(
			    "Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VUU2hUQnZPZ2R2SHI5UG5DdExGbXlUZy53Lmc1Y01pOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlY2ZpLi90RmxTRFhPOS9NOTlFNGxWS0xNOGdodzhOeQ=="
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$data = json_decode( $response, true);
			// var_dump($data); die;
			return $data;
		}		
	}
?>