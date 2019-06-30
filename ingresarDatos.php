
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
	$producto = "Nvidia_RTX";
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
			//</script>';�
		}


		require 'phpmailer.php';

	    $mail = new PHPMailer();
	    $mail -> CharSet = "UTF-8";

	    $mail->From     = $correo;
	    $mail->FromName = $nombre;
	    $mail->AddAddress("samuel.mejia@eclipsemex.mx"); // Direcci�n a la que llegaran los mensajes.
		$mail->AddAddress("contacto@eclipsemex.com"); // Direcci�n a la que llegaran los mensajes.

	    // Aqu� van los datos que apareceran en el correo que reciba

	    $mail->WordWrap = 50;
	    $mail->IsHTML(true);
	    $mail->Subject  =  "Solicitud de informacion - Nvidia";
	    $mail->Body     =  "Una persona solicita informacion acerca de Nvidia, estos son sus datos:<br><br>".
	                        "Nombre: " . $nombre . " <br> ".
	                        "Apellidos: " . $apellidos . " <br>".
	                        "Empresa: " . $empresa . " <br>".
	                        "Correo: " . $correo . " <br>".
	                        "Telefono: " . $telefono . " <br>".
	                        "Pais: " . $pais . " <br>".
	                        "Comentarios: " . $comentarios . " <br>";

	    // Datos del servidor SMTPS

	    $mail->IsSMTP();
	    $mail->Host = "mail.eclipsemex.com";  // Servidor de Salida.
	    $mail->SMTPAuth = true;
	    $mail->Username = "david.reyes@eclipsemex.com";  // Correo Electr�nico
	    $mail->Password = "DReyes@2016"; // Contrase�a

	    if ($mail->Send()){
	        echo "<script>alert('Formulario Enviado'); window.location.href = 'index.html';</script>";
	    }
	    else{
	        echo "<script>alert('Error al enviar el formulario');location.href ='javascript:history.back()';</script>";
	    }

	}

	sqlsrv_free_stmt($stmt);
	sqlsrv_close($conn);
?>
11:31 AM
