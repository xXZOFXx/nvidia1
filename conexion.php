<?php
	//Nombre del servidor \nombre de la instancia
	$serverName = "18.217.147.215\sqlexpress, 1433"; 
	$connectionInfo = array( "Database"=>"cliente_db", "UID"=>"sa", "PWD"=>"C0m3x@2018", "CharacterSet" => "UTF-8");
	$conn = sqlsrv_connect( $serverName, $connectionInfo);

	if($conn) {
    	echo "Conexión establecida.<br>";
	}else{
     	echo "Conexión no se pudo establecer.<br>";
     	die( print_r( sqlsrv_errors(), true));
	}
?>