<?php

	//Proceso de conexión con la base de datos
	include("conexion.php");

	$nombre = $_POST['nombre'];
	$apellidos = $_POST['apellidos'];
	$empresa = $_POST['empresa'];
	$correo = $_POST['correo'];
	$telefono = $_POST['telefono'];
	$pais = $_POST['pais'];
	$comentarios = $_POST['comentarios'];
	$producto = "Nvidia_Servicio";
	$oculto = $_POST['oculto'];

	// specify params - MUST be a variable that can be passed by reference!
	$myparams['nombre'] = $nombre;
	$myparams['apellidos'] = $apellidos;
	$myparams['nom_emp'] = $empresa;
	$myparams['telefono'] = $telefono;
	$myparams['correo'] = $correo;
	$myparams['pais'] = $pais;
	$myparams['coment'] = $comentarios;
	$myparams['nom_producto'] = $producto;

	// Set up the proc params array - be sure to pass the param by reference
	$procedure_params = array(
	array(&$myparams['nombre'], SQLSRV_PARAM_IN),
	array(&$myparams['apellidos'], SQLSRV_PARAM_IN),
	array(&$myparams['nom_emp'], SQLSRV_PARAM_IN),
	array(&$myparams['telefono'], SQLSRV_PARAM_IN),
	array(&$myparams['correo'], SQLSRV_PARAM_IN),
	array(&$myparams['pais'], SQLSRV_PARAM_IN),
	array(&$myparams['coment'], SQLSRV_PARAM_IN),
	array(&$myparams['nom_producto'], SQLSRV_PARAM_IN)
	);

	if ($oculto == ''){
		$sql = "EXEC sp_registro @nombre = ?, @apellidos = ?, @nom_emp = ?, @telefono = ?, @correo = ?, @pais = ?, @coment = ?, @nom_producto = ?";

		$stmt = sqlsrv_prepare($conn, $sql, $procedure_params);

		if( !$stmt ) {
			die( print_r( sqlsrv_errors(), true));
		}

		if(sqlsrv_execute($stmt)){
				while($res = sqlsrv_next_result($stmt)){
				// make sure all result sets are stepped through, since the output params may not be set until this happens
			}
			//echo '<script language = javascript>
			//alert("Registro enviado correctamente.")
			//self.location = "index.html"
			//</script>';
		}
		else{
			die( print_r( sqlsrv_errors(), true));
			//echo '<script language = javascript>
			//alert("Favor de intentarlo de nuevo.")
			//self.location = "index.html"
			//</script>';
		}


		$to      = "contacto@eclipsemex.com", "samuel.mejia@eclipsemex.mx";
		$subject = "Solicitud de informacion - Servicio-Nvidia";
		$message = "Una persona solicita informacion acerca de Servicio-Nvidia, a continuacion se muestran sus datos:\n\n".
		            "Nombre: " . $nombre . "\n".
		            "Apellidos: " . $apellidos . "\n".
		            "Empresa: " . $empresa . "\n".
		            "Correo: " . $correo . "\n".
		            "Telefono: " . $telefono . "\n".
		            "Pais: " . $pais . "\n".
		            "Comentarios: " . $comentarios . "\n";
		$headers = "From:" . $correo . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);
	        echo "<script>alert('Formulario Enviado'); window.location.href = 'index.html';</script>";


	}

	sqlsrv_free_stmt($stmt);
	sqlsrv_close($conn);
?>
