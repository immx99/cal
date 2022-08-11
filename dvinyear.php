<?php
function DV_InYear($tanggal) : int  {
	$tgl=(int) substr($tanggal,0,2);	
	$bln=(int)substr($tanggal,3,2);
	$thn=(int) substr($tanggal,6);
	//echo "$tgl <br>";
	if ( $bln>1 ) {
		$hg_bl_tot=0;
		$hg_bl=0;
		for ($i = $bln-1; $i >= 1; $i--) {
			switch ($i) {
				case $i== 1 ||  $i==3 || $i==5 ||  $i==7 ||  $i==8 ||  $i==10:
					$hg_bl=31;
					break;
				case  $i==2:	
					//echo "Masuk";			
					if ($thn % 4 > 0) {
						$hg_bl = 28;
					} else {
						$hg_bl = 29;
					}

					break;	
			    case  $i==4 || $i==6 ||  $i==9 ||  $i==11:
					$hg_bl = 30;
					break;
				

			}
			$hg_bl_tot += $hg_bl;
		}		
		
	}
	$DV=$hg_bl_tot + $tgl;
	return $DV;
}

?>