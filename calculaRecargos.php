<?php
//138 
//calcula recargos y % de recargos                        
if (trim($bimsem) == '06') {
	$wbsyb = trim($bimsem) . substr(trim($row->yearbim), 0, 4) . '04';
	//echo $wbsyb.'cambio a 04 <br>';
} else {
	$wbsyb = trim($bimsem) . trim(($row->yearbim));
	//echo $wbsyb.'se quedo igual <br>';
}

//echo Busca en la tabla preddrequer si el expediente se encuentra requerido.        
$wofecven = $row->fechaven;
//es valido  este codigo a laravel 5.4 y php 5.6

$sql_Requerido = DB::connection('sqlsrv')->select("SELECT top 1 * FROM preddrequer where exp = ? ORDER BY freq DESC", [$Expe]);
$row_cnt_Requerido = count($sql_Requerido);

foreach ($sql_Requerido as $row_reque) {
	$wRfecreq = $row_reque->freq;
	// echo $wRfecreq;
}

if ($row_cnt_Requerido == 0) {
	//echo 'CALCULA RECARGOS CON LA TABLA 1 DE RECARGOS '.$wRfecreq.'  '.$wofecven;
	//es valido  este codigo a laravel 5.4 y php 5.6
	// cuando no se encuentra el bsyb en la tabla
	$sql_recargos =DB::connection('sqlsrv')->select("SELECT * FROM predmtabrec where bsyb = ?", [$wbsyb]);
    $row_cnt_recargos = count($sql_recargos);

if ($row_cnt_recargos == 0) {
    // cuando no se encuentra el bsyb en la tabla
    $sql_recargos = DB::connection('sqlsrv')->select("SELECT top 1 * FROM predmtabrec order BY bsyb");
    $row_cnt_recargos = count($sql_recargos);

    foreach ($sql_recargos as $row_recargos) {
        $wpctrec = trim('pctrec_' . date("n"));
        if ($WDIAMES == 1) {
            $WMESMENOS = trim(date("n")) - 1;
            $wpctrec = trim('pctrec_' . trim($WMESMENOS));
            if ($WMESMENOS == 0)
                $wpctrec = trim('pctrec_1');
        }

        $paso1 = ($row->salimp * $row_recargos->{$wpctrec}) / 100;
        $paso2 = $paso1 * 10;
        $paso3 = (int)($paso2);
        $wrecargos = $paso3 / 10;
    }
}
	
	
	
	else {
		//es valido  este codigo a laravel 5.4 y php 5.6
		 foreach ($sql_recargos as $row_recargos) {
			$wpctrec = trim('pctrec_' . date('n'));
		
			if ($WDIAMES == 1) {
				$WMESMENOS = trim(date('n'))- 1;
				$wpctrec = trim('pctrec_' . trim($WMESMENOS));
		
				if ($WMESMENOS == 0) {
					$wpctrec = trim('pctrec_1');
				}
			}
		
			$paso1 = ($row->salimp * $row_recargos->{$wpctrec}) / 100;
			$paso2 = $paso1 * 10;
			$paso3 = (int)($paso2);
			$wrecargos = $paso3 / 10;
		}




	}
}
 else {
	//si la fecha de requerimiento es mayor o igual al vencimiento utiliza recargos 2    
	//echo 'fecha de requerido '.$wRfecreq.' '.$wofecven.'<br>';
	//es valido  este codigo a laravel 5.4 y php 5.6
	
		if ($wRfecreq >= $wofecven) 
		{
			//echo 'CALCULA RECARGOS CON LA TABLA 2 DE RECARGOS '.$wRfecreq.' >= '.$wofecven;
			$sql_recargos = DB::connection('sqlsrv')->select("SELECT * FROM predmtabrec2 where bsyb= = ?", [$wbsyb]);
			$row_cnt_recargos = count($sql_recargos);
		
			if ($row_cnt_recargos == 0) {
				// cuando no se encuentra el bsyb en la tabla
				$sql_recargos =DB::connection('sqlsrv')->select("SELECT top 1 * FROM predmtabrec2 order BY bsyb");
				$row_cnt_recargos = count($sql_recargos);
		
				foreach ($sql_recargos as $row_recargos) {
					$wpctrec = trim('pctrec_' .trim( date('n')));
		
					if ($WDIAMES == 1) {
						$WMESMENOS = date('n') - 1;
						$wpctrec = trim( 'pctrec_' . trim($WMESMENOS));
		
						if ($WMESMENOS == 0) {
							$wpctrec = trim('pctrec_1');
						}
					}
		
					$paso1 = ($row->salimp * $row_recargos->{$wpctrec}) / 100;
					$paso2 = $paso1 * 10;
					$paso3 = (int)($paso2);
					$wrecargos = $paso3 / 10;
					////$wrecargos=round((($row['salimp']-$row['salsub'])*$row_recargos[$wpctrec])/100,0);    
					//echo $wpctrec;
					//echo '3 <br>';
				}
			}
		
		//$wrecargos=round((($row['salimp']-$row['salsub'])*$row_recargos[$wpctrec])/100,0);    
				
		else {
			//convierte el codigo a laravel 5.4 y php 5.6
				foreach ($sql_recargos as $row_recargos) {
				$wpctrec = trim('pctrec_' . trim(date('n')));
			
				if ($WDIAMES == 1) {
					$WMESMENOS = trim(date('n')) - 1;
					$wpctrec = trim( 'pctrec_' . trim($WMESMENOS));
			
					if ($WMESMENOS == 0) {
						$wpctrec = trim('pctrec_1');
					}
				}
			
				$paso1 = ($row->salimp * $row_recargos->{$wpctrec}) / 100;
				$paso2 = $paso1 * 10;
				$paso3 = (int)($paso2);
				$wrecargos = $paso3 / 10;
			}
		}
		}
	 else {

		//echo 'CALCULA RECARGOS CON LA TABLA 1 DE RECARGOS '.$wRfecreq.' <= '.$wofecven;   
		//convierte el codigo a laravel 5.4 y php 5.6       	  	
			$sql_recargos = DB::connection('sqlsrv')->select("SELECT * FROM predmtabrec WHERE bsyb=?", [$wbsyb]);
			$row_cnt_recargos = count($sql_recargos);
			if ($row_cnt_recargos == 0) {
				// cuando no se encuentra el bsyb en la tabla
				$sql_recargos = DB::connection('sqlsrv')->select("SELECT * FROM predmtabrec ORDER BY bsyb LIMIT 1");
				$row_cnt_recargos = count($sql_recargos);
				foreach ($sql_recargos as $row_recargos) {
					$wpctrec = trim('pctrec_' . trim(date("n")));
					if ($WDIAMES == 1) {
						$WMESMENOS = trim(date("n")) - 1;
						$wpctrec = trim('pctrec_' . trim($WMESMENOS));
						if ($WMESMENOS == 0)
							$wpctrec = trim('pctrec_' . trim('1'));
					}
					//$wprecargos=$row_recargos[$wpctrec];  
					$paso1 = ($row['salimp'] * $row_recargos->{$wpctrec}) / 100;
					$paso2 = $paso1 * 10;
					$paso3 = (int)($paso2);
					$wrecargos = $paso3 / 10;
					////$wrecargos=round((($row['salimp']-$row['salsub'])*$row_recargos->$wpctrec)/100,0);
					//echo   $wpctrec;           
					//echo '5 <br>';
				}
			}

		
		 else
		 {
				//convierte el codigo a laravel 5.4 y php 5.6    
			foreach ($sql_recargos as $row_recargos) {
				$wpctrec = trim('pctrec_' . trim(date("n")));
				if ($WDIAMES == 1) {
					$WMESMENOS = trim(date("n")) - 1;
					$wpctrec = trim('pctrec_' . trim($WMESMENOS));
					if ($WMESMENOS == 0)
						$wpctrec = trim('pctrec_' . trim('1'));
				}
				//$wprecargos=$row_recargos[$wpctrec];  
				$paso1 = ($row->slimp * $row_recargos->{$wpctrec}) / 100;
				$paso2 = $paso1 * 10;
				$paso3 = (int)($paso2);
				$wrecargos = $paso3 / 10;
				////$wrecargos=round((($row['salimp']-$row['salsub'])*$row_recargos->$wpctrec)/100,0);
				//echo '6 '.$row_recargos->$wpctrec.'<br>';
			}
		}
	}

	//convierte el codigo a laravel 5.4 y php 5.6    
if ($row_cnt_recargos == 0) {
    $wpctrec = trim('pctrec_' . trim(date("n")));
    $wntabla = trim($bimsem);
    //echo 'NO SE ENCONTRO EL BSYB  '.$wbsyb.$wpctrec.'<br>';
    //echo "SELECT TOP 1 ".$wpctrec." FROM predmtabrec WHERE (SUBSTRING(bsyb, 1, 2) ='".$wntabla."') ORDER BY bsyb";
    $sql_recargos2 = DB::connection('sqlsrv')->select("SELECT TOP 1 " . $wpctrec . " FROM predmtabrec WHERE (SUBSTRING(bsyb, 1, 2) ='" . $wntabla . "') ORDER BY bsyb");
    $row_cnt_recargos2 = count($sql_recargos2);
    foreach ($sql_recargos2 as $row_recargos2) {
        $wprecargos = $row_recargos2->{$wpctrec};
        if ($WDIAMES == 1) {
            $WMESMENOS = trim(date("n")) - 1;
            $wpctrec = trim('pctrec_' . trim($WMESMENOS));
            if ($WMESMENOS == 0)
                $wpctrec = trim('pctrec_' . trim('1'));
        }
        $paso1 = ($row['salimp'] * $wprecargos) / 100;
        $paso2 = $paso1 * 10;
        $paso3 = (int) ($paso2);
        $wrecargos = $paso3 / 10;
       //$wrecargos=round((($row['salimp']-$row['salsub'])*$wprecargos)/100,0);
        //echo '7 <br>';
    }
}
 }
?>