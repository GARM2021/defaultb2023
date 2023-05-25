<?php

//calcula recargos y % de recargos                        
	if (trim($bimsem)=='06')
	{           
		$wbsyb=trim($bimsem).substr(trim($row['yearbim']),0,4).'04';            
		//echo $wbsyb.'cambio a 04 <br>';
	}
	else
	{
		$wbsyb=trim($bimsem).trim($row['yearbim']);  
		//echo $wbsyb.'se quedo igual <br>';
	}
		
//echo Busca en la tabla preddrequer si el expediente se encuentra requerido.        
	$wofecven=$row['fechaven'];
	$sql_Requerido= mssql_query("SELECT top 1 * FROM preddrequer where exp=\"$Expe\" ORDER BY freq DESC",$con); 
    //$sql_Requerido= mssql_query("SELECT top 1 freq FROM preddrequer where exp=\"$Expe\" ORDER BY freq DESC",$con); 	//GARM 22022022 080500075540
	$row_cnt_Requerido =  mssql_num_rows($sql_Requerido);
	//Fecha de ultimo requerimiento	
	 while($row_reque =  mssql_fetch_array($sql_Requerido))
	{  
		  $wRfecreq=$row_reque['freq']; 
		  //echo  $wRfecreq;
	} 
	
	if ($row_cnt_Requerido == 0)
	{
		//echo 'CALCULA RECARGOS CON LA TABLA 1 DE RECARGOS '.$wRfecreq.'  '.$wofecven;
		$sql_recargos= mssql_query("SELECT * FROM predmtabrec where bsyb=\"$wbsyb\" ",$con);
		$row_cnt_recargos=  mssql_num_rows($sql_recargos);
		if ($row_cnt_recargos==0)
		{
			// cuando no se encuentra el bsyb en la tabla
			$sql_recargos= mssql_query("SELECT top 1 * FROM predmtabrec order BY bsyb ",$con);
			$row_cnt_recargos=  mssql_num_rows($sql_recargos);
			while($row_recargos =  mssql_fetch_array($sql_recargos))
			{	
				 $wpctrec=trim('pctrec_'.trim(date("n")));
				 IF  ($WDIAMES==1)
				 {
					$WMESMENOS=trim(date("n"))-1;
					$wpctrec=trim('pctrec_'.trim($WMESMENOS));
					IF ($WMESMENOS==0)
					$wpctrec=trim('pctrec_'.trim('1'));
				 }             
				 //$wprecargos=$row_recargos[$wpctrec];  
				 $paso1 = ($row['salimp']*$row_recargos[$wpctrec])/100; 
				 $paso2 = $paso1*10;
				 $paso3 = (int)($paso2);              
				 $wrecargos=$paso3/10;	
				 ////$wrecargos=round((($row['salimp']-$row['salsub'])*$row_recargos[$wpctrec])/100,0);	
				 //echo '1 <br>';
				 //echo   $wpctrec;  	          	    
			}
		}
		else
		{        		
			while($row_recargos =  mssql_fetch_array($sql_recargos))
			{
				 $wpctrec=trim('pctrec_'.trim(date("n")));
				 IF  ($WDIAMES==1)
				 {
					$WMESMENOS=trim(date("n"))-1;
					$wpctrec=trim('pctrec_'.trim($WMESMENOS));
					IF ($WMESMENOS==0)
					$wpctrec=trim('pctrec_'.trim('1'));
				 }               
				 //$wprecargos=$row_recargos[$wpctrec];  
				 $paso1 = ($row['salimp']*$row_recargos[$wpctrec])/100; 
				 $paso2 = $paso1*10;
				 $paso3 = (int)($paso2);              
				 $wrecargos=$paso3/10;	
				 ////$wrecargos=round((($row['salimp']-$row['salsub'])*$row_recargos[$wpctrec])/100,0);            
				 //echo '2 <br>';
			}
		}
	}
	else
	{          	    
	  //si la fecha de requerimiento es mayor o igual al vencimiento utiliza recargos 2    
	  //echo 'fecha de requerido '.$wRfecreq.' '.$wofecven.'<br>';
	  if ($wRfecreq>=$wofecven)
	  {
		//echo'CALCULA RECARGOS CON LA TABLA 2 DE RECARGOS '.$wRfecreq.' >= '.$wofecven;
		$sql_recargos= mssql_query("SELECT * FROM predmtabrec2 where bsyb=\"$wbsyb\" ",$con);
		$row_cnt_recargos=  mssql_num_rows($sql_recargos);
		if ($row_cnt_recargos==0)
		{
			// cuando no se encuentra el bsyb en la tabla
			$sql_recargos= mssql_query("SELECT top 1 * FROM predmtabrec2 order BY bsyb ",$con);
			$row_cnt_recargos=  mssql_num_rows($sql_recargos);
			while($row_recargos =  mssql_fetch_array($sql_recargos))
			{	
			 $wpctrec=trim('pctrec_'.trim(date("n")));
			 IF  ($WDIAMES==1)
			 {
				$WMESMENOS=trim(date("n"))-1;
				$wpctrec=trim('pctrec_'.trim($WMESMENOS));
				IF ($WMESMENOS==0)
				$wpctrec=trim('pctrec_'.trim('1'));
			 }               
			 //$wprecargos=$row_recargos[$wpctrec];  
			 $paso1 = ($row['salimp']*$row_recargos[$wpctrec])/100; 
			 $paso2 = $paso1*10;
			 $paso3 = (int)($paso2);              
			 $wrecargos=$paso3/10;
			 ////$wrecargos=round((($row['salimp']-$row['salsub'])*$row_recargos[$wpctrec])/100,0);	
			 //echo   $wpctrec;  	          	    
			 //echo '3 <br>';
			}
		}
		else
		{
			while($row_recargos =  mssql_fetch_array($sql_recargos))
			{
			 $wpctrec=trim('pctrec_'.trim(date("n")));
			 IF  ($WDIAMES==1)
			 {
				$WMESMENOS=trim(date("n"))-1;
				$wpctrec=trim('pctrec_'.trim($WMESMENOS));
				IF ($WMESMENOS==0)
				$wpctrec=trim('pctrec_'.trim('1'));
			 }               
			 //$wprecargos=$row_recargos[$wpctrec];  
			 $paso1 = ($row['salimp']*$row_recargos[$wpctrec])/100; 
			 $paso2 = $paso1*10;
			 $paso3 = (int)($paso2);              
			 $wrecargos=$paso3/10;	
			 ////$wrecargos=round((($row['salimp']-$row['salsub'])*$row_recargos[$wpctrec])/100,0);
			 //echo   $wpctrec;           
			 //echo '4 <br>';	            	 
			}
		}    
	  }
	  ELSE
	  {	
		
		//echo 'CALCULA RECARGOS CON LA TABLA 1 DE RECARGOS '.$wRfecreq.' <= '.$wofecven;          	  	
		$sql_recargos= mssql_query("SELECT * FROM predmtabrec where bsyb=\"$wbsyb\" ",$con);
		$row_cnt_recargos=  mssql_num_rows($sql_recargos);
		if ($row_cnt_recargos==0)
		{
			// cuando no se encuentra el bsyb en la tabla
			$sql_recargos= mssql_query("SELECT top 1 * FROM predmtabrec order BY bsyb ",$con);
			$row_cnt_recargos=  mssql_num_rows($sql_recargos);
			while($row_recargos =  mssql_fetch_array($sql_recargos))
			{	
			 $wpctrec=trim('pctrec_'.trim(date("n"))); 
			 IF  ($WDIAMES==1)
			 {
				$WMESMENOS=trim(date("n"))-1;
				$wpctrec=trim('pctrec_'.trim($WMESMENOS));
				IF ($WMESMENOS==0)
				$wpctrec=trim('pctrec_'.trim('1'));
			 }              
			 //$wprecargos=$row_recargos[$wpctrec];  
			 $paso1 = ($row['salimp']*$row_recargos[$wpctrec])/100; 
			 $paso2 = $paso1*10;
			 $paso3 =(int)($paso2);              
			 $wrecargos=$paso3/10;
			 ////$wrecargos=round((($row['salimp']-$row['salsub'])*$row_recargos[$wpctrec])/100,0);
			 //echo   $wpctrec;  	          	    
			 //echo '5 <br>';
			}
		}
		else
		{        		        		
			while($row_recargos =  mssql_fetch_array($sql_recargos))
			{
			 $wpctrec=trim('pctrec_'.trim(date("n")));
			 IF  ($WDIAMES==1)
			 {
				$WMESMENOS=trim(date("n"))-1;
				$wpctrec=trim('pctrec_'.trim($WMESMENOS));
				IF ($WMESMENOS==0)
				$wpctrec=trim('pctrec_'.trim('1'));
			 }               
			 //$wprecargos=$row_recargos[$wpctrec];  
			 $paso1 = ($row['salimp']*$row_recargos[$wpctrec])/100; 
			 $paso2 = $paso1*10;
			 $paso3 = (int)($paso2);              
			 $wrecargos = $paso3/10;	
			 ////$wrecargos=round((($row['salimp']-$row['salsub'])*$row_recargos[$wpctrec])/100,0);
			 //echo '6 '.$row_recargos[$wpctrec].'<br>';
			 
			}
		}
	  }
	 
	 }                                              
	
   if ($row_cnt_recargos==0)                      
   {
   $wpctrec=trim('pctrec_'.trim(date("n"))); 
   $wntabla=trim($bimsem); 
   //echo 'NO SE ENCONTRO EL BSYB  '.$wbsyb.$wpctrec.'<br>';
   //echo "SELECT TOP 1 ".$wpctrec." FROM predmtabrec WHERE (SUBSTRING(bsyb, 1, 2) ='".$wntabla."') ORDER BY bsyb";                                   
	$sql_recargos2= mssql_query("SELECT TOP 1 ".$wpctrec." FROM predmtabrec WHERE (SUBSTRING(bsyb, 1, 2) ='".$wntabla."') ORDER BY bsyb",$con);
	$row_cnt_recargos2=  mssql_num_rows($sql_recargos2);
	while($row_recargos2 =  mssql_fetch_array($sql_recargos2))
	{             
		 $wprecargos=$row_recargos2[$wpctrec]; 
		 IF  ($WDIAMES==1)
		 {
			$WMESMENOS=trim(date("n"))-1;
			$wpctrec=trim('pctrec_'.trim($WMESMENOS));
			IF ($WMESMENOS==0)
			$wpctrec=trim('pctrec_'.trim('1'));
		 }   
		 $paso1	= ($row['salimp']*$wprecargos)/100;  
		 $paso2	= $paso1*10;
		 $paso3	= (int)($paso2);              
		 $wrecargos = $paso3/10;
		 ////$wrecargos=round((($row['salimp']-$row['salsub'])*$wprecargos)/100,0);
		 //echo '7 <br>';
	}                      
   }

?>