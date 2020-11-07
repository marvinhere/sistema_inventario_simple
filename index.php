<?php
session_start();
if ( isset( $_SESSION['user_id'] ) ) {
    // Grab user data from the database using the user_id
    // Let them access the "logged in only" pages

} else {
    // Redirect them to the login page
    header("Location: login.php");
}
	include 'databaseconnect.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="node_modules\bootstrap\dist\css\bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
		<script src="node_modules\jquery\dist\jquery.js"></script>

<script src="node_modules\bootstrap\dist\js\bootstrap.js"></script>
		<script src="node_modules\axios\dist\axios.js"></script>
	</head>
	<body>
	
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">S. Inventario</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
   
    </ul>
    <form class="form-inline my-2 my-lg-0" action="logout.php" method="POST">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Salir</button>
    </form>
  </div>
</nav>

	
	<div class="container mt-5">
		<button type="button" class="btn btn-primary mb-5" data-toggle="modal" data-target="#exampleModal">
  Producto Nuevo
		</button>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">Código</th>
					<th scope="col">Nombre</th>
					<th scope="col">Ubicación</th>
					<th scope="col">Cantidad</th>
					<th scope="col"></th>
					<th scope="col"></th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>
				<?php
					
						$sql = "SELECT id, nombre, ubicacion, cantidad FROM productos";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
							$html = '<th scope="row">'. $row["id"].'</th>'.'<td>'. $row["nombre"].'</td><td>'. $row["ubicacion"].'</td><td>'.$row["cantidad"].'</td><td><button type="button" class="btn btn-primary" onclick="agregar('."'". $row["id"]."'".')">Agregar</button></td>'.'<td><button type="button" class="btn btn-primary" onclick="quitar('."'". $row["id"]."'".')">Quitar</button></td><td><button type="button" class="btn btn-danger" onclick="eliminar('."'". $row["id"]."'".')">Eliminar</button></td>';
								echo "<tr>".$html."</tr>";
							}
						} else {
							echo "0 results";
						}
						$conn->close();
					?>
			</tbody>
		</table>
	</div>



<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Producto nuevo</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div>
						<div class="form-group">
							<label for="exampleInputEmail1">Nombre</label>
							<input type="text" class="form-control" id="nombre" name="nombre">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Ubicación</label>
							<select class="form-control" id="ubicacion">
								<option value="Estante 1">Estante 1</option>
								<option value="Estante 2">Estante 2</option>
								<option value="Estante 3">Estante 3</option>
								<option value="Estante 4">Estante 4</option>
							</select>
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Cantidad</label>
							<input type="number" class="form-control" id="cantidad" name="cantidad">
						</div>
						<button type="button" class="btn btn-primary" onclick="subir()">Submit</button>
					</div>
				</div>

			</div>
		</div>
	</div>
	
	<script>
	
	var HTTP = axios.create({
			baseURL: "http://localhost/sistema_inventario/api.php"
		})
	
	function agregar(id){

		let producto = {
			id: id
		};
		
		HTTP
		.post("/agregar",producto)
		.then(respuesta => {
			//console.log(respuesta.data);
		
			if(respuesta.data=="ok"){
				location.reload();
			}else{
				console.log('Error');
			}
		});
	}
	
	function quitar(id){
		
		let producto = {
			id: id
		};
		
		HTTP
		.post("/quitar",producto)
		.then(respuesta => {
			//console.log(respuesta.data);
			if(respuesta.data=="ok"){
				location.reload();
			}else{
				console.log('Error');
			}
		});
	}
	
	function eliminar(id){
		
		let producto = {
			id: id
		};
		
		HTTP
		.post("/eliminar",producto)
		.then(respuesta => {
			//console.log(respuesta.data);
			if(respuesta.data=="ok"){
				location.reload();
			}else{
				console.log('Error');
			}
		});
	}
	
	
		$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})
		
	function subir(){
		//var form = document.getElementById("newForm");
		var nombre = document.getElementById("nombre").value;
		var ubicacion = document.getElementById("ubicacion").value;
		var cantidad = document.getElementById("cantidad").value;
		
		let producto = {
			nombre: nombre,
			ubicacion:ubicacion,
			cantidad: cantidad
		};
		
		console.log(producto);
		
		HTTP
		.post("/subir",producto)
		.then(respuesta => {
			//console.log(respuesta.data);
			if(respuesta.data=="ok"){
				location.reload();
			}else{
				console.log('Error '+respuesta);
			}
		});
	}
	
	</script>
	
		</body>

</html>
<?php


?>