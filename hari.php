<?php
function hari($DV) {
	$nH=($DV-1)%7;
	//echo "first: $n, second: $DV \n";

	$hari=array("Sabtu","Ahad","Senin","Selasa","Rabu","Kamis","Jumat");
	$hariKawi=array("Tumpak","Radite","Soma","Hanggara","Budha","Respati","Sukra");
	$neptuHari=array(9,5,4,3,7,8,6);

    $nP=($DV-1)%5;
	//echo "first: $n, second: $DV \n";
	$pasaran=array("Kliwon","Legi","Pahing","Pon","Wage");
	$pasaranKawi=array("Kasih","Manis","Abritan","Jenar","Cemengan");
	$neptuPasaran=array(8,5,9,7,4);
	$neptu=$neptuHari[$nH] + $neptuPasaran[$nP];
	//$hariArr = $hari . " " . $pasaran . ":" . $neptu_hari . " + " . $neptu_pasaran . " = " . $neptu;
	$hariArr[0]=$hari[$nH] . " " . $pasaran[$nP];
	$hariArr[1]= $neptuHari[$nH] . " + " . $neptuPasaran[$nP] . " = " . $neptu;
	$hariArr[2]= $hariKawi[$nH] . " " . $pasaranKawi[$nP];
    //echo "Hari = " . "$hari \n";
    //echo $hari . " " . $pasaran;
    return $hariArr;
    //return $hari;
}

?>
