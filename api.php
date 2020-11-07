<?php

 header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Max-Age: 86400');
$metodo = $_SERVER["REQUEST_METHOD"];
	$ruta = implode("/", array_slice(explode("/", $_SERVER["REQUEST_URI"]), 3));
	$datos = json_decode(file_get_contents("php://input"));
	switch($metodo){
		case 'GET':
			switch ($ruta) {
				case 'usuarios':
					echo json_encode("Te doy los usuarios");
					break;
				case 'ventas':
					echo json_encode("Te doy las ventas");
					break;
			}
		break;
		case 'POST':
			switch ($ruta) {
				case 'agregar':
					$did = $datos->id;
					if(agregar($did)){
						echo json_encode("ok");
					}else{
						echo json_encode("400");
					}
					
					break;
				case 'quitar':
					$did = $datos->id;
					if(quitar($did)){
						echo json_encode("ok");
					}else{
						echo json_encode("400");
					}
				break;
				case 'eliminar':
					$did = $datos->id;
					if(eliminar($did)){
						echo json_encode("ok");
					}else{
						echo json_encode("400");
					}
				break;
				case 'subir':
					
					if(subir($datos)){
						echo json_encode("ok");
					}else{
						echo json_encode("400");
					}
				break;
			}
		break;
	
	}
	
	
	function agregar($id){
		include 'databaseconnect.php';
		$resultado = false;
		$sql = "UPDATE productos SET cantidad=cantidad+1 WHERE id=".$id;

if ($conn->query($sql) === TRUE) {
  $resultado = true;
} else {
  $resultado = false;
}
//$conn->close();
return $resultado;
	}
	
	
	function quitar($id){
		
		include 'databaseconnect.php';
		$resultado = false;
		$sql = "UPDATE productos SET cantidad=cantidad-1 WHERE id=".$id;

if ($conn->query($sql) === TRUE) {
  $resultado = true;
} else {
  $resultado = false;
}
//$conn->close();
return $resultado;
	}
	
	function eliminar($id){
		include 'databaseconnect.php';
		$resultado = false;
		$sql = "DELETE FROM productos WHERE id=".$id;

if ($conn->query($sql) === TRUE) {
  $resultado = true;
} else {
  $resultado = false;
}
//$conn->close();
return $resultado;
	}
	
	
	function subir($datos){
		$nombre = $datos->nombre;
		$ubicacion = $datos->ubicacion;
		$cantidad = $datos->cantidad;
		include 'databaseconnect.php';
		$resultado = false;
		$sql = "INSERT INTO productos (nombre, ubicacion, cantidad) VALUES ('$nombre', '$ubicacion', '$cantidad')";

		if ($conn->query($sql) === TRUE) {
			$resultado = true;
		} else {
			$resultado = false;
		}
//$conn->close();
return $resultado;
	}
	
?>