<html> 
	<meta content="60" http-equiv="REFRESH"> </meta>
	<head> 

		<title> Consulta Predial</title> 
		{{-- <link type="image/x-icon" href="ico.ico" rel="icon" /> 
		<link type="image/x-icon" href="ico.ico" rel="shortcut icon" />  --}}
	</head> 


	<body> 

		<body >
	

		<div class="whitepaper">
			<div class="Header">
				<div class="Logo_empresa">
					<img src="https://www.guadalupe.gob.mx/wp-content/uploads/2021/09/Escudo-2021-2024_350x182.png" alt="Logo">
					
				</div>
			</div>
				<div class="Table-Data">
					<div>Cobrado el d&iacute;a de hoy {{($resultados['hoy'])}}</div>	
					<div class="table-row color1">
						<div>Expedientes</div>
						<span>cu1 {{ number_format($resultados['cu1'],0) }}</span>
					</div>
					<div class="table-row color1">
						<div>Ingreso Neto</div>
						<span>neto1 {{ number_format($resultados['neto1'],2) }}</span>
					</div>
					<div>Total Mensual Acumulado en Cajas</div>	
					<div class="table-row color2">
						<div>Expedientes</div>
						<span>cu2 {{ number_format($resultados['cu2'],0) }}</span>
					</div>
					<div class="table-row color2">
						<div>Ingreso Neto</div>
						<span>neto2 {{ number_format($resultados['neto2'],2)}}</span>
					</div>
					<div>Cobrado Hoy en L&iacute;nea</div>	
						<div class="table-row color1">
							<div>Expedientes</div>
							<span>cuhoylinea {{ number_format($resultados['cuHoyLinea'],0) }}</span>
					</div>
						<div class="table-row color1">
						<div>Ingreso Neto en L&iacute;nea Hoy</div>
						<span>netohoylinea {{ number_format($resultados['netoHoyLinea'],2)}}</span>
					</div>
					
					
					<div>Total Acumulado en L&iacute;nea</div>	
						<div class="table-row color1">
							<div>Expedientes</div>
							<span>cu3 {{ number_format($resultados['cu3'],0) }}</span>
					</div>
						<div class="table-row color1">
						<div>Ingreso Neto en L&iacute;nea</div>
						<span>neto3 {{ number_format($resultados['neto3'],2)}}</span>
					</div>
					<p>&nbsp;</p>
					<div><strong>Total Anual Acumulado</strong></div>	
						<div class="table-row color1">
							<div>Expedientes</div>
							<span>cu {{ number_format($resultados['cu'],0)   }}</span>
					</div>
						<div class="table-row color1">
						<div>Ingreso Neto</div>
						<span><strong>neto {{ number_format($resultados['neto'], 2) }}</strong></span>
					</div>

				</div>




	


</body> 
</html>