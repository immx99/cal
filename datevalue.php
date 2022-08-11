<?php
function DateValue($tanggal) : int  {
	$tgl=(int) substr($tanggal,0,2);	
	$bln=(int) substr($tanggal,3,2);
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
			//echo "$i==== $hg_bl_tot***";
		}

	}
	
	if (($thn-1) % 4 == 0 ) {
		$DV=($thn-1) * 365.25 + $hg_bl_tot + $tgl;
	} else {
		$DV = (($thn-1) - ($thn - 1) % 4) * 365.25 + (($thn - 1) % 4) * 365 + $hg_bl_tot + $tgl;
	}
    
	switch ($DV) {
		case $DV > 1 && $DV <= 639798:
			$kor_cal = 0;
			break;
		case $DV > 639798 && $DV <= 639809:  //2 Sep 1752
			$kor_cal = $DV - 639798;
			break;	
	    case $DV > 639809 && $DV <= 657144:  //14 Sep 1752 mulai disadari pergeseran tanggal per periode 400 tahun
			$kor_cal = 11;
			break;	
	    case $DV > 657144 && $DV <= 693669:  //28 Peb 1800 bukan kabisat karena bisa dibagi 100 tp tdk bisa dibagi 400
			$kor_cal = 12;
			break;		
		case $DV > 693669 && $DV <= 766718:	//28 Peb 1900 bukan kabisat karena bisa dibagi 100 tp tdk bisa dibagi 400
			$kor_cal = 13;
			break;
		case $DV > 766718:	//28 Peb 2100 bukan kabisat karena bisa dibagi 100 tp tdk bisa dibagi 400
			$kor_cal = 14;
			break;			
    }

	return $DV - $kor_cal ;
	//return (int) $thn;
}
?>