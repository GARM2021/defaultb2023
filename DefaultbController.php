<?php

//session_start(); 


//inicializo 

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;



class DefaultbController extends Controller
{
	function procesaPagopredial()
	{ //!>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>




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
		//Puedes hacer lo que quieras con el c�digo

		//Configuracion de la conexion a base de datos

		//	require('conecta.php');
		require('validapost.php'); //garm20220827



		//! Insert correcto 20230601
		// $sqlIns = "Insert into predmwebTransaction ([Expe],[s_transm],[referencia],[val_1_nivelDetalle],[t_servicio],[t_importe],[val_3_moneda],[t_pago],[n_autoriz],[val_9_numtc],[val_10_fpagp],[val_5_financiamiento],[val_6_periodoFinan],[val_11_email],[val_12_Telefono],[val_13_Sha1],[fecha] ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,  getdate() )";

		// DB::connection('sqlsrv')->statement($sqlIns, [   
		// 	$Expe,                     
		// 	$wsecuencia,
		// 	$wreferencua,
		// 	$wval_1,
		// 	$wservicio,
		// 	$wimporte,
		// 	$val_3,
		// 	$t_pago,
		// 	$noperacion,
		// 	$val_9,
		// 	$val_10,
		// 	$val_5,
		// 	$val_6,
		// 	$val_11,
		// 	$val_12,
		// 	$val_13

		// ]);

		//garm20220726 



		$numcaracteres = strlen(trim($wreferencua));
		if ($numcaracteres > 0) {
			$wvarpaso = 'CONEXP';
		} else {
			$wvarpaso = 'SINEXP';
		}

		switch ($wvarpaso) {
			case "CONEXP":
				$Expe = trim($wreferencua);  		// Referencia "Referencia �nica e irrepetible por proceso de pago" 
				//$Expe       ='34392009';
				$Region     = trim(substr($Expe, 0, 2));
				$RegionManz = trim(substr($Expe, 0, 5));

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
				$wdescconcepto	= trim('PAGO IMP. PREDIAL Exp: ' . $Expe . ' ');
				//$wdescconcepto1	= phpversion();

				//EXTRAE NUMERO CONSECUTIVO DE RECIBO



				/////////////////////////////////////////////////// GARM 20220322 080500076147

				//$sqlpru = "EXEC SP_NewRecOf ?" . $Exp; ejemplo con parametro GARM 20220407
				//es valido  este codigo a laravel 5.4 y php 5.6
				// $sqlpru = "EXEC SP_NewRecOf ";
				// $spresource = mssql_query($sqlpru, $con);
				//DB::statement('EXEC nombre_del_procedimiento ?, ?', [$parametro1, $parametro2]);
				//$spName = "SP_NewRecOf";
				//$result =DB::connection('sqlsrv')->select("CALL " . $spName); //! 
				//$result  = DB::connection('sqlsrv')->statement('EXEC SP_NewRecOf');
				$results = DB::connection('sqlsrv')->select('EXEC SP_NewRecOf');
				$spfoliorec = "0";

				if (!empty($results) && is_object($results[0])) {
					$rowf = $results[0];
					$spfoliorec = $rowf->sfoliorec;
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
				//es valido  este codigo a laravel 5.4 y php 5.6

				$sql = DB::connection('sqlsrv')->select("SELECT ctaimporte, ctarecargo, ctasancion, ctagastos, ctaotros, centro FROM ingresmconceptos where con = ?", [$wconcepto]);

				if (!empty($sql)) {
					$rowf = $sql[0];
					$wctaimporte = trim($rowf->ctaimporte);
					$wctarecargo = trim($rowf->ctarecargo);
					$wctasancion = trim($rowf->ctasancion);
					$wctagastos = trim($rowf->ctagastos);
					$wctaotros = trim($rowf->ctaotros);
					$wcentro = trim($rowf->centro);
				}

				/////////////////////////////////////////////////////////////////////////////////////////////////
				//INICIO CALCULA ADEUDOS
				//DATOS GENERALES DEL EXPEDIENTE
				//$sql= mssql_query("SELECT * FROM preddexped where exp=\"$Expe\" and fbaja < '00000001' order by exp",$con);
				//es valido  este codigo a laravel 5.4 y php 5.6

				$sql = DB::connection('sqlsrv')->select("SELECT apat, amat, nombre, domubi, colubi FROM preddexped where exp = ? and fbaja < '00000001' order by exp", [$Expe]);
				$row_cnt = count($sql);

				if ($row_cnt == 0) {
					$wheader = "Edopredial.php?msg=SI";
					$redireccionar = 1;
				}

				foreach ($sql as $row) {
					$wsnombre = trim($row->apat) . ' ' . trim($row->amat) . ' ' . trim($row->nombre);
					$wsdireccion = trim($row->domubi) . ', COL.' . trim($row->colubi);
					$wsciudad = 'CD. GUADALUPE, NUEVO LEON';
				}

				$WGRANTOTAL = 0;



				//$query= "SELECT a.*,b.descripcion FROM preddadeudos a, predmtpocar b where a.exp=\"$Expe\" and";
				//es valido  este codigo a laravel 5.4 y php 5.6

				$query = "SELECT a.tpocar, a.yearbim, a.montoimp, a.salimp, a.salsub, a.bimsem, a.pctimpbon, a.impbon, a.fechaven, b.descripcion FROM preddadeudos a, predmtpocar b where a.exp = ? and";
				$query .= " b.tpocar COLLATE DATABASE_DEFAULT = a.tpocar COLLATE DATABASE_DEFAULT  and a.estatus < '0001' ORDER BY yearbim";

				$sql = DB::connection('sqlsrv')->select($query, [$Expe]);
				$row_cnt = count($sql);

				$descuentoAdicionalFlag = true;

				$query222 = "SELECT a.exp, b.descripcion FROM preddadeudos a, predmtpocar b where a.exp = ? and";
				$query222 .= " b.tpocar COLLATE DATABASE_DEFAULT = a.tpocar COLLATE DATABASE_DEFAULT  and a.estatus < '0001' AND impbon > 0 ORDER BY yearbim";

				$sql222 = DB::connection('sqlsrv')->select($query222, [$Expe]);
				$row_cnt222 = count($sql222);

				if ($row_cnt222 > 0) {
					$descuentoAdicionalFlag = false;
				}


				//es valido  este codigo a laravel 5.4 y php 5.6

				foreach ($sql as $row) {
					$pbonimp = 0;
					$bonrec = 0;
					$tpocar = $row->tpocar;
					$bimsem = $row->bimsem;
					$wyearbim = $row->yearbim;

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
					//es valido  este codigo a laravel 5.4 y php 5.6

					$sql2 = DB::connection('sqlsrv')->select("SELECT pctbonimp, funautbon FROM bondbonpred where tpocar = ? and fecini <= ? and fecfin >= ? and estatus = '0'", [$tpocar, $hoy, $hoy]);
					$row_cnt2 = count($sql2);

					foreach ($sql2 as $row2) {
						$paso1 = (($row->salimp - $row->salsub) * $row2->pctbonimp) / 100;

						if ($tpocar == '0002') {
							$paso1 = ($row->salimp * ($row2->pctbonimp + 5)) / 100;
						}

						$paso2 = $paso1 * 10;
						$paso3 = (int) $paso2;
						$pbonimp = $paso3 / 10;
						$wfun = $row2->funautbon;
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
					if ($tpocar > '0002') {
						$wprecargos = 0;
						$wrecargos  = 0;
					}

					//calcula BONIFICACION DE recargos y % DE BONIFICACION de recargos
					//es valido  este codigo a laravel 5.4 y php 5.6
					$sql3 = "SELECT pctbonrec FROM bondbonpred where tpocar=? and fecini<=? and fecfin>=? and estatus='0'";
					$params3 = [$tpocar, $hoy, $hoy];
					$result3 = DB::connection('sqlsrv')->select($sql3, $params3);
					$row_cnt3 = count($result3);

					foreach ($result3 as $row3) {
						$pbonrec = $row3->pctbonrec;
						$paso1 = ($wrecargos * $row3->pctbonrec / 100);
						$paso2 = $paso1 * 10;
						$paso3 = (int)($paso2);
						$bonrec = $paso3 / 10;
					}


					//$WNETO			= ($row['salimp']+$wrecargos)-($pbonimp+$bonrec+$row['salsub']);
					$WNETO			= (round($row->salimp, 2) + round($wrecargos, 2)) - (round($pbonimp, 2) + round($bonrec, 2) + round($row->salsub, 2));
					$WimpNETO		= $row->salimp;
					$WTOTALMIMPORTE	= $WTOTALMIMPORTE + $row->salimp;
					$WTOTALsalsub	= $WTOTALsalsub + $row->salsub;
					$WTOTALsalimp	= $WTOTALsalimp + $row->salimp;
					$WTOTALpbonimp	= $WTOTALpbonimp + $pbonimp;
					$WTOTALwrecargos = $WTOTALwrecargos + $wrecargos;
					$WTOTALbonrec	= $WTOTALbonrec + $bonrec;


					//DESCUENTO POR PRONTO PAGO Ingresdingresos Descpp
					$wdescpp 	 = $wdescpp + $row->salsub; //! GARM 20211226  no se movio 

					if (substr($row->yearbim, 0, 4) == date("Y")) {
						$TotalImpuestoPredial += $WNETO;
					}

					//REZAGO
					if ($tpocar == '0001') {
						$wresago		= $wresago + $row->salimp;
						$wresagorec		= $wresagorec + $wrecargos;
						$wresagobonrec	= $wresagobonrec + $bonrec;
						//$wresagobonimp	= $wresagobonimp+$pbonimp+$row['salsub'];           	
						$wresagobonimp	= $wresagobonimp + $pbonimp;
					}

					//PREDIAL
					if ($tpocar == '0002') {
						$wpredial		= $wpredial + $row->salimp;
						$wpredialrec	= $wpredialrec + $wrecargos;
						$wpredialbonrec	= $wpredialbonrec + $bonrec;
						//$wpredialbonimp	= $wpredialbonimp+$pbonimp+$row['salsub'];
						$wpredialbonimp	= $wpredialbonimp + $pbonimp; //! GARM 20211226  no se movio 
					}

					//GASTOS
					if ($tpocar == '0003') {
						$wgasto			= $wgasto + $row->salimp;
						//$wgastobonimp	= $wgastobonimp+$pbonimp+$row['salsub'];
						$wgastobonimp	= $wgastobonimp + $pbonimp;
					}

					//SANCIONES
					if ($tpocar == '0004') {
						$wsancion		=	$wsancion + $row->salimp;
						//$wsancionbonimp =	$wsancionbonimp+$pbonimp+$row['salsub'];           
						$wsancionbonimp	=	$wsancionbonimp + $pbonimp;
					}

					$WGRANTOTAL = $WGRANTOTAL + $WNETO;
					$salsub = $row->salsub;

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
					if ($descuentoAdicionalFlag)  // 20211110  aqui me faltaba el abrir parentisis
					{
						$descuento = $TotalImpuestoPredial * ($descuentoBonLinea / 100);
						$pbonimp += $descuento;
						$wpredialbonimp += $descuento;
					}




					//$sqlrevpag= mssql_query("SELECT * FROM preddpagos where exp=\"$Expe\" and yearbim=\"$wyearbim\" and fpago=\"$hoy\" and estatus='0000' and tpocar=\"$tpocar\" ",$con); // garm 20220204 09:43 anterior
					//es valido  este codigo a laravel 5.4 y php 5.6
					$sqlrevpag = "SELECT exp FROM preddpagos where exp=? and yearbim=? and fpago > '01' and estatus='0000' and tpocar=?";
					$paramsrevpag = [$Expe, $wyearbim, $tpocar];
					$resultrevpag = DB::connection('sqlsrv')->select($sqlrevpag, $paramsrevpag);
					$reccount_revpag = count($resultrevpag);
					if ($reccount_revpag == 0) {
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
						//es valido  este codigo a laravel 5.4 y php 5.6
						DB::connection('sqlsrv')->table('preddpagos')->insert([
							'exp' => $Expe,
							'ctafolio' => '00000000000000',
							'cuenta' => '00000000',
							'yearbim' => $wyearbim,
							'montoimp' => $WimpNETO,
							'bonif' => $pbonimp,
							'recargos' => $wrecargos,
							'bonrec' => $bonrec,
							'tpocar' => $tpocar,
							'caja' => $wcaja,
							'recibo' => $wfoliorec,
							'estatus' => '0000',
							'fun' => $wfun,
							'fpago' => $hoy,
							'ofipago' => $wofipago,
							'region' => $Region,
							'regman' => $RegionManz,
							'subsidio' => $salsub,
							'fcancont' => '',
							'numunico' => 0,
							'indiceini' => 0,
							'indicefin' => 0,
							'yearindini' => 0,
							'refban' => '',
							'yearindfin' => $noperacion,
						]);

						DB::connection('sqlsrv')->table('preddadeudos')
							->where('exp', $Expe)
							->where('yearbim', $wyearbim)
							->where('estatus', '0000')
							->update(['salimp' => 0, 'salsub' => 0]);
					}
					// <!-- FIN INSERT DEL PAGO preddpagos--> 
					//! aqui va el }   
				}
				//20211202 garm se perdio este cerrar lo inclui de nuevo ??? //

				$wtotrec = $wresagorec + $wpredialrec;
				$wtotbonrec = $wresagobonrec + $wpredialbonrec;

				//FIN CALCULA ADEUDOS
				/////////////////////////////////////////////////////////////////////////////////////////////////

				//$sqlrevpagingres= mssql_query("SELECT * FROM ingresdingresos where referencia=\"$Expe\" and fecha=\"$hoy\" ",$con);
				//es valido  este codigo a laravel 5.4 y php 5.6	
				$sql = "SELECT recibo FROM ingresdingresos where referencia=? and fecha=?";
				$params = array($Expe, $hoy);
				$result = DB::connection('sqlsrv')->select($sql, $params);
				$reccount_revpagINGRES = count($result);

				if ($reccount_revpag > 0) {
					$reccount_revpagINGRES = 1;
				}



			

				// if ($reccount_revpagINGRES == 0) { //! debe ir 
				DB::connection('sqlsrv')->table('ingresdingresos')->insert([
					'fecha' => $hoy,
					'recibo' => $wfoliorec,
					'caja' => $wcaja,
					'nombre' => $wsnombre,
					'direccion' => $wsdireccion,
					'ciudad' => $wsciudad,
					'concepto_1' => $wdescconcepto,
					'concepto_2' => '',
					'concepto_3' => '',
					'concepto_4' => '',
					'ctaimporte' => $wctaimporte,
					'importe' => $wpredial,
					'bonimporte' => $wpredialbonimp,
					'ctarecargo' => $wctarecargo,
					'recargos' => $wtotrec,
					'bonrecargo' => $wtotbonrec,
					'ctasancion' => $wctasancion,
					'sanciones' => $wsancion,
					'bonsancion' => $wsancionbonimp,
					'ctagastos' => $wctagastos,
					'gastos' => $wgasto,
					'bongastos' => $wgastobonimp,
					'ctaotros' => $wctaotros,
					'otros' => $wresago,
					'bonotros' => $wresagobonimp,
					'fun' => $wfun,
					'estatusmov' => '00',
					'tipo' => 'PR',
					'centro' => $wcentro,
					'referencia' => $Expe,
					'descpp' => $wdescpp,
					'con' => $wconcepto,
					'numtc' => $numtc,
					'refban' => $noperacion,
					'imptc' => $wimporte,
				]);

				//	}//! debe ir 


				//ACTUALIZA INGRESMCENTROS
				//es valido  este codigo a laravel 5.4 y php 5.6	
				$rowf = DB::connection('sqlsrv')->select("SELECT * FROM ingresmcentros WHERE centro=?", [$wcentro]);
				foreach ($rowf as $row) {
					$wsumingreso = trim('ingreso_' . trim(date("n")));
					$wprecargos = $row->{$wsumingreso} + $WGRANTOTAL;
					$wprecargos13 = $row->ingreso_13 + $WGRANTOTAL;
					$sqlfupdatemcentros = "UPDATE ingresmcentros SET $wsumingreso=$wprecargos, ingreso_13=$wprecargos13 WHERE centro=?";

					DB::connection('sqlsrv')->update($sqlfupdatemcentros, [$wcentro]);
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
				//*

				//ACTUALIZA PREDMYEAR
				//es valido  este codigo a laravel 5.4 y php 5.6
				$byear = trim(date("Y"));

				$rowf = DB::connection('sqlsrv')->select("SELECT * FROM predmyear WHERE year=?", [$byear]);
				foreach ($rowf as $row) {
					$wsuminporte = trim('importe_' . trim(date("n")));
					$waddimporte = $row->{$wsuminporte} + $WTOTALMIMPORTE;
					$waddimportefin = $row->importe_13 + $WTOTALMIMPORTE;

					$wsumrecgasa = trim('recgasa_' . trim(date("n")));
					$waddrecgasa = $row->{$wsumrecgasa} + $WTOTALwrecargos;
					$waddrecgasafin = $row->recgasa_13 + $WTOTALwrecargos;

					$wsumboniacu = trim('boniacu_' . trim(date("n")));
					$waddboniacu = $row->{$wsumboniacu} + $WTOTALwrecargos;
					$waddboniacufin = $row->boniacu_13 + $WTOTALpbonimp + $WTOTALbonrec;

					$sqlfupdatepredmyear = "UPDATE predmyear SET $wsuminporte=$waddimporte, importe_13=$waddimportefin, $wsumrecgasa=$waddrecgasa, recgasa_13=$waddrecgasafin, $wsumboniacu=$waddboniacu, boniacu_13=$waddboniacufin WHERE year=?";
					DB::connection('sqlsrv')->update($sqlfupdatepredmyear, [$byear]);
				}


				//sorteo predial (con eso ejecuta el store.)
				//$sqlSorteo = mssql_query("exec dbo.sorteoPredial @exp = \"$Expe\" ",$con);


				// <!-- FIN INSERT DEL PAGO-->
					$datos = [];
								

						$datos["hoy"] = $hoy;
						$datos["wfoliorec"] = $wfoliorec;
						$datos["wcaja"] = $wcaja;
						$datos["wdescconcepto"] = $wdescconcepto;
						$datos["Expe"] = $Expe;
						$datos["noperacion"] = $noperacion;
						$datos["wimporte"] = $wimporte;
					

					
					return view('predial_compago', ["resultados" => $datos]);
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
		}


		//!aqui termina
	}
}
