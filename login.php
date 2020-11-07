<?php

// Always start this first
session_start();

if ( ! empty( $_POST ) ) {
    if ( isset( $_POST['email'] ) && isset( $_POST['password'] ) ) {
		
        // Getting submitted user data from database
        //$con = new mysqli($db_host, $db_user, $db_pass, $db_name);
       $email = $_POST['email'];
	   $pass = $_POST['password'];
	   
	   include 'databaseconnect.php';
	   
		$sql = "SELECT * FROM users WHERE email='".$email."' AND password='".$pass."'";
		//echo $sql;
		$result = $conn->query($sql);

		
    		
		if ($result->num_rows> 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
								//echo $row["id"];
								$_SESSION['user_id'] = $row["id"];
							}
		} else {
							echo '<div class="alert alert-danger" role="alert">Credenciales incorrectas</div>';
		}
						
		
    }
}

if ( isset( $_SESSION['user_id'] ) ) {
    // Grab user data from the database using the user_id
    // Let them access the "logged in only" pages
	header("Location: index.php");
} else {
    // Redirect them to the login page
    
}


?>



<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="node_modules\bootstrap\dist\css\bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

	</head>
	
	<body>
	<div class="container text-center mt-5" style="">
	<h1 class="mb-5">Sistema de Inventario</h1>
	<div class="container mt-5" style="width:300px;">
		<form action="login.php" method="POST">
			<div class="form-group">
				<label for="exampleInputEmail1">Correo electrónico</label>
				<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingrese email" name="email">
				
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Password</label>
				<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
			</div>
			<button type="submit" class="btn btn-primary">Ingresar</button><br>
			<small id="emailHelp" class="form-text text-muted">email: admin@admin.com password:admin</small>
		</form>
	</div>
	</div>
	</body>

</html>