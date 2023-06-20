<?php

//session_start(); 


//inicializo 

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;



class TotalesPredialController extends Controller
{
	function predialTotalesLinea()
	{ 

		//inicializo saldos

		date_default_timezone_set("America/Mexico_City");
		$cu = 0;
		$bmonto = 0;
		$bbonif = 0;
		$brecargos = 0;
		$bbonrec = 0;
		$bsubsidio = 0;
		$neto = 0;
		$hoy = date("F j, Y, g:i a");   
		
		 // Cuantos Expedientes

      $result = DB::connection('sqlsrv')->select("SELECT     fpago, COUNT(DISTINCT exp) AS cexp FROM         preddpagos where (estatus <=0) and  (NOT (caja IN ('0805', '0811', '0806', '0705')))  GROUP BY fpago HAVING      (fpago = (convert(varchar, getdate(), 112)))");
	  $row_cnt1 = count($result);
	  

		$cu1 = 0;
		if ($row_cnt1 > 0) {
		    foreach ($result as $row) {
		        $cu1 = $row->cexp;
			}
		}

  // Cuanto Dinero
     
  
     $result = DB::connection('sqlsrv')->select( "SELECT     fpago AS fecha, SUM(montoimp) AS m, SUM(bonif) AS b, SUM(recargos) AS r, SUM(bonrec) AS br, SUM(subsidio) AS s FROM preddpagos where (estatus <=0) and  (NOT (caja IN ('0805', '0806', '0811', '0705'))) GROUP BY fpago HAVING      (fpago = (convert(varchar, getdate(), 112))) ");

		foreach ($result as $row) {
		$bmonto = $row->m;
		$bbonif = $row->b;
		$brecargos = $row->r;
		$bbonrec = $row->br;
		$bsubsidio = $row->s;
		}

		$neto1 = $bmonto - $bbonif + $brecargos - $bbonrec - $bsubsidio;

		// Acomulado Mensual
	 // Datos Cuantos Expedientes Totales
		

	 $result = DB::connection('sqlsrv')->select( "SELECT     COUNT(DISTINCT exp) AS cuantos, ctafolio FROM         preddpagos WHERE  (estatus <=0) and (fpago > '20230600') and  (NOT (caja IN ('0805', '0806', '0811',  '0705')))  GROUP BY ctafolio ");
	 
	 $row_cnt1 = count($result);
	 
	 $cu2 = 0;
	 if ($row_cnt1 > 0) {
		 foreach ($result as $row) {
			 $cu2 = $row->cuantos;
		 }
	 }

	  // Cuanto Dinero

	  
   
	 

	  $result = DB::connection('sqlsrv')->select("SELECT     SUM(montoimp) AS m, SUM(bonif) AS b, SUM(recargos) AS r, SUM(bonrec) AS br, SUM(subsidio) AS s FROM         preddpagos WHERE  (estatus <=0) and (fpago > '20230600') and  (NOT (caja IN ('0805', '0806', '0811',  '0705')))");

	  foreach ($result as $row) {
		$bmonto = $row->m;
		$bbonif = $row->b;
		$brecargos = $row->r;
		$bbonrec = $row->br;
		$bsubsidio = $row->s;
		}

		$neto2 = $bmonto - $bbonif + $brecargos - $bbonrec - $bsubsidio;

		// Acomulado 
	 // Datos Cuantos Expedientes Totales

	 $resultcu = DB::connection('sqlsrv')->select("SELECT     COUNT(DISTINCT exp) AS cuantos, ctafolio FROM         preddpagos WHERE   (estatus <=0) and  (fpago > '20230100')  GROUP BY ctafolio ");

	 $row_cnt1 = count($resultcu);
	 
	 $cu = 0;
	 if ($row_cnt1 > 0) {
		 foreach ($resultcu as $row) {
			 $cu = $row->cuantos;
		 }
	 }

	 $result = DB::connection('sqlsrv')->select("SELECT     SUM(montoimp) AS m, SUM(bonif) AS b, SUM(recargos) AS r, SUM(bonrec) AS br, SUM(subsidio) AS s FROM         preddpagos WHERE  (estatus <=0) and (fpago > '20230100')");


	 foreach ($result as $row) {
		$bmonto = $row->m;
		$bbonif = $row->b;
		$brecargos = $row->r;
		$bbonrec = $row->br;
		$bsubsidio = $row->s;
		}

		$neto = $bmonto - $bbonif + $brecargos - $bbonrec - $bsubsidio;

		// Acomulado en linea
	 // Datos Cuantos Expedientes Totales

	 $result = DB::connection('sqlsrv')->select("SELECT     COUNT(DISTINCT exp) AS cuantos, ctafolio FROM         preddpagos WHERE   (estatus <=0) and  (fpago > '20230100') and ( (caja IN ('0805', '0806', '0811',  '0705')))GROUP BY ctafolio ");

	 $row_cnt1 = count($result);
	 
	 $cu3= 0;
	 if ($row_cnt1 > 0) {
		 foreach ($result as $row) {
			 $cu3 =  $row->cuantos;
		 }
	 }

	 // Cuanto Dinero en linea

	 $result = DB::connection('sqlsrv')->select("SELECT     SUM(montoimp) AS m, SUM(bonif) AS b, SUM(recargos) AS r, SUM(bonrec) AS br, SUM(subsidio) AS s FROM         preddpagos WHERE  (estatus <=0) and (fpago > '20230100') and ( (caja IN ('0805', '0806', '0811', '0705')))");

	 foreach ($result as $row) {
		$bmonto = $row->m;
		$bbonif = $row->b;
		$brecargos = $row->r;
		$bbonrec = $row->br;
		$bsubsidio = $row->s;
		}

		$neto3 = $bmonto - $bbonif + $brecargos - $bbonrec - $bsubsidio;

		//HDT Acomulado en linea hoy
	 // Datos Cuantos Expedientes hoy

	 $result = DB::connection('sqlsrv')->select("SELECT     COUNT(DISTINCT exp) AS cuantos, ctafolio FROM         preddpagos WHERE   (estatus <=0) and  (fpago = (convert(varchar, getdate(), 112))) and ( (caja IN ('0805', '0806', '0811',  '0705'))) GROUP BY ctafolio ");

	 $row_cnt1 = count($result);
	 
	 $cuHoyLinea = 0 ; //20220426 garm
	 if ($row_cnt1 > 0) {
		 foreach ($result as $row) {
			$cuHoyLinea =  $row->cuantos;
		 }
	 }

	  // Cuanto Dinero en linea

	  $result = DB::connection('sqlsrv')->select("SELECT     SUM(montoimp) AS m, SUM(bonif) AS b, SUM(recargos) AS r, SUM(bonrec) AS br, SUM(subsidio) AS s FROM         preddpagos WHERE  (estatus <=0) and (fpago = (convert(varchar, getdate(), 112))) and ( (caja IN ('0805', '0806', '0811',  '0705')))");

	  foreach ($result as $row) {
		$bmonto = $row->m;
		$bbonif = $row->b;
		$brecargos = $row->r;
		$bbonrec = $row->br;
		$bsubsidio = $row->s;
		}

		$netoHoyLinea = $bmonto - $bbonif + $brecargos - $bbonrec - $bsubsidio;

		$datos = [];


		$datos["hoy"] = $hoy;
		$datos["neto"] = $neto;
		$datos["neto1"] = $neto1;
		$datos["neto2"] = $neto2;
		$datos["neto3"] = $neto3;
		$datos["netoHoyLinea"] = $netoHoyLinea;
		$datos["cu"] = $cu;
		$datos["cu1"] = $cu1;
		$datos["cu2"] = $cu2;
		$datos["cu3"] = $cu3;
		$datos["cuHoyLinea"] = $cuHoyLinea;

	return view('totaleslineapred')->with(['resultados' => $datos]);



}
}