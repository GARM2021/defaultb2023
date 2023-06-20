<?php
	//Configuracion de la conexion a base de datos LOCAL
	$bd_host = "207.248.62.188";  //ip del web
	//$bd_host = "192.10.228.10"; 

	//$bd_host = "64.22.119.64"; 

	$bd_usuario = "g95xTesogpe"; 
	$bd_password = "#Gpe2022$"; 

	//$bd_usuario = "sa_pago_predial"; 
	//$bd_password = "InfoWeb2013"; 

	$bd_base = "gpe".trim(date("Y"));

	$con = mssql_connect($bd_host, $bd_usuario, $bd_password) or die('no se puede conectar a SQL Server'); 
	mssql_select_db($bd_base,$con); 
?>