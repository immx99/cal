<?php
function tglHijriyah($DV) {
	$jam=$_GET['jam'];
	if ($jam==null) {
		$jam=date('H:i:s');
	}	
	// $DV+=1;
	$DV_deg=$DV;
	// echo "DV= ". $DV;
	$timeInFloat=(float) substr($jam, 0,2) + ((float) substr($jam, 3,2))/60 + ((float) substr($jam, 5))/3600;
	// echo "Time = " . $timeInFloat;		
	// if ($timeInFloat>18.00) {
	// 	$DV_deg -=1;	
	// 	//$DV +=1;
	// }
//	echo "DV     = " . $DV;	
//	echo "DV Deg = " . $DV_deg;	
	$secInMonth=29*24*3600;
	$secInHour=12*3600;
	$secInMinute=44*60;
	$secInSecond=9;
	$oneMonth=$secInMonth+$secInHour+$secInMinute+$secInSecond; //=2.551.449 sec
	$oneYear=$oneMonth * 12;
	//Jakarta

	$secCorrection=1088937 - 45240;
	$rCor=0;

	// Else
	// koreksi = 1088937 - (45240 + 4 * 3600)
	// rCor = 4 * 3600
	// End If
	// 'konjungsi awal pada tgl 12 jam 1:22
	// ' tgl 13 mulai tgl 1 dengan harga hari =
	// 'jakarta=106deg 50'
	// 'mekkah= 39deg 49'
	// 'perMin=360/24*60=0.25deg
	// det_kon! = (11! * 60 + 26) * 60 'konjungsi pada tgl 9 jan 97 jam 11:26
	
	
	
	
	$secConjungsion = (11 * 60 + 26) * 60;     //'konjungsi pada tgl 9 jan 97 jam 11:26
	$secValue = (($DV_deg * 3600 * 24 - $secCorrection) / $oneMonth - floor(($DV_deg * 3600 * 24 - $secCorrection) / $oneMonth)) * $oneMonth;
	$perDegree = $oneMonth / 360;  //perDegree dalam detik waktu
	$perMin = $perDegree / 60;     //perMenit sudut dalam detik waktu
	$perSec = $perDegree / 3600;   //perDetik sudut dalam detik waktu
	$crtdSecValue = $DV_deg * 3600 * 24 + $rCor;
	//echo " sec value = " . $secValue;
	
	$crtdSecValue1 = $crtdSecValue + ((int) substr($jam,0,2)) *3600 + ((int) substr($jam,3,2)) * 60 + (int) substr($jam,5);
	//echo "/" . $crtdSecValue1;
	$crtdSecValue1 = $crtdSecValue1 - 1043697; // '7 * perDegree - 29 * perMin - 31 * perSec 
	$secInPeriode = $crtdSecValue1- floor($crtdSecValue1/$oneMonth) * $oneMonth;	
	//echo "/" . $crtdSecValue1;
	//echo "////////";
	//echo "/" . $secInPeriode;

	//rNilaiDetik = aNilaiDetik + Val(ElQuery(vJam, 1)) * 3600 + Val(ElQuery(vJam, 2)) * 60 + Val(ElQuery(vJam, 3))
	//rNilaiDetik = rNilaiDetik - 1043697 '7 * perDegree - 29 * perMin - 31 * perSec
	//secInPeriode = rNilaiDetik - Int(rNilaiDetik / sebulan) * sebulan
	$degAbs=$secInPeriode/$perDegree;
	$degree=floor($secInPeriode/$perDegree);
	$secDiff=$secInPeriode - $degree*$perDegree;
	$minute=floor($secDiff/$perMin);
	$secDiff=$secDiff - $minute*$perMin;
	$second=$secDiff/$perSec;
	//echo "   Degree= " . $degree;
	//echo "   Menit= " . $minute;
	// vDegAbs = secInPeriode / perDegree
	// vDegree = Int(secInPeriode / perDegree)
	// sisaSec = secInPeriode - vDegree * perDegree
	// vMinute = Int(sisaSec / perMin)
	// sisaSec = sisaSec - vMinute * perMin
	// vSecond = Int(sisaSec / perSec)
	$txtDegree=$degree . "° " . $minute . "' " . number_format($second,4) . '"';
	$secInPeriodeMin=360*$perDegree - $secInPeriode;
	$degreeMin=floor($secInPeriodeMin/$perDegree);
	$secDiffMin=$secInPeriodeMin - $degreeMin*$perDegree;
	$minuteMin=floor($secDiffMin/$perMin);
	$secDiffMin=$secDiffMin - $minuteMin*$perMin;
	$secondMin=$secDiffMin/$perSec;
	$txtDegreeMin="-" . $degreeMin . "° " . $minuteMin . "' " . number_format($secondMin,4) . '"';


	//echo $txtDegree;

	$yearValue=(($DV*24*3600 - $secCorrection + 5 * $oneMonth)/$oneYear) + 1;
	$monthValue= floor(($DV*24*3600 - $secCorrection)/$oneMonth) + 1;
	$thnHijriyah=$yearValue - (2059 - 1418);
	$blnHijriyah=$monthValue%12;

	//Int((DV * 24 * 3600! - koreksi + 5 * sebulan!) / setahun!) + 1
	//nilai_bulan& = Int((DV * 24 * 3600! - koreksi) / sebulan!) + 1
	//tahun = nilai_tahun% - (2059 - 1418)
	//bulan = nilai_bulan& Mod 12
     	// If nilai_detik! < 0 Then
	// nilai_detik! = sebulan! - Abs(nilai_detik!)
	// tahun = tahun - 1
	// End If
	if ($secValue<0) {
		$secValue=$oneMonth - abs($secValue);
		$thnHijriyah -= 1;
	}
	// tgl_hs! = nilai_detik! / (24 * 3600!)
	// detik_pertama! = nilai_detik! - Int(tgl_hs!) * 24 * 3600
	// If cmbPendapat = "NU" Then
	// vPendapat = 10 'Konjungsi Jam 14.00
	// vSyDeg = 2
	// Else
	// vPendapat = 6
	// vSyDeg = 0 'Konjungsi Jam 18.00
	// End If
	$tglHijriyahX=$secValue/(24*3600) +1 ;
	$firstSecond=$secValue - floor($secValue);
	$pndpt=$pndpt=6+3.937421296;;  //Konjungsi jam 14:00
	$reqDegree=2;

	if ($firstSecond>$pndpt*3600) { //konjungsi sesudah jam 14:00
		$tglHijriyah=floor($tglHijriyahX);
	
		// if (((int) substr($jam,0,2) + (float) substr($jam,0,2)/60) >18.00 ) {
		if ($tglHijriyah==30) {
			$tglHijriyah=1;
			$blnHijriyah+=1;
			if ($blnHijriyah==13) {
				$blnHijriyah=1;
				$thnHijriyah+=1;
			} 		
		} else {
			$tglHijriyah+=1;
			// echo "tgl Hijriyah = " . $tglHijriyah;
		}
		// // If vDegAbs > vSyDeg And vDegAbs <= vSyDeg + 12 Then
		// // tgl_h = 1
		// // bulan = bulan + 1
		// // If bulan = 13 Then bulan = 1: tahun = tahun + 1
		// // End If
		// 	if ($degAbs>$reqDegree && $degAbs <= $reqDegree + 12) {
		// 		$tglHijriyah=1;
		// 		$blnHijriyah+=1;
		// 		if ($blnHijriyah==13) {
		// 			$blnHijriyah=1;
		// 			$thnHijriyah+=1;
		// 		}
		// 	}	
		// }
	} else {
		if ($tglHijriyahX==0) {
			$tglHijriyah=30;
			if ($blnHijriyah==1) {
				$thnHijriyah-=1;
				$blnHijriyah=12;
			} 
			// else {
			// 	$blnHijriyah-=1;
			// }
		} else {
			$tglHijriyah=floor($tglHijriyahX);
		}
		// if (((int) substr($jam,0,2) + (float) substr($jam,0,2)/60) >18.00 ) {
		// 	if ($tglHijriyah==30) {
		// 		$tglHijriyah=1;
		// 		$blnHijriyah+=1;
		// 		if ($blnHijriyah==13) {
		// 			$blnHijriyah=1;
		// 			$thnHijriyah+=1;
		// 		}
		// 	}
		// }
	}
	$bulanHijriyah=array("Jumadil 'Awal","Jumadil 'Akhir","Rajab","Sya'ban","Ramadhan","Syawal","Zulqa'dah","Zulhijjah","Muharam","Shafar","Robiul 'Awwal","Robiul 'Akhir");
   
    if ($thnHijriyah>=1) {
    	$textTglHijriyah= floor($tglHijriyahX) . " " . $bulanHijriyah[$blnHijriyah] . " " . floor($thnHijriyah) . " H";
		$tglHijriyah=$tglHijriyahX;
		$thnJawa=floor($thnHijriyah) + 512 . " Jawa";
    } else {
    	$textTglHijriyah= floor($tglHijriyah) . " " . $bulanHijriyah[$blnHijriyah] . " " . abs(floor($thnHijriyah)-1) . " SH";
		$thnJawa= abs(floor($thnHijriyah)-1) + 512 . " Jawa";
    }

    if ($degree>=354) {
		$txtDegree=$txtDegreeMin;
	}

    $tglHijriyahArr[0]=$textTglHijriyah;
    $tglHijriyahArr[1]=$txtDegree;
	$tglHijriyahArr[2]=floor($tglHijriyah);
	$tglHijriyahArr[3]=$blnHijriyah;
	$tglHijriyahArr[4]=$thnJawa;
	// $tglHijriyahArr[2]=$txtDegreeMin;
	return $tglHijriyahArr;
}
?>