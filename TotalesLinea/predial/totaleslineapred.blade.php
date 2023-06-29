<html> 
	<meta content="60" http-equiv="REFRESH"> </meta>
	<head> 

		<title> Consulta Predial</title> 
		{{-- <link type="image/x-icon" href="ico.ico" rel="icon" /> 
		<link type="image/x-icon" href="ico.ico" rel="shortcut icon" />  --}}
		<link href="/pago.css" rel="stylesheet" type="text/css">
	</head> 


	<body> 

		<body >
	

		<div class="whitepaper">
			<div class="Header">
				<div class="Logo_empresa">
					{{-- <img src="http://www.guadalupe.gob.mx/wp-content/uploads/2021/09/Escudo-2021-2024_350x182.png" alt="Logo"> --}}
					<img src="http://webguadalupe.s3.amazonaws.com/wp-content/uploads/2023/06/Escudo-2021-2024_350x182.png" alt="Logo">

					
				</div>	
			</div>
				<div class="Table-Data">
					<div>Cobrado el d&iacute;a de hoy {{($resultados['hoy'])}}</div>	
					<div class="table-row color1">
						<div>Expedientes</div>
						<span> {{ number_format($resultados['cu1'],0) }}</span>
					</div>
					<div class="table-row color1">
						<div>Ingreso Neto</div>
						<span> {{ number_format($resultados['neto1'],2) }}</span>
					</div>
					<div>Total Mensual Acumulado en Cajas</div>	
					<div class="table-row color2">
						<div>Expedientes</div>
						<span> {{ number_format($resultados['cu2'],0) }}</span>
					</div>
					<div class="table-row color2">
						<div>Ingreso Neto</div>
						<span> {{ number_format($resultados['neto2'],2)}}</span>
					</div>
					<div>Cobrado Hoy en L&iacute;nea</div>	
						<div class="table-row color1">
							<div>Expedientes</div>
							<span> {{ number_format($resultados['cuHoyLinea'],0) }}</span>
					</div>
						<div class="table-row color1">
						<div>Ingreso Neto en L&iacute;nea Hoy</div>
						<span> {{ number_format($resultados['netoHoyLinea'],2)}}</span>
					</div>
					
					
					<div>Total Acumulado en L&iacute;nea</div>	
						<div class="table-row color1">
							<div>Expedientes</div>
							<span> {{ number_format($resultados['cu3'],0) }}</span>
					</div>
						<div class="table-row color1">
						<div>Ingreso Neto en L&iacute;nea</div>
						<span> {{ number_format($resultados['neto3'],2)}}</span>
					</div>
					<p>&nbsp;</p>
					<div><strong>Total Anual Acumulado</strong></div>	
						<div class="table-row color1">
							<div>Expedientes</div>
							<span> {{ number_format($resultados['cu'],0)   }}</span>
					</div>
						<div class="table-row color1">
						<div>Ingreso Neto</div>
						<span><strong> {{ number_format($resultados['neto'], 2) }}</strong></span>
					</div>

				</div>




	


</body> 
</html>