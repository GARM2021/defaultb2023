<?php 


// Variables
	
	

    //!<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
    
   // Cuantos Expedientes
	//$query = "SELECT     fpago, COUNT(DISTINCT exp) AS cexp FROM         preddpagos GROUP BY fpago HAVING      (fpago = (convert(varchar, getdate(), 112))) ";
	$query = "SELECT     fpago, COUNT(DISTINCT exp) AS cexp FROM         preddpagos where (estatus <=0) and  (NOT (caja IN ('0805', '0811', '0806', '0705')))  GROUP BY fpago HAVING      (fpago = (convert(varchar, getdate(), 112))) ";
		$result = mssql_query($query);


   //////////////////////////////////////20230126 /////////////////////////////////////////////////////		
		
		$row_cnt1 =  mssql_num_rows($result);
		 
		 $cu1 = 0;
   if($row_cnt1> 0)
			{
				while ($row = @mssql_fetch_assoc($result)){// original 
					$cu1 = $row['cexp'] ;// original
					 
			}  
			}	
		//! 
		
		
	//////////////////////////////////////20230126 /////////////////////////////////////////////////////			
		
			
   // Cuanto Dinero
   
   //$query = "SELECT     fpago AS fecha, SUM(montoimp) AS m, SUM(bonif) AS b, SUM(recargos) AS r, SUM(bonrec) AS br, SUM(subsidio) AS s FROM preddpagos GROUP BY fpago HAVING      (fpago = (convert(varchar, getdate(), 112))) ";
    $query = "SELECT     fpago AS fecha, SUM(montoimp) AS m, SUM(bonif) AS b, SUM(recargos) AS r, SUM(bonrec) AS br, SUM(subsidio) AS s FROM preddpagos where (estatus <=0) and  (NOT (caja IN ('0805', '0806', '0811', '0705'))) GROUP BY fpago HAVING      (fpago = (convert(varchar, getdate(), 112))) ";
   
		$result = mssql_query($query); 
			while ($row = @mssql_fetch_assoc($result)){
					$bmonto = $row['m'] ;
					$bbonif = $row['b'] ;
					$brecargos = $row['r'] ;
					$bbonrec = $row['br'] ;
					$bsubsidio = $row['s'] ;
	}
	
	$neto1 = $bmonto - $bbonif + $brecargos - $bbonrec - $bsubsidio;
	
	//echo  $bmonto . " <br>" . $bbonif . " <br>" . $brecargos . " <br>" . $bbonrec . " <br>" . $bsubsidio . " <br>" ;
	
 // Pantalla
 //echo " Consulta de Cobro Predial " .trim(date("Y")). " <br>";
 //echo "  Hoy: " . $hoy . " <br>";
	//echo " " . $hoy . " <br>";
	
	//echo '<br> Expedientes = ' . number_format($cu1,0) . '<br> ';
	//echo '<br> Ingreso Neto = $ ' . number_format($neto1,2) . '<br> ';
	
	
	// Acomulado Mensual
	 // Datos Cuantos Expedientes Totales
		
		   $query = "SELECT     COUNT(DISTINCT exp) AS cuantos, ctafolio FROM         preddpagos WHERE  (estatus <=0) and (fpago > '20230100') and  (NOT (caja IN ('0805', '0806', '0811',  '0705')))  GROUP BY ctafolio ";
           
			$result = mssql_query($query); 
			while ($row = @mssql_fetch_assoc($result)){
					$cu2 = $row['cuantos'] ;
					 
			}  
   // Cuanto Dinero
   
   $query = "SELECT     SUM(montoimp) AS m, SUM(bonif) AS b, SUM(recargos) AS r, SUM(bonrec) AS br, SUM(subsidio) AS s FROM         preddpagos WHERE  (estatus <=0) and  (fpago > '20230100') and  (NOT (caja IN ('0805', '0806', '0811',  '0705'))) ";
   
		$result = mssql_query($query); 
			while ($row = @mssql_fetch_assoc($result)){
					$bmonto = $row['m'] ;
					$bbonif = $row['b'] ;
					$brecargos = $row['r'] ;
					$bbonrec = $row['br'] ;
					$bsubsidio = $row['s'] ;
	}
	
	$neto2 = $bmonto - $bbonif + $brecargos - $bbonrec - $bsubsidio;
	
	//echo  $bmonto . " <br>" . $bbonif . " <br>" . $brecargos . " <br>" . $bbonrec . " <br>" . $bsubsidio . " <br>" ;
	
 // Pantalla
 
 //echo " <br><br> Total Mensual Acumulado  <br>";
	

	//echo '<br> En Expedientes = ' . number_format($cu2,0) . '<br> ';
	//echo '<br> En Ingreso Neto = $ ' . number_format($neto2,2) . '<br> ';
	
	// Fin Mensual
	
	
	// Acomulado 
	 // Datos Cuantos Expedientes Totales
		
		   $query = "SELECT     COUNT(DISTINCT exp) AS cuantos, ctafolio FROM         preddpagos WHERE   (estatus <=0) and  (fpago > '20230100')  GROUP BY ctafolio ";

			$result = mssql_query($query); 
			while ($row = @mssql_fetch_assoc($result)){
					$cu = $row['cuantos'] ;
					 
			}  
   // Cuanto Dinero
   
   $query = "SELECT     SUM(montoimp) AS m, SUM(bonif) AS b, SUM(recargos) AS r, SUM(bonrec) AS br, SUM(subsidio) AS s FROM         preddpagos WHERE  (estatus <=0) and (fpago > '20230100')";
   
		$result = mssql_query($query); 
			while ($row = @mssql_fetch_assoc($result)){
					$bmonto = $row['m'] ;
					$bbonif = $row['b'] ;
					$brecargos = $row['r'] ;
					$bbonrec = $row['br'] ;
					$bsubsidio = $row['s'] ;
	}
	
	$neto = $bmonto - $bbonif + $brecargos - $bbonrec - $bsubsidio;
	
	
	// Acomulado en linea
	 // Datos Cuantos Expedientes Totales
		
		   $query = "SELECT     COUNT(DISTINCT exp) AS cuantos, ctafolio FROM         preddpagos WHERE   (estatus <=0) and  (fpago > '20230100') and ( (caja IN ('0805', '0806', '0811',  '0705')))GROUP BY ctafolio ";

			$result = mssql_query($query); 
			while ($row = @mssql_fetch_assoc($result)){
					$cu3 = $row['cuantos'] ;
					 
			}  
   // Cuanto Dinero en linea
   
   $query = "SELECT     SUM(montoimp) AS m, SUM(bonif) AS b, SUM(recargos) AS r, SUM(bonrec) AS br, SUM(subsidio) AS s FROM         preddpagos WHERE  (estatus <=0) and (fpago > '20230100') and ( (caja IN ('0805', '0806', '0811', '0705')))";
   
		$result = mssql_query($query); 
			while ($row = @mssql_fetch_assoc($result)){
					$bmonto = $row['m'] ;
					$bbonif = $row['b'] ;
					$brecargos = $row['r'] ;
					$bbonrec = $row['br'] ;
					$bsubsidio = $row['s'] ;
	}
	
	$neto3 = $bmonto - $bbonif + $brecargos - $bbonrec - $bsubsidio;
	
	
	//HDT Acomulado en linea hoy
	 // Datos Cuantos Expedientes hoy
		
		   $query = "SELECT     COUNT(DISTINCT exp) AS cuantos, ctafolio FROM         preddpagos WHERE   (estatus <=0) and  (fpago = (convert(varchar, getdate(), 112))) and ( (caja IN ('0805', '0806', '0811',  '0705'))) GROUP BY ctafolio ";

				$result = mssql_query($query);
			
			$cuHoyLinea = 0 ; //20220426 garm
			
			if (mssql_num_rows($result) > 0) { //20220426 garm
    
			while ($row = @mssql_fetch_assoc($result)){
					$cuHoyLinea = $row['cuantos'] ;
					 
			}  
			}
			
   // Cuanto Dinero en linea
   
   $query = "SELECT     SUM(montoimp) AS m, SUM(bonif) AS b, SUM(recargos) AS r, SUM(bonrec) AS br, SUM(subsidio) AS s FROM         preddpagos WHERE  (estatus <=0) and (fpago = (convert(varchar, getdate(), 112))) and ( (caja IN ('0805', '0806', '0811',  '0705')))";
   
		$result = mssql_query($query); 
			while ($row = @mssql_fetch_assoc($result)){
					$bmonto = $row['m'] ;
					$bbonif = $row['b'] ;
					$brecargos = $row['r'] ;
					$bbonrec = $row['br'] ;
					$bsubsidio = $row['s'] ;
	}
	
	$netoHoyLinea = $bmonto - $bbonif + $brecargos - $bbonrec - $bsubsidio;
	
	//echo  $bmonto . " <br>" . $bbonif . " <br>" . $brecargos . " <br>" . $bbonrec . " <br>" . $bsubsidio . " <br>" ;
	
 // Pantalla
 
 //echo " <br><br> Total Anual Acumulado  <br>";
	

	//echo '<br> En Expedientes = ' . number_format($cu,0) . '<br> ';
	//echo '<br> En Ingreso Neto = $ ' . number_format($neto,2) . '<br> ';
	
		require("i1.html");
		
		
		
	
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Municipio de Guadalupe</title>
	<link href="paynet/pago.css" rel="stylesheet" type="text/css">
</head>

<body >
	<!--<body>-->

		<div class="whitepaper">
			<div class="Header">
				<div class="Logo_empresa">
					<img src="https://www.guadalupe.gob.mx/wp-content/uploads/2021/09/Escudo-2021-2024_350x182.png" alt="Logo">
					<!-- paynet/logogpe.png -->
				</div>
				<div class="Table-Data">
					<div>Cobrado el d&iacute;a de hoy <?php echo($hoy) ?></div>	
					<div class="table-row color1">
						<div>Expedientes</div>
						<span><?php echo   number_format($cu1,0)    ?></span>
					</div>
					<div class="table-row color1">
						<div>Ingreso Neto</div>
						<span>$<?php echo   number_format($neto1,2)   ?></span>
					</div>
					<div>Total Mensual Acumulado en Cajas</div>	
					<div class="table-row color2">
						<div>Expedientes</div>
						<span><?php echo   number_format($cu2,0)   ?></span>
					</div>
					<div class="table-row color2">
						<div>Ingreso Neto</div>
						<span>$<?php echo   number_format($neto2,2)   ?></span>
					</div>
					<div>Cobrado Hoy en L&iacute;nea</div>	
						<div class="table-row color1">
							<div>Expedientes</div>
							<span><?php echo   number_format($cuHoyLinea,0)   ?></span>
					</div>
						<div class="table-row color1">
						<div>Ingreso Neto en L&iacute;nea Hoy</div>
						<span>$<?php echo   number_format($netoHoyLinea,2)   ?></span>
					</div>
					
					
					<div>Total Acumulado en L&iacute;nea</div>	
						<div class="table-row color1">
							<div>Expedientes</div>
							<span><?php echo   number_format($cu3,0)   ?></span>
					</div>
						<div class="table-row color1">
						<div>Ingreso Neto en L&iacute;nea</div>
						<span>$<?php echo   number_format($neto3,2)   ?></span>
					</div>
					<p>&nbsp;</p>
					<div><strong>Total Anual Acumulado</strong></div>	
						<div class="table-row color1">
							<div>Expedientes</div>
							<span><?php echo   number_format($cu,0)   ?></span>
					</div>
						<div class="table-row color1">
						<div>Ingreso Neto</div>
						<span><strong>$<?php echo   number_format($neto,2)   ?></strong></span>
					</div>
				
				
				
				
				
				
				
				
				
				
				
				
	