<?php session_start(); 


//inicializo saldos

	$WGRANTOTAL		= 0;
	$wresagobonimp	= 0;
	$wresago		= 0;
	$wgasto			= 0;
	$wgastobonimp	= 0;
	$wsancion		= 0;
	$wsancionbonimp	= 0;
	$wtotrec		= 0;
	$wtotbonrec		= 0;
	$wpredial		= 0;
	$wpredialbonimp	= 0;
	$wactualiza		= 0;
	$hoy			= trim(date("Ymd"));

	$WTOTALMIMPORTE	 = 0;
	$WTOTALsalsub	 = 0;
	$WTOTALsalimp	 = 0;
	$WTOTALpbonimp	 = 0;
	$WTOTALwrecargos = 0;
	$WTOTALbonrec	 = 0;
	$wresagorec		 = 0;
	$wresagobonrec	 = 0;
	$wresagobonimp	 = 0;
	$wpredialbonrec  = 0;
	$wpredialrec 	 = 0;
	$wdescpp 	 	 = 0;

//Desarrollado por Alejandro Alanis
//Puedes hacer lo que quieras con el código

//Configuracion de la conexion a base de datos
	
	require('conecta.php');
	require('validapost.php'); //garm20220827
	
// > garm 20220825
// DATOS RECIBIDOS POR EL BANCO.
//	$wsecuencia  = substr($_POST["s_transm"],0,20);				// Secuencia de Transmisión "Secuencia ó folio que identifica transacción para MUNICIPIO DE GUADALUPE. Único e irrepetible" numeric de 20
//	$wreferencua = $_POST["c_referencia"];  					// Referencia "Referencia única e irrepetible por proceso de pago" char de 20 "EXPEDIENTE"
//	$wval_1		 = $_POST["val_1"];  							// Nivel 1 De Detalle
//	$wservicio   = $_POST["t_servicio"];	   					// Tipo de Servicio "POR DEFINIR" num de 3 --002 predial--
//	$wimporte    = $_POST["t_importe"];	               			// Importe Total "9 enteros 2 decimales con punto" num 9,2
//	$val_3		 = $_POST["val_3"];  							// Moneda
//	$t_pago		 = $_POST["t_pago"];  							// Tipo de Pago
//	$noperacion  = $_POST["n_autoriz"];							// Numero de operacion bancaria	 // GARM 20220811 no debe ser null vacio o en cero 		
//	$val_9		 = $_POST["val_9"];  							// Número de Tarjeta
//	$val_10		 = $_POST["val_10"];  							// Fecha de Pago
//	$val_5		 = $_POST["val_5"];  							// Financiamiento// garm 20220811  1 no aplica  2 aplica meses en   solo en BBVA TARJETAHABIENTES FINANCIAMIENTO 
//	$val_6		 = $_POST["val_6"];  							// Periodo de Financiamiento
//	$val_11		 = $_POST["val_11"];  							// E-Mail
//	$val_12		 = $_POST["val_12"];  							// Teléfono
	
//	$numtc       = 'XXXXXXXXXX'.substr($_POST["val_9"],0,4);	// Numero de tarjeta 	
//	$Expe		 = $_POST["c_referencia"]; 
	
//	if (trim($Expe)  != "01001065" || trim($Expe)  != "01001066" || trim($Expe)  != "01001067" ) { // el val_13 no viene en el formato nuevo  este if hay que comentarlo cuando ya este en produccion 
//		$val_13		 = @$_POST["val_13"];  							// HMAC SHA-1
//	} < garm 20220825 
		//garm20220726

		
		if (trim($Expe)  == "22031020" || trim($Expe)  == "01001066" || trim($Expe)  == "01001067" ) {
		
//Inserta en una tabla de transacciones. predmwebTransaction toda la informacion proveeida por el banco. para ver si la aprobo o no.
	$sqlIns  ="Insert into predmwebTransactionp ([Expe],[s_transm],[referencia],[val_1_nivelDetalle],[t_servicio],[t_importe]";
    $sqlIns.= ",[val_3_moneda],[t_pago],[n_autoriz],[val_9_numtc],[val_10_fpagp],[val_5_financiamiento]";
    $sqlIns.= ",[val_6_periodoFinan],[val_11_email],[val_12_Telefono],[fecha]) ";	// garm20220810 se cancelo el campo $val_13	
	$sqlIns.= "VALUES (";          
	$sqlIns.= "'".$Expe."',";
	$sqlIns.= "'".$wsecuencia."',";
	$sqlIns.= "'".$wreferencua."',";
	$sqlIns.= "'".$wval_1."',";
	$sqlIns.= "'".$wservicio."',";
	$sqlIns.= "'".$wimporte."',";
	$sqlIns.= "'".$val_3."',";
	$sqlIns.= "'".$t_pago."',";	
	$sqlIns.= "'".$noperacion."',";
	$sqlIns.= "'".$val_9."',";
	$sqlIns.= "'".$val_10."',";
	$sqlIns.= "'".$val_5."',";
	$sqlIns.= "'".$val_6."',";
	$sqlIns.= "'".$val_11."',";
	$sqlIns.= "'".$val_12."',";	
	$sqlIns.= "getdate())";	
	//$sqlIns.= "'".$val_13."')";	
	//echo $sqlIns;
		mssql_query($sqlIns,$con);}
	
	else { //garm20220726 
	$sqlIns  ="Insert into predmwebTransaction ([Expe],[s_transm],[referencia],[val_1_nivelDetalle],[t_servicio],[t_importe]";
    $sqlIns.= ",[val_3_moneda],[t_pago],[n_autoriz],[val_9_numtc],[val_10_fpagp],[val_5_financiamiento]";
    $sqlIns.= ",[val_6_periodoFinan],[val_11_email],[val_12_Telefono],[fecha],[val_13_Sha1]) ";
	$sqlIns.= "VALUES (";          
	$sqlIns.= "'".$Expe."',";
	$sqlIns.= "'".$wsecuencia."',";
	$sqlIns.= "'".$wreferencua."',";
	$sqlIns.= "'".$wval_1."',";
	$sqlIns.= "'".$wservicio."',";
	$sqlIns.= "'".$wimporte."',";
	$sqlIns.= "'".$val_3."',";
	$sqlIns.= "'".$t_pago."',";	
	$sqlIns.= "'".$noperacion."',";
	$sqlIns.= "'".$val_9."',";
	$sqlIns.= "'".$val_10."',";
	$sqlIns.= "'".$val_5."',";//  este tiene que ser numerico 20230124
	$sqlIns.= "'".$val_6."',";
	$sqlIns.= "'".$val_11."',";
	$sqlIns.= "'".$val_12."',";	
	$sqlIns.= "getdate(),";	
	$sqlIns.= "'".$val_13."')";	
	//echo $sqlIns;
	mssql_query($sqlIns,$con);
			
	}//garm20220726 
	 
	
		
$numcaracteres=strlen(trim($wreferencua));
if ($numcaracteres>0)
{
	$wvarpaso='CONEXP';
}
ELSE
{
	$wvarpaso='SINEXP';
}

switch($wvarpaso)
{
	case "CONEXP":
		$Expe=trim($wreferencua);  		// Referencia "Referencia única e irrepetible por proceso de pago" 
		//$Expe       ='34392009';
			$Region     =trim(substr($Expe,0,2));
			$RegionManz =trim(substr($Expe,0,5));

		//DATOS CAJA Y CONCEPTO DE COBRO
		//BANCOMER PREDIAL  - 0801 CAJA CANCELADA
		//BANCOMER PREDIAL  - 0805
		//BANCOMER TRANSITO - 0802
		//BANAMEX PREDIAL   - 0803
		//BANAMEX TRANSITO  - 0804


		// OFICINAS DE PAGO
		//BANCOMER PREDIAL  - 0801
		//BANAMEX PREDIAL   - 0802

			$wcaja		= '0805';
			$wofipago	= '0801';

		//DATOS CONCEPTO DE PAGO
		//PREDIAL          - 1104
		//PREDIAL BANCOS   - 1105
		//PREDIAL INTERNET - 1106 (AUN SIN REGISTRO EN DB)

			$wconcepto		= '1105';
			$wdescconcepto	= trim('PAGO IMP. PREDIAL Exp: '.$Expe.' ');
			//$wdescconcepto1	= phpversion();

		//EXTRAE NUMERO CONSECUTIVO DE RECIBO
		
		
		 
		 /////////////////////////////////////////////////// GARM 20220322 080500076147
		 
		 //$sqlpru = "EXEC SP_NewRecOf ?" . $Exp; ejemplo con parametro GARM 20220407
		 $sqlpru = "EXEC SP_NewRecOf ";
		 $spresource = mssql_query( $sqlpru, $con); 
		 
		 $spfoliorec = "0";
		 
		 while($rowf =  mssql_fetch_array($spresource))
		{
			$spfoliorec =$rowf['sfoliorec'];
							
		}
		 
		 /////////////////////////////////////////////////
		    
			//$wdescconcepto2	= $spfoliorec." PRUEBA ";
		  
	        $wfoliorec = $spfoliorec; 
		 
		/* $sqlf= mssql_query("SELECT foliorec FROM ingresmcajas where caja=\"$wcaja\" ",$con); //GARM 20220322 CANCELADO GARM 20220215 080500075345 GARM CANCELADO 20220317 080500076109
		while($rowf =  mssql_fetch_array($sqlf))
		{
			 if ($_SESSION["wgenerarecibo"]<>'99')//para que solo lo genere 1 vez
			 {
				 $_SESSION["wfoliorecibo"]=$rowf['foliorec']+1;;
				 $wfoliorecibo=$_SESSION["wfoliorecibo"];
				 $sqlfu= mssql_query("update ingresmcajas set foliorec='$wfoliorecibo' where caja='$wcaja'",$con);
				 $_SESSION["wgenerarecibo"]='99';
			 }
			 $wfoliorec="0".$_SESSION["wfoliorecibo"];
		} */
            //  echo $_SESSION["wfoliorecibo"]; 
		
		//CUENTAS CONT DEL CONCEPTO DE PAGO
		//$sql= mssql_query("SELECT * FROM ingresmconceptos where con=\"$wconcepto\" ",$con);
		$sql= mssql_query("SELECT ctaimporte, ctarecargo, ctasancion, ctagastos, ctaotros, centro  FROM ingresmconceptos where con=\"$wconcepto\" ",$con); // GARM 20220215 080500075345
		while($rowf =  mssql_fetch_array($sql))
		{
			 $wctaimporte	= trim($rowf['ctaimporte']);
			 $wctarecargo	= trim($rowf['ctarecargo']);
			 $wctasancion	= trim($rowf['ctasancion']);
			 $wctagastos	= trim($rowf['ctagastos']);
			 $wctaotros		= trim($rowf['ctaotros']);
			 $wcentro		= trim($rowf['centro']);
		}

		/////////////////////////////////////////////////////////////////////////////////////////////////
		//INICIO CALCULA ADEUDOS
		//DATOS GENERALES DEL EXPEDIENTE
			//$sql= mssql_query("SELECT * FROM preddexped where exp=\"$Expe\" and fbaja < '00000001' order by exp",$con);
			$sql= mssql_query("SELECT apat, amat, nombre, domubi, colubi FROM preddexped where exp=\"$Expe\" and fbaja < '00000001' order by exp",$con); // GARM 20220218 080500075432
			$row_cnt =  mssql_num_rows($sql);
			if ($row_cnt==0 )
			{
				$wheader="Edopredial.php?msg=SI";	
				$redireccionar=1;
			}
			while($row =  mssql_fetch_array($sql))
			{          
				$wsnombre	 = trim($row['apat']).' '.trim($row['amat']).' '.trim($row['nombre']);
				$wsdireccion = trim($row['domubi']).', COL.'.trim($row['colubi']);
				$wsciudad	 = 'CD. GUADALUPE, NUEVO LEON';				
			}

			$WGRANTOTAL=0;
		
			
			
			//$query= "SELECT a.*,b.descripcion FROM preddadeudos a, predmtpocar b where a.exp=\"$Expe\" and";
			$query= "SELECT a.tpocar, a.yearbim, a.montoimp, a.salimp, a.salsub, a.bimsem, a.pctimpbon, a.impbon, a.fechaven, b.descripcion FROM preddadeudos a, predmtpocar b where a.exp=\"$Expe\" and"; //GARM 20220221 080500075501 20220602
			$query.= " b.tpocar COLLATE DATABASE_DEFAULT = a.tpocar COLLATE DATABASE_DEFAULT  and a.estatus < '0001' ORDER BY yearbim";
			$sql= mssql_query($query,$con);
			$row_cnt =  mssql_num_rows($sql);
			
			$descuentoAdicionalFlag = true;
			//$query222= "SELECT a.*, b.descripcion FROM preddadeudos a, predmtpocar b where a.exp=\"$Expe\" and"; //GARM 20220221 080500075506
			$query222= "SELECT a.exp, b.descripcion FROM preddadeudos a, predmtpocar b where a.exp=\"$Expe\" and"; //GARM 20220221 080500075506
			$query222.= " b.tpocar COLLATE DATABASE_DEFAULT = a.tpocar COLLATE DATABASE_DEFAULT  and a.estatus < '0001' AND impbon > 0 ORDER BY yearbim";
			$sql222 = mssql_query($query222,$con);
			$row_cnt222 =  mssql_num_rows($sql222);
			if($row_cnt222 > 0)
			{
				$descuentoAdicionalFlag = false;
			}
			
			
			
			while($row =  mssql_fetch_array($sql))
			{        
					$pbonimp	= 0;
					$bonrec		= 0;
					$tpocar		= $row['tpocar'];
					$bimsem		= $row['bimsem'];
					$wyearbim	= $row['yearbim'];	
					$wfun		= '00';	
					$WDIAMES 	= trim(date("j"));
					$TotalImpuestoPredial = 0;					
					
					
					/*
						$sql2= mssql_query("SELECT * FROM bondbonpred where tpocar=\"$tpocar\" and fecini<=\"$hoy\" and fecfin>=\"$hoy\" and estatus='0' ",$con);
						$row_cnt2 =  mssql_num_rows($sql2);
						while($row2 =  mssql_fetch_array($sql2))
						{
							// $paso1	  = (($row['salimp']-$row['salsub'])*($row2['pctbonimp'] + 3))/100;  // se adiciono el 3 %  de bondbonpred //20210531 se modifico 3 por 0
							 $paso1	  = (($row['salimp']-$row['salsub'])*($row2['pctbonimp'] + 0))/100;  // 20210531 se modifico 3 por 0
							 $paso2	  = $paso1*10;
							 $paso3	  = (int)($paso2);              
							 $pbonimp = $paso3/10;     /// este es automatico  27 %
							 $wfun	  = $row2['funautbon'];         
						}

						if(@$row['impbon'] > 0)  //De preddadeudos 
						{
							//$pbonimp = @$row['impbon'] * .8;  ///   esta es la bandera 17 %  mas el 3 % adicional pago en linea??
							// corregida 20210111 en borrador 
							// se modifico de 3 a 0 20211026
							// se modifico de 0 a 5 20211101
							$pbonimp = ( @$row['salimp'] - $row['salsub']) * ((@$row['pctimpbon'] + 5)/100);  

							
						}					
					*/
					
					
					//calcula las bonificaciones   
					//$sql2= mssql_query("SELECT * FROM bondbonpred where tpocar=\"$tpocar\" and fecini<=\"$hoy\" and fecfin>=\"$hoy\" and estatus='0' ",$con);
					$sql2= mssql_query("SELECT pctbonimp, funautbon FROM bondbonpred where tpocar=\"$tpocar\" and fecini<=\"$hoy\" and fecfin>=\"$hoy\" and estatus='0' ",$con); //GARM 20220222 080500075538
					$row_cnt2 =  mssql_num_rows($sql2);
					while($row2 =  mssql_fetch_array($sql2))
					{
						/* Se cambia la linea para quitar el 3% adicional de bonificacion */
						 /*$paso1	  = (($row['salimp']-$row['salsub'])*$row2['pctbonimp'])/100;*/
						/*$paso1	  = (($row['salimp']-$row['salsub']); Error modificada el 20210526*/
						// $paso1	  = (float)$row['salimp']-(float)$row['salsub']; // 20210531 se cancelo esta
						// 20210531 se activo esta 
						$paso1	  = (($row['salimp']-$row['salsub'])* $row2['pctbonimp'] ) /100; 
						// 20211130 garm se incluyo este if 
						if ($tpocar == '0002') { 
						
						    // $paso1	  = ($row['salimp']-$row['salsub'])*(($row2['pctbonimp'] + 5)/100); 

							//$paso1	  = (($row['salimp']-$row['salsub']) * ($row2['pctbonimp'] + 5)) / 100 ; // 20211202 garm se activo el formato con corchetes 20211203 tenira row en lugar de row2 20211231 se desactivo
						   $paso1	  = ($row['salimp'] * ($row2['pctbonimp']  + 5)) / 100;  //! GARM 20211226 el subsidio se aplica en la linea 312	
						} 
						
						 $paso2	  = $paso1*10;
						 $paso3	  = (int)($paso2);              
						 $pbonimp = $paso3/10;
						 $wfun	  = $row2['funautbon'];         
					}

					//if(@$row['impbon'] > 0)  // 20211130 garm if cancelado para prevenir en caso que se habiliten bonificaciones especiales 
					//{
						
						//$pbonimp = ( @$row['salimp'] - $row['salsub']) * ((@$row['pctbonimp'] + 0)/100); /* SE HBILITA + 5 BUEN FIN 2021 SOLO HABITACIONALES CALCULADOS EN PREDDADEUDOS GARM 2021/11/09 */
					//}
								
					//calcula recargos y % de recargos
					
					include('calculaRecargos.php');
					/* $wbsyb=trim($bimsem).trim($row['yearbim']);                         
					$sql_recargos= mssql_query("SELECT * FROM predmtabrec where bsyb=\"$wbsyb\" ",$con);
					$row_cnt_recargos=  mssql_num_rows($sql_recargos);
					while($row_recargos =  mssql_fetch_array($sql_recargos))
					{             
						 $wpctrec	 = trim('pctrec_'.trim(date("n")));             
						 $wprecargos = $row_recargos[$wpctrec];  
						 $paso1		 = ($row['montoimp']*$row_recargos[$wpctrec])/100; 
						 $paso2		 = $paso1*10;
						 $paso3		 = (int)($paso2);              
						 $wrecargos  = $paso3/10;	             
					}
											
					if ($row_cnt_recargos==0)                      
				   {
				   //	echo 'NO SE ENCONTRO EL BSYB  '.$wbsyb;
					$wntabla=trim($bimsem);                         
					$sql_recargos2= mssql_query("SELECT TOP 1 pctrec_12 FROM predmtabrec WHERE (SUBSTRING(bsyb, 1, 2) =\"$wntabla\") ORDER BY bsyb",$con);
					$row_cnt_recargos2=  mssql_num_rows($sql_recargos2);
					while($row_recargos2 =  mssql_fetch_array($sql_recargos2))
					{             
						 $wprecargos = $row_recargos2['pctrec_12'];  
						 $paso1		 = ($row['montoimp']*$wprecargos)/100;  
						 $paso2		 = $paso1*10;
						 $paso3		 = (int)($paso2);              
						 $wrecargos  = $paso3/10;
					}                      
				   } */
				   if ($tpocar>'0002')                      
				   {
						$wprecargos = 0;  
						$wrecargos  = 0;
				   }
																								   
					//calcula BONIFICACION DE recargos y % DE BONIFICACION de recargos
					$sql3= mssql_query("SELECT pctbonrec FROM bondbonpred where tpocar=\"$tpocar\" and fecini<=\"$hoy\" and fecfin>=\"$hoy\" and estatus='0' ",$con);
					$row_cnt3 =  mssql_num_rows($sql3);
					while($row3 =  mssql_fetch_array($sql3))
					{
						 $pbonrec = $row3['pctbonrec'];
						 $paso1   = ($wrecargos*$row3['pctbonrec']/100);
						 $paso2   = $paso1*10;
						 $paso3   = (int)($paso2);              
						 $bonrec  = $paso3/10;                           
					}
					

					//$WNETO			= ($row['salimp']+$wrecargos)-($pbonimp+$bonrec+$row['salsub']);
					$WNETO			= (round($row['salimp'],2) + round($wrecargos,2)) - (round($pbonimp,2) + round($bonrec,2) + round($row['salsub'], 2));
					$WimpNETO		= $row['salimp'];
					$WTOTALMIMPORTE	= $WTOTALMIMPORTE+$row['salimp'];
					$WTOTALsalsub	= $WTOTALsalsub+$row['salsub'];
					$WTOTALsalimp	= $WTOTALsalimp+$row['salimp'];
					$WTOTALpbonimp	= $WTOTALpbonimp+$pbonimp;
					$WTOTALwrecargos= $WTOTALwrecargos+$wrecargos;
					$WTOTALbonrec	= $WTOTALbonrec+$bonrec;
					
					
					//DESCUENTO POR PRONTO PAGO Ingresdingresos Descpp
					$wdescpp 	 = $wdescpp + $row['salsub']; //! GARM 20211226  no se movio 
					
					if (substr($row['yearbim'], 0, 4) == date("Y"))
					{
						$TotalImpuestoPredial += $WNETO;
					}
				   
				   //REZAGO
				   IF ($tpocar=='0001')
				   {
						$wresago		= $wresago+$row['salimp'];
						$wresagorec		= $wresagorec+$wrecargos;
						$wresagobonrec	= $wresagobonrec+$bonrec;
						//$wresagobonimp	= $wresagobonimp+$pbonimp+$row['salsub'];           	
						$wresagobonimp	= $wresagobonimp+$pbonimp;
				   }
				   
				   //PREDIAL
				   IF ($tpocar=='0002')
				   {
						$wpredial		= $wpredial+$row['salimp'];	
						$wpredialrec	= $wpredialrec+$wrecargos;
						$wpredialbonrec	= $wpredialbonrec+$bonrec;
						//$wpredialbonimp	= $wpredialbonimp+$pbonimp+$row['salsub'];
						$wpredialbonimp	= $wpredialbonimp+$pbonimp; //! GARM 20211226  no se movio 
				   }          
				   
				   //GASTOS
				   IF ($tpocar=='0003')
				   {
						$wgasto			= $wgasto+$row['salimp'];
						//$wgastobonimp	= $wgastobonimp+$pbonimp+$row['salsub'];
						$wgastobonimp	= $wgastobonimp+$pbonimp;
						
				   }
				   
				   //SANCIONES
				   IF ($tpocar=='0004')
				   {
						$wsancion		=	$wsancion+$row['salimp'];
					  //$wsancionbonimp =	$wsancionbonimp+$pbonimp+$row['salsub'];           
						$wsancionbonimp	=	$wsancionbonimp+$pbonimp;
				   }           
				   
				   $WGRANTOTAL=$WGRANTOTAL+$WNETO;		
				   $salsub=$row['salsub'];
				   
				     //Para enero 2020 3% adicional en pago en linea, oxxo y paynet
					
					// $sql_descuento = "SELECT * FROM predexpdesc WHERE exp = '$Expe'"; 20211110
					// $query_descuento = mssql_query($sql_descuento, $con); 20211110
					// $descuento = 0; 20211110
					//$descuentoBonLinea = 13;  se cancelo el 20210603 de 13 a 0
					//$descuentoBonLinea = 0;   se cancelo el 20210623 de 0  a 5
					//$descuentoBonLinea = 0;   se cancelo el 20211026 de 5   a 0
					//$descuentoBonLinea = 5;   se ACTIVO el 20211101  de 0   a 5
					$descuentoBonLinea = 5;
					$descuentoAdicionalFlag = false;  // 20211110  Active en Buen Fin. 20211202 desactive GARM 
					//if (mssql_num_rows($query_descuento) > 0 && $descuentoAdicionalFlag) 20211110
					if  ($descuentoAdicionalFlag)  // 20211110  aqui me faltaba el abrir parentisis
					{
						$descuento = $TotalImpuestoPredial * ($descuentoBonLinea/100); 
						$pbonimp += $descuento;
						$wpredialbonimp += $descuento;
					}
					
				   
				   

		//$sqlrevpag= mssql_query("SELECT * FROM preddpagos where exp=\"$Expe\" and yearbim=\"$wyearbim\" and fpago=\"$hoy\" and estatus='0000' and tpocar=\"$tpocar\" ",$con); // garm 20220204 09:43 anterior
		  $sqlrevpag= mssql_query("SELECT exp FROM preddpagos where exp=\"$Expe\" and yearbim=\"$wyearbim\" and fpago > '01' and estatus='0000' and tpocar=\"$tpocar\" ",$con); // garm 20220204 09:43 no se generar con importe = cero
		
				
		
		$reccount_revpag =  mssql_num_rows($sqlrevpag);		             
		if ($reccount_revpag==0)
		{  							
			  // <!-- INSERT DEL PAGO preddpagos-->   
		
             
			  
			//  $sqlIns = "INSERT INTO preddpagos (";
			//  $sqlIns.= "exp,"; 
			//  $sqlIns.= "ctafolio,"; 
			//  $sqlIns.= "cuenta,"; 
			//  $sqlIns.= "yearbim,"; 
			//  $sqlIns.= "montoimp,"; 
			//  $sqlIns.= "bonif,"; 
			//  $sqlIns.= "recargos,"; 
			//  $sqlIns.= "bonrec,"; 
			//  $sqlIns.= "tpocar,"; 
			//  $sqlIns.= "caja,"; 
			//  $sqlIns.= "recibo,"; 
			//  $sqlIns.= "estatus,"; 
			//  $sqlIns.= "fun,"; 
			//  $sqlIns.= "fpago,"; 
		   //  $sqlIns.= "ofipago,"; 
			//  $sqlIns.= "region,"; 
			//  $sqlIns.= "regman,"; 
			//  $sqlIns.= "subsidio,"; 
			//  $sqlIns.= "fcancont,"; 
			//  $sqlIns.= "numunico,"; 
			//  $sqlIns.= "indiceini,"; 
			//  $sqlIns.= "indicefin,"; 
			//  $sqlIns.= "yearindini,";
			//  $sqlIns.= "refban,"; 
			//  $sqlIns.= "yearindfin)"; 
			
			// GARM 20220209 080500075244 INSERT COMPACTADO 
			
			$sqlIns = "INSERT INTO preddpagos ( exp,  ctafolio,  cuenta,  yearbim,  montoimp,  bonif,  recargos,  bonrec,  tpocar,  caja, recibo, estatus, fun, fpago, ofipago,  region,  regman,  subsidio,  fcancont,  numunico,  indiceini,  indicefin,  yearindini, refban,  yearindfin) ";  
			  
			  $sqlIns.= "VALUES (";          
			  $sqlIns.= "'".$Expe."',"; 
			  $sqlIns.= "'".'00000000000000'."',";
			  $sqlIns.= "'".'00000000'."',"; 
			  $sqlIns.= "'".$wyearbim."',"; 
			  $sqlIns.= "$WimpNETO,"; 
			  $sqlIns.= "$pbonimp,"; 
			  $sqlIns.= "$wrecargos,"; 
			  $sqlIns.= "$bonrec,"; 
			  $sqlIns.= "'".$tpocar."',"; 
			  $sqlIns.= "'".$wcaja."',"; 
			  $sqlIns.= "'".$wfoliorec."',"; 
			  $sqlIns.= "'".'0000'."',"; 
			  $sqlIns.= "'".$wfun."',"; 
			  $sqlIns.= "'".$hoy."',"; 
			  $sqlIns.= "'".$wofipago."',"; 
			  $sqlIns.= "'".$Region."',"; 
			  $sqlIns.= "'".$RegionManz."',"; 
			  $sqlIns.= "$salsub,"; 
			  $sqlIns.= "' ',"; 
			  $sqlIns.= "0,"; 
			  $sqlIns.= "0,"; 
			  $sqlIns.= "0,"; 
			  $sqlIns.= "' ',"; 
			  $sqlIns.= "'".$noperacion."',";       
			  $sqlIns.= "' ')"; 
									  
			  mssql_query($sqlIns,$con);
			  
			  $sqlupdate= "update preddadeudos set salimp=0, salsub=0 where exp='$Expe' and yearbim='$wyearbim' and estatus='0000'"; // GARM 20220109 se incluyo salsub=0 
			  mssql_query($sqlupdate,$con);
			  
		   }                      
			  // <!-- FIN INSERT DEL PAGO preddpagos-->                            
		}      //20211202 garm se perdio este cerrar lo inclui de nuevo ???
					
		$wtotrec=$wresagorec+$wpredialrec;
		$wtotbonrec=$wresagobonrec+$wpredialbonrec;	
										  
		//FIN CALCULA ADEUDOS
		/////////////////////////////////////////////////////////////////////////////////////////////////
		
		//$sqlrevpagingres= mssql_query("SELECT * FROM ingresdingresos where referencia=\"$Expe\" and fecha=\"$hoy\" ",$con);	
        $sqlrevpagingres= mssql_query("SELECT recibo FROM ingresdingresos where referencia=\"$Expe\" and fecha=\"$hoy\" ",$con);	//GARM 2022022022 080500075538		
	
		$reccount_revpagINGRES =  mssql_num_rows($sqlrevpagingres);	
		
		// garm 20220204 10:43 anterior 080500074940 evita generar recibos con importe = cero 
		if ($reccount_revpag > 0 )
		{
			$reccount_revpagINGRES = 1;
		}
		
		if ($reccount_revpagINGRES==0)
		{
				// <!-- INSERT DEL PAGO indreddingresos-->
				$sql = "INSERT INTO ingresdingresos (";
				$sql.= "fecha,"; 
				$sql.= "recibo,"; 
				$sql.= "caja,"; 
				$sql.= "nombre,"; 
				$sql.= "direccion,"; 
				$sql.= "ciudad,"; 
				$sql.= "concepto_1,"; 
				$sql.= "concepto_2,"; 
				$sql.= "concepto_3,"; 
				$sql.= "concepto_4,"; 
				$sql.= "ctaimporte,"; 
				$sql.= "importe,"; 
				$sql.= "bonimporte,"; 
				$sql.= "ctarecargo,"; 
				$sql.= "recargos,"; 
				$sql.= "bonrecargo,"; 
				$sql.= "ctasancion,"; 
				$sql.= "sanciones,"; 
				$sql.= "bonsancion,"; 
				$sql.= "ctagastos,"; 
				$sql.= "gastos,"; 
				$sql.= "bongastos,"; 
				$sql.= "ctaotros,"; 
				$sql.= "otros,"; 
				$sql.= "bonotros,"; 
				$sql.= "fun,"; 
				$sql.= "estatusmov,"; 
				$sql.= "tipo,"; 
				$sql.= "centro,"; 
				$sql.= "referencia,"; 
				$sql.= "descpp,"; 
				$sql.= "con,"; 
				$sql.= "numtc,";
				$sql.= "refban,"; 
				$sql.= "imptc)"; 
				 
				$sql.= "VALUES (";
				
				$sql.= "'".$hoy."',"; 
				$sql.= "'".$wfoliorec."',"; 
				$sql.= "'".$wcaja."',"; 
				$sql.= "'".$wsnombre."',"; 
				$sql.= "'".$wsdireccion."',"; 
				$sql.= "'".$wsciudad."',"; 
				$sql.= "'".$wdescconcepto."',"; 
				$sql.= "'',"; 
				//$sql.= "'".$requestDataStringR."',"; //20230312 solo para prueba  $requestDataStringR $hn_autoriz
				//$sql.= "'".$hn_autoriz."',"; //20230312 solo para prueba  $requestDataStringR
				//$sql.= "'".$hmac."',"; //20230312 solo para prueba  $requestDataStringR
				$sql.= "'',"; 
				$sql.= "'',"; 
				$sql.= "'".$wctaimporte."',"; 
				$sql.= "$wpredial,"; 
				$sql.= "$wpredialbonimp,"; 
				$sql.= "'".$wctarecargo."',"; 
				$sql.= "$wtotrec,"; 
				$sql.= "$wtotbonrec,"; 
				$sql.= "'".$wctasancion."',"; 
				$sql.= "$wsancion,"; 
				$sql.= "$wsancionbonimp,"; 
				$sql.= "'".$wctagastos."',"; 
				$sql.= "$wgasto,"; 
				$sql.= "$wgastobonimp,"; 
				$sql.= "'".$wctaotros."',"; 
				$sql.= "$wresago,"; 
				$sql.= "$wresagobonimp,"; 
				$sql.= "'".$wfun."',"; 
				$sql.= "'".'00'."',"; 
				$sql.= "'".'PR'."',"; 
				$sql.= "'".$wcentro."',"; 
				$sql.= "'".$Expe."',"; 
				$sql.= "$wdescpp,"; //! GARM 20211226 se queda igual guarda el subsidio 
				$sql.= "'".$wconcepto."',"; 
				$sql.= "'".$numtc."',"; 
				$sql.= "'".$noperacion."',";
				$sql.= "$wimporte)";
				
				//echo $sql;
				
				mssql_query($sql,$con)or die(mysql_error());
				
				//ACTUALIZA INGRESMCENTROS
				$sqlf= mssql_query("SELECT * FROM ingresmcentros  where centro=\"$wcentro\" ",$con);
				while($rowf =  mssql_fetch_array($sqlf))
				{
					 $wsumingreso		 = trim('ingreso_'.trim(date("n")));             
					 $wprecargos		 = $rowf[$wsumingreso]+$WGRANTOTAL;
					 $wprecargos13		 = $rowf['ingreso_13']+$WGRANTOTAL;
					 $sqlfupdatemcentros = "update ingresmcentros set $wsumingreso=$wprecargos,ingreso_13=$wprecargos13 where centro='$wcentro'";
					 
					 mssql_query($sqlfupdatemcentros,$con); 
				}



				//INSERTAR EN PREDDEXPCONT LOS EXPEDIENTES CON DERECHO A SEGURO

				//1-se trae los tipos de construccion marcados como habitacionales campo (HABITA)
				//$sqlf= mssql_query("select * from predmtpoconst where habita = 1");
				//while($rowf =  mssql_fetch_array($sqlf))

				//2-revisa tipos de construccion que tiene el expediente
				//$sqlf= mssql_query("select * from preddtpoconst where exp=\"$Expe\");
				//while($rowf =  mssql_fetch_array($sqlf))

				//3-verifica cuantos exp tiene la tabla preddexpcont para que no pase de 20,000 que sea saldo=0 y que area de construccion sea mayor a 20 mts.

                                //$sqlf= mssql_query("select count(*) as tot from preddexpcont");
				//while($rowf =  mssql_fetch_array($sqlf))

				// si el expediente tiene tipo de construccion 

//if wsalimp = 0 and sqcuantos.tot < 20000 and sqdexped.areaconst >= 20
  //select * from dtpoconsexp where tpoconst not in (select tpoconst from mtpoconst) into cursor nohay
//si esta dtpoconsexp pero no esta en mtpcost
  //select nohay
//*** si el cursor NOHAY tiene registros es que no se debe otorgar la poliza
  //if reccount() > 0 
   //wleyenda =.f.
    //else
//*** si el cursor no tiene registros si se otorga la poliza y se inserta en la tabla para ir contando
  // wleyenda =.t.
    //se=sqle(co,"insert into preddexpcont (exp) values (?thisform.txtexped.value)")
    //if se < 1
    //messagebox("error al insertar expediente en PREDDEXPCONT",0,"Recibo Predial")
   //endif
// endif
//endif


				//ACTUALIZA PREDMYEAR
				$byear=trim(date("Y"));
				
				$sqlf= mssql_query("SELECT * FROM predmyear  where year=\"$byear\" ",$con);
				while($rowf =  mssql_fetch_array($sqlf))
				{
					 $wsuminporte	 = trim('importe_'.trim(date("n")));             
					 $waddimporte	 = $rowf[$wsuminporte]+$WTOTALMIMPORTE;
					 $waddimportefin = $rowf['importe_13']+$WTOTALMIMPORTE;
					 
					 $wsumrecgasa	 = trim('recgasa_'.trim(date("n"))); 
					 $waddrecgasa	 = $rowf[$wsumrecgasa]+$WTOTALwrecargos;   
					 $waddrecgasafin = $rowf['recgasa_13']+$WTOTALwrecargos;  
					
					 $wsumboniacu	 = trim('boniacu_'.trim(date("n"))); 
					 $waddboniacu	 = $rowf[$wsumboniacu]+$WTOTALwrecargos;   
					 $waddboniacufin = $rowf['boniacu_13']+$WTOTALpbonimp+$WTOTALbonrec;  
					 
					 $sqlfupdatepredmyear="update predmyear set $wsuminporte=$waddimporte,importe_13=$waddimportefin,$wsumrecgasa=$waddrecgasa,recgasa_13=$waddrecgasafin,$wsumboniacu=$waddboniacu,boniacu_13=$waddboniacufin where year=\"$byear\"";
					 mssql_query($sqlfupdatepredmyear,$con); 
				}
		   }
		   
		   //sorteo predial (con eso ejecuta el store.)
		   //$sqlSorteo = mssql_query("exec dbo.sorteoPredial @exp = \"$Expe\" ",$con);
		   
		   
	// <!-- FIN INSERT DEL PAGO-->
	break;

	case "SINEXP":
		echo "<script>";
		echo 'url="edopredial.php";';
		echo 'document.location = url;';
		echo "</script>";
		$wfoliorec = " ";   //garm20220831 

        $wcaja  = " ";

        $wdescconcepto = " ";
		
	break;

} //end switch                
?>

<HTML>
  <HEAD>
  <LINK REL="Shortcut Icon" HREF="images/gpe.ico"> 
    <title>Pago recibido. MUNICIPIO DE GUADALUPE N.L.</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  </HEAD>
  
  <body>
    <script type="text/javascript" src="jquery.js"></script>
    <form name="form1" id="form1" method="post" action="">
      <p><img src="images/Escudo-armas-pago-predial-2.jpg" border="0" alt="Gracias al pago de su Impuesto Predial, Guadalupe avanza mejorando su ciudad."></p>
      <p style="font-weight: bold; font-size: 22pt; font-family: verdana; color: gray;">Se registró su pago en nuestro Sistema.</p>
      <p style="font-weight: bold; font-size: 22pt; font-family: verdana; color: gray;">
      <img border="0" src="Images/logo_bancomer.gif" width="171" height="35"></p>
      <table border="0" style="font-size: 8pt; font-family: verdana">
        <tr>
          <td>El día:</td>
          <td style="color: red"><?php echo $hoy; ?></td>
        </tr>
        <tr>
          <td>Recibo de pago #:</td>
          <td style="color: red"><?php echo $wfoliorec; ?></td>
        </tr>
        <tr>
          <td>Caja :</td>
          <td style="color: red"><?php echo $wcaja; ?></td>
        </tr>
        <tr>
          <td>Por el Concepto de:</td>
          <td style="color: red"><?php echo $wdescconcepto; ?></td>
        </tr>
        <tr>
          <td>de :</td>
          <td style="color: red"><?php echo '$'.number_format($wimporte,2); ?></td>
        </tr>
        <tr>
          <td>Con Expediente # :</td>
          <td style="color: red"><?php echo $Expe; ?></td>
        </tr>
        <tr>
          <td>Con Autorizacion 
              Bancaria No.:</td>
          <td style="color: red"><?php echo $noperacion; ?></td>
        </tr>
      </table>
	  <br><br>
	  <table border="0" style="font-size: 8pt; font-family: verdana">
		<tr>
			<td>Correo Electrònico: <input type="email" name="correo" id="correo" style="width: 250px;" value=""></td>
			<td><input name="btnEnviar" id="btnIEnviar" type="button" class="button" value="Enviar Comprobante " onClick="enviar_comprobante()"></td>
		</tr>
	  </table>
	  <br><br>
      <p>
        <input name="Submit" type="button" onclick="javascript:window.close();" value="Cerrar">
        <input name="btnImprimir" id="btnImprimir" type="button" class="button" value="Imprimir " onClick="comprobate_pdf()">
      </p>
    </form>
	
	<script> 
		function imprime()
		{
			window.print()
		}
		
		function enviar_comprobante()
		{
			let expe = '<?php echo $Expe; ?>';
			let correo = $("#correo").val();
			if(correo == "")
			{
				alert('Favor de escribir su correo electrònico');
				return false;
			}
			
			$.ajax({
				type:"POST",
				url:"http://webservice.guadalupe.gob.mx/predial/pago/pdf",
				data:{"expediente":expe, "correo": correo},
				success:function(data)
				{
					console.log(data);
					alert('Se ha enviado el comprobante de pago a su correo electrònico');
					window.open(data);
				}
			});
        }
		
		function comprobate_pdf()
		{
			let expe = '<?php echo $Expe; ?>';
			
			$.ajax({
				type:"POST",
				url:"http://webservice.guadalupe.gob.mx/predial/pago/pdf",
				data:{"expediente":expe},
				success:function(data)
				{
					window.open(data);
				}
			});
        }
</script>
  </body>
</HTML>