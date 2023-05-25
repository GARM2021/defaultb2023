<?php

//  > garm 20220825
// DATOS RECIBIDOS POR EL BANCO.
// 	$wsecuencia  = substr($_POST["s_transm"],0,20);				// Secuencia de Transmisi�n "Secuencia � folio que identifica transacci�n para MUNICIPIO DE GUADALUPE. �nico e irrepetible" numeric de 20
// 	$wreferencua = $_POST["c_referencia"];  					// Referencia "Referencia �nica e irrepetible por proceso de pago" char de 20 "EXPEDIENTE"
// 	$wval_1		 = $_POST["val_1"];  							// Nivel 1 De Detalle
// 	$wservicio   = $_POST["t_servicio"];	   					// Tipo de Servicio "POR DEFINIR" num de 3 --002 predial--
// 	$wimporte    = $_POST["t_importe"];	               			// Importe Total "9 enteros 2 decimales con punto" num 9,2
// 	$val_3		 = $_POST["val_3"];  							// Moneda
// 	$t_pago		 = $_POST["t_pago"];  							// Tipo de Pago
// 	$noperacion  = $_POST["n_autoriz"];							// Numero de operacion bancaria	 // GARM 20220811 no debe ser null vacio o en cero 		
// 	$val_9		 = $_POST["val_9"];  							// N�mero de Tarjeta
// 	$val_10		 = $_POST["val_10"];  							// Fecha de Pago
// 	$val_5		 = $_POST["val_5"];  							// Financiamiento// garm 20220811  1 no aplica  2 aplica meses en   solo en BBVA TARJETAHABIENTES FINANCIAMIENTO 
// 	$val_6		 = $_POST["val_6"];  							// Periodo de Financiamiento
// 	$val_11		 = $_POST["val_11"];  							// E-Mail
// 	$val_12		 = $_POST["val_12"];  							// Tel�fono
	
// 	$numtc       = 'XXXXXXXXXX'.substr($_POST["val_9"],0,4);	// Numero de tarjeta 	
// 	$Expe		 = $_POST["c_referencia"]; 
	
// 	if (trim($Expe)  != "01001065" || trim($Expe)  != "01001066" || trim($Expe)  != "01001067" ) { // el val_13 no viene en el formato nuevo  este if hay que comentarlo cuando ya este en produccion 
// 		$val_13		 = @$_POST["val_13"];  							// HMAC SHA-1
// 	} < garm 20220825 
// 		garm20220726


    if(isset($_POST["s_transm"])){

    $wsecuencia  =  substr($_POST["s_transm"],0,20);	// ok 

}else{

    $wsecuencia = "0";

}
// Referencia "Referencia única e irrepetible por proceso de pago" char de 20 "EXPEDIENTE"
 if(isset($_POST['c_referencia'])){

    $wreferencua  = $_POST["c_referencia"];  
    $Expe		 = $_POST["c_referencia"]; 	

}else{

    $wreferencua = "";
	$Expe        = "0";

}

// Tipo de Servicio "POR DEFINIR" num de 3 --002 predial--

if(isset($_POST['t_servicio'])){

    $wservicio  = $_POST["t_servicio"];	

}else{

    $wservicio = 0;

}
// Importe Total "9 enteros 2 decimales con punto" num 9,2
if(isset($_POST['t_importe'])){

    $wimporte  =  $_POST["t_importe"];	

}else{

    $wimporte = 0;

}
// Tipo de Pago
if(isset($_POST['t_pago'])){

    $t_pago  =  $_POST["t_pago"];	

}else{

    $t_pago = 0;

}
// Nivel 1 De Detalle
if(isset($_POST['val_1'])){

    $wval_1  =  $_POST["val_1"];	

}else{

    $wval_1 = 0;

}
// Moneda
if(isset($_POST['val_3'])){

    $val_3  =  $_POST["val_3"];	

}else{

   $val_3 = 0;

}
// Financiamiento// garm 20220811  1 no aplica  2 aplica meses en   solo en BBVA TARJETAHABIENTES FINANCIAMIENTO 
if(isset($_POST['val_5'])){

    $val_5  =  $_POST["val_5"];	

}else{

    $val_5 = 0;

}
// Periodo de Financiamiento
if(isset($_POST['val_6'])){

    $val_6  =  $_POST["val_6"];	

}else{

    $val_6 = "";

}

// Número de Tarjeta
if(isset($_POST['val_9'])){

    $val_9  =  $_POST["val_9"];
    $numtc       = ('XXXXXXXXXX'. substr($_POST["val_9"],0,4));  // OK	

}else{

    $val_9 = 0;

}
// Fecha de Pago
if(isset($_POST['val_10'])){

    $val_10  =  $_POST["val_10"];
  

}else{

    $val_10 = "";

}
// E-Mail
if(isset($_POST['val_11'])){

    $val_11  =  $_POST["val_11"];	

}else{

    $val_11 = "0";

}
// Teléfono
if(isset($_POST['val_12'])){

    $val_12  =  $_POST["val_12"];	

}else{

    $val_12 = "0";

}
// HMAC SHA-1
if(isset($_POST['val_13'])){

    $val_13  =  $_POST["val_13"];	

}else{

    $val_13 = "0";

}


// Numero de operacion bancaria	 // GARM 20220811 no debe ser null vacio o en cero 20230309
if(isset($_POST['n_autoriz'])){

    $noperacion  =  $_POST["n_autoriz"];

     //if( is_null($noperacion ))
	// {
	   //$Expe = "0";
	//	 $wreferencua = "";
	// }
      	

}else{

    $noperacion = "0";
	 $Expe  = "0";

}

	
	//if (trim($Expe)  != "01010067" || trim($Expe)  != "01001066" || trim($Expe)  != "01001067" ) { // el val_13 no viene en el formato nuevo  este if hay que comentarlo cuando ya este en produccion 
	//if (trim($Expe)  == "01079013" ) { // el val_13 no viene en el formato nuevo  este if hay que comentarlo cuando ya este en produccion 
	//	$val_13		 = @$_POST["val_13"];  							// HMAC SHA-1
	//}

	
	//       s_transm  $cuenta->comorder_id
   //        +
  //         c_referencia $info->exp
 //          +
 //          t_importe  $rowAdeudo['totalAdeudo']
 //          + RETORNO
 //          y en el retorno se añade el parámetro 
 //          n_autoriz 

$secretKey = '-=D-#2$b2Gl=Rx6$0m55w(IisyxObRI+Yz8#6vje(cI3b2m$!ya7mQn19S9JX78tL#2Q&V%B7cmQKjZC83e(+4#pw41$1S%+4#f+#5X9S5=54XlUU(O%-G01yPTA!s-%';

 // garm 20230308


$hs_transm = substr($_POST["s_transm"],0,20);
$hc_referencia = $_POST["c_referencia"];   
$h_totalAdeudo = $_POST["t_importe"];
$hn_autoriz = $_POST["n_autoriz"];      

$t_importe = number_format($h_totalAdeudo, 2);

$st_importe = str_replace(",", '', $t_importe);

$requestDataStringR= $hs_transm . $hc_referencia  . $st_importe;

$requestDataString = $hs_transm . $hc_referencia  . $st_importe . $hn_autoriz;


// Calcular el código HMAC
$hmac = hash_hmac("sha256", $requestDataString, $secretKey);
$hmacadquira = $_POST["mp_signature"];

$hmac = substr($hmac,0,20); // solo para prueba 20230312

//if ($hmac != $hmacadquira && (trim($Expe)  != "01010067" || trim($Expe)  != "01001066" || trim($Expe)  != "01001067" ))
//{
//	$noperacion = "0";
//	$wreferencua = "";
//}

  
$val_13 = "0";   //garm 20230228

	// $sqlIns.= "'".$Expe."',";
	// $sqlIns.= "'".$wsecuencia."',";
	// $sqlIns.= "'".$wreferencua."',";
	// $sqlIns.= "'".$wval_1."',";
	// $sqlIns.= "'".$wservicio."',";
	// $sqlIns.= "'".$wimporte."',";
	// $sqlIns.= "'".$val_3."',";
	// $sqlIns.= "'".$t_pago."',";	
	// $sqlIns.= "'".$noperacion."',";
	// $sqlIns.= "'".$val_9."',";
	// $sqlIns.= "'".$val_10."',";
	// $sqlIns.= "'".$val_5."',";
	// $sqlIns.= "'".$val_6."',";
	// $sqlIns.= "'".$val_11."',";
	// $sqlIns.= "'".$val_12."',";	
	// $sqlIns.= "getdate())";	
	//$sqlIns.= "'".$val_13."')";	
