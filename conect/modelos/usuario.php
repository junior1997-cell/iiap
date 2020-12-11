<?php 

	Class Usuario_iiap{
		//Implementamos nuestro constructor
		public function __construct()
		{

		}		

		//Listar todos los usuarios
		public function listar_all(){

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://localhost/iiap/iiap_restfull/index.php/Usuarios",
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

		//Listar un solo usuario
		public function listar_one($id){

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://localhost/iiap/iiap_restfull/index.php/Usuarios/show/".$id,
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
		
		//Agregar usuarios a la BD	

		public function add_user($nombre,$apellidos,$correo,$password,$cargo){

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://localhost/iiap/iiap_restfull/index.php/Usuarios/create",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => array(
			  		'nombre_persona' => $nombre,
				  	'apellidos_persona' => $apellidos,
				  	'correo_persona' => $correo,
				  	'password_persona' => $password,
				  	'idcargo' => $cargo
			  	),
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

		//Eliminar
		public function delete($id){

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://localhost/iiap/iiap_restfull/index.php/Usuarios/delete/".$id,
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

		//Actualizar
		public function update_user($id,$nombre,$apellidos,$correo,$password,$foto,$id_cargo){

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'http://localhost/iiap/iiap_restfull/index.php/Usuarios/Update/'.$id,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => 
			  'nombre_persona='.$nombre.'
			  &apellidos_persona='.$apellidos.'
			  &correo_persona='.$correo.'
			  &password_persona='.$password.'
			  &foto_persona='.$foto.'
			  &idcargo='.$id_cargo,
			  CURLOPT_HTTPHEADER => array(
			    'Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VUU2hUQnZPZ2R2SHI5UG5DdExGbXlUZy53Lmc1Y01pOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlY2ZpLi90RmxTRFhPOS9NOTlFNGxWS0xNOGdodzhOeQ==',
			    'Content-Type: application/x-www-form-urlencoded'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$data = json_decode( $response, true);
			// var_dump($data); die;
			return $data;
		}

		public function log_usuario($nom, $ape){
			# code...
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'http://192.168.10.104/iiap/iiap_restfull/index.php/Usuarios/login_usuario',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => 
			  array('correo_persona' => $nom,
			  		'password_persona' => $ape
			  ),
			  CURLOPT_HTTPHEADER => array(
			    'Authorization: Basic YTJhYTA3YWRmaGRmcmV4ZmhnZGZoZGZlcnR0Z2VUU2hUQnZPZ2R2SHI5UG5DdExGbXlUZy53Lmc1Y01pOm8yYW8wN29kZmhkZnJleGZoZ2RmaGRmZXJ0dGdlY2ZpLi90RmxTRFhPOS9NOTlFNGxWS0xNOGdodzhOeQ=='
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