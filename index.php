
<!DOCTYPE html>
<html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Penanggalan</title>
  <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'> 
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- link rel="stylesheet" href="/resources/demos/style.css" -->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link href="the-datepicker.css" rel="stylesheet" />
  <script src="the-datepicker.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script>
	function copyToClipboard(element) {
	  var $temp = $("<input>");
	  $("body").append($temp);
	  $temp.val($(element).text()).select();
	  document.execCommand("copy");
	  $temp.remove();
	}
  </script>
 
</head>
<body>
	<style type="text/css">
		h2 {
		  font-size: 15px;
		}
		<style>
      .blink {
        animation: blinker 0.6s linear infinite;
        color: #1c87c9;
        font-size: 30px;
        font-weight: bold;
        font-family: sans-serif;
      }
      @keyframes blinker {
        50% {
          opacity: 0;
        }
      }
      .blink-one {
        animation: blinker-one 1s linear infinite;
      }
      @keyframes blinker-one {
        0% {
          opacity: 0;
        }
      }
      .blink-two {
        animation: blinker-two 1.4s linear infinite;
      }
      @keyframes blinker-two {
        100% {
          opacity: 0;
        }
      }
    </style>
	</style>
	<?php
 		include "php/connection.php";
		include 'php/datevalue.php';
		include 'php/dvinyear.php';
		include 'php/hijriyah.php';
		include 'php/tglJawa.php';
		include 'php/hari.php';
		include 'php/pasaran.php';
		include 'php/wuku.php';
		include 'php/padewan.php';
		include 'php/sadwara.php';
		include 'php/sangawara.php';
		include 'php/pranatamangsa.php';
		include 'php/wayah.php';
		include 'php/umur.php';
		include 'php/tglCina.php';
		include 'php/tglIbrani.php';
		include 'php/shio.php';
		include 'php/zodiac.php';
		include 'php/geoData.php';
		//created on January 2021
		date_default_timezone_set("Asia/Bangkok");
		
		if(!isset($_GET['jam'])) {
			$jam=date('H:i:s');
		} else {
		    $jam=$_GET['jam'];
		    if (strlen($jam)==0) {
		        $jam=date('H:i:s');
		    }
		}	 
	
	
		//echo date_default_timezone_get();

	?>
	<form  method="get">
		<table>
			<tr><td align='left'>Ubah Tanggal </td><td>:</td>
				<td align='left'><input type="date" id="birthdate" name="birthdate"></td>
				<td align='center'>
					<select id="operator" name="operator"> 
						<option value="-">-</option>
						<option value="+">+</option>
				 	</select>
				</td>
				<td align='left'><input type="text" id="add_time" name="add_time" size="5" placeholder="0"> </td>
				<td align='center'>
					<select id="unit" name="unit"> 
						<option value="">Tahun</option>
						<option value="month">Bulan</option>
						<option value="day">Hari</option>
					</select>
				</td>
			</tr>
			<tr><td align='left'>Jam          </td><td>:</td>
				<td align='left'><input type="text" name="jam" id="jam" value="<?= $jam ?>"></th>
                <td><button id="btnClear" type="button" value="enter" onclick="clearJam();">x</button>  </td>
			</tr>
		</table>	
		<button  type="submit" value="Submit">Submit</button> <br><br>
	</form>
	
	<?php 
		if (isset($_GET['operator'])) {
		    $opr=$_GET['operator'];
    		$add_time=$_GET['add_time'];
    	
		}
	    if (!isset($_GET['unit'])) {
			$unit="year";
		} else {
		    $unit=$_GET['unit'];
		}
    	
    
	if (isset($_GET['birthdate'])) {
	   // echo "masuk pak eko";
		$tanggal=$_GET['birthdate'];
	
		if ($tanggal==null) {  
			$tanggal=date('Y-m-d');
		}	
// 		echo  $tanggal . "\n";
	} else {
		if ($tanggal==null) {  
			$tanggal=date('Y-m-d');
		}	
	}
// 		echo "tanggal= " . $tanggal;
		//$addTime=$_GET['operator'];
		//echo "Add Time =" . $_GET['add_time'];
		if (isset($_GET['add_time'])) {
			$unit=$_GET['unit'];
			if ($unit == null) $unit="year";
			
			//echo "Masuk = " . $addTime;
			$addTime = $_GET['add_time'];
			if (strlen($addTime)!=0) {
			 //   echo "masuk addtime = " . $addTime;
			   $addTime=$_GET['operator'] . $_GET['add_time'] . $unit;
			   $tanggal=date('Y-m-d', strtotime($tanggal . $addTime));
			}
			
			//$jam=$_GET['jam'];
		} 
		//$jm=substr($jam,0);
		$wayah=wayah($jam);			
		//echo "=======" . $jam . "=======" . wayah($jm);
		
// 		echo $tanggal;
		$thn= substr($tanggal,0,4);
		$bln= substr($tanggal,5,2);
		$tgl= substr($tanggal,8);
		$vtgl= $tgl . "/" . $bln . "/" . $thn;
// 		echo $vtgl;
		$DV=DateValue($vtgl);
		// echo "Date Value= " . $DV;
		$bulan=array("Januari","Pebruari","Maret","April", "Mei", "Juni", "Juli", "Agustus","September","Oktober","Nopember","Desember");
		$vtanggal= $tgl . " " . $bulan[(int)$bln-1] . " " . $thn;
		
  		
		//echo var_dump($hariArr);
		$timeInFloat=(float) substr($jam, 0,2) + ((float) substr($jam, 3,2))/60 + ((float) substr($jam, 5))/3600;
		
		$malam="";
		if ($timeInFloat>18.00) {
			$tglHijriyahArr=tglHijriyah($DV, "18:01:00");
			$pssBulan=$tglHijriyahArr[1];
			// $pssBulan=$tglHijriyahArr[1] . "/" . $tglHijriyahArr[2];
			$DV+=1;
			$malam="Malam";
			$tglJawaArr=tglJawa($DV, "18:01:00");
			$tglJawa=$tglJawaArr[0];
			$pssBulanFloat=$tglHijriyahArr[5];
			if (substr($tglHijriyahArr[0],0,2)=="29" && $pssBulanFloat<2) {
				$tglHijriyahArr= "30 " . substr($tglHijriyahArr,3);
			} else {
				$tglHijriyahArr=tglHijriyah($DV, "18:01:00");
				$tglHijriyah=$tglHijriyahArr[0];
			}
			
			
			
		} else {
			$tglHijriyahArr=tglHijriyah($DV, $jam);
			$pssBulan=$tglHijriyahArr[1] ;
			// $pssBulan=$tglHijriyahArr[1]  . "/" . $tglHijriyahArr[2];
			$tglHijriyah=$tglHijriyahArr[0];
			$tglJawaArr=tglJawa($DV, $jam);
			$tglJawa=$tglJawaArr[0];
			
			if ($timeInFloat<3.00) {
				$malam="Malam";
			}
		}
		// echo "Date Valu= " . $DV;
		// $tglHijriyahArr=tglHijriyah($DV);
		// 	$pssBulan=$tglHijriyahArr[1];
		// 	$tglHijriyah=$tglHijriyahArr[0];
		// 	$tglJawaArr=tglJawa($DV);
		// 	$tglJawa=$tglJawaArr[0];
			

		if (substr($tglHijriyah,0,1)==0) {
			$tglHijriyahArr=tglHijriyah($DV-1, $jam);
			$tglHijriyah=$tglHijriyahArr[0];
			$tglHijriyah=substr($tglHijriyah,0,2)+1 . substr($tglHijriyah,2);
		}

		$hariArr= hari($DV);
		//$sprt=strpos($arr_hari,":");
		//$hari_psrn=substr($arr_hari,0,$sprt);
		$hariPsrn=$malam . " " . $hariArr[0];
		//$neptu=	substr($arr_hari,$sprt+1);
		$neptu=$hariArr[1];
		$hariPsrnJawa=$malam . " " . $hariArr[2];
		$wuku=wuku($DV);
		$padewan=padewan($DV);
		$sadwara=sadwara($DV);
		$sangawara=sangawara($DV);
		
		
		$zodiac=zodiac($vtgl);
		//$arrTglJawa= tglJawa($DV);
		//echo $arrTglJawa;
		//$sprt=strpos($arrTglJawa,":");
		//$tglJawa=substr($arrTglJawa,0,$sprt);
		//$namaThnJawa=substr($arrTglJawa,$sprt+1);
  		$pmArr=pranataMangsa($vtgl);
		$tanggalPM=$pmArr[0];
		$pmValue=$pmArr[1];
		$tglCina=tglCina($DV, $thn);
		// $tglCina=$tglCinaArr[0];
		// $blnCina=$tglCinaArr[3];
		// $tglCina.= " " . $blnCina;
  		$shio=shio($vtgl);
  	    $tglIbrani= tglIbrani($DV,$thn);
		// echo "Tgl Ibrani =" . $tglIbrani;
  		  		
  		$blnKawi=bulanKawi($vtgl);
  		$namaThnJawa=$tglJawaArr[1];
  		
  		$thnJawa=(int) substr($tglJawa,strlen($tglJawa)-9,4);
		$umur=umur($tanggal);
  		//echo $thnJawa . "   " . $tglJawa;
  		if ($thnJawa<1555) {
  			$tglJawa=$tglJawa . " " . "<span class='blink' style='color:red'>(hanya valid untuk >1555 Tahun Jawa)</span>";
  		}
  		//{
  		// 	$thnJawa= (int) substr($tglHijriyahArr[0],strlen($tglHijriyahArr[0])-4)+512;
  		// 	$tglJawa=substr($tglHijriyahArr[0],0,strlen($tglHijriyahArr[0])-4) . $thnJawa;
  		// }
 
		echo "<table id='calTable'>";
		echo "<tr> <td align='left'>Tanggal        				</td><td>:</td><td align='left'>$vtanggal</td></tr>";
		echo "<tr> <td align='left'>Tabuh        				</td><td>:</td><td align='left'>$jam</td></tr>";
		echo "<tr> <td align='left'>Umur        				</td><td>:</td><td align='left'>$umur</td></tr>";
		echo "<tr> <td align='left'>Wayah        				</td><td>:</td><td align='left'>$wayah</td></tr>";
		echo "<tr> <td align='left'>Hari & Pasaran 				</td><td>:</td><td align='left'>$hariPsrn</td></tr>";
		echo "<tr> <td align='left'>Hari & Pasaran (Kawi)		</td><td>:</td><td align='left'>$hariPsrnJawa</td></tr>";	
		echo "<tr> <td align='left'>Neptu          				</td><td>:</td><td align='left'>$neptu</td></tr>";
		echo "<tr> <td align='left'>Sadwara/Paringkelan    		</td><td>:</td><td align='left'>$sadwara</td></tr>";
		echo "<tr> <td align='left'>Hastawara/Padewan    		</td><td>:</td><td align='left'>$padewan</td></tr>";
		echo "<tr> <td align='left'>Sangawara/Padangon    		</td><td>:</td><td align='left'>$sangawara</td></tr>";
		echo "<tr> <td align='left'>Bulan (Kawi)   				</td><td>:</td><td align='left'>$blnKawi</td></tr>";
		echo "<tr> <td align='left'>Tanggal Jawa   				</td><td>:</td><td align='left'>$tglJawa</td></tr>";
		echo "<tr> <td align='left'>Pranata Mangsa   			</td><td>:</td><td align='left'>$tanggalPM</td></tr>";
		echo "<tr> <td align='left'>Wuku           				</td><td>:</td><td align='left'>$wuku</td></tr>";
		echo "<tr> <td align='left'>Tahun/Windu    				</td><td>:</td><td align='left'>$namaThnJawa</td></tr>";	
		echo "<tr> <td align='left'>Tanggal Hijriyah   			</td><td>:</td><td align='left'>$tglHijriyah</td></tr>";
		echo "<tr> <td align='left'>Posisi Bulan   			    </td><td>:</td><td align='left'>$pssBulan</td></tr>";	 	
 	    echo "<tr> <td align='left'>Zodiac         				</td><td>:</td><td align='left'>$zodiac</td></tr>";
		echo "<tr> <td align='left'>Tanggal Ibrani      		</td><td>:</td><td align='left'>$tglIbrani</td></tr>"; 
		echo "<tr> <td align='left'>Tanggal Tionghoa     		</td><td>:</td><td align='left'>$tglCina</td></tr>"; 
 	    echo "<tr> <td align='left'>Shio         				</td><td>:</td><td align='left'>$shio</td></tr>";
		echo "<tr> <td align='left'>PM Value         			</td><td>:</td><td align='left'>$pmValue</td></tr>";

 	    //echo "<tr> <td align='left'>Sumber         				</td><td>:</td><td align='left'>$sumber</td></tr>";
 	    echo "</table>";

 	    $calender= $vtgl . "; Tabuh: " . $jam . "; Wayah " . $wayah ."; " . $hariPsrn . "/" . $hariPsrnJawa . "; Neptu: " . $neptu . "; Sadwara/Paringkelan: " . $sadwara . "; Hastawara/Padewan: " . $padewan . "; Sangawara/Padangon: " . $sangawara . "; Bulan (Kawi): " . $blnKawi . "; " . $tglJawa . "; Pranata Mangsa: " . $tanggalPM . "; Wuku: " . $wuku . "; Tahun/Windu: " . $namaThnJawa . "; " . $tglHijriyah . "; Posisi Bulan: " . $pssBulan . "; Zodiac: " . $zodiac . "; Shio: " . $shio; 
 	    //$cal="; sumber: <a href='http://src.great-site.net/pngl/pngl.php'>http://src.great-site.net/pngl/pngl.php";
 	    //$cal="; sumber: <a href='http://src.infinityfreeapp.com/pngl/pngl.php'>http://src.infinityfreeapp.com/pngl/pngl.php";
 	    $sumber="; sumber: <a href='http://src.great-site.net/pngl/pngl.php'>http://src.great-site.net/pngl/pngl.php";
 	    $calender .= $sumber;
 	    echo "<p hidden id='p1'>" . $calender . "<a></p>";
 	    
 	    //echo "<p id='copy'> . $vtgl . "; Tabuh: " . $jam . "; Wayah " . $wayah ."; " . $hariPsrn . "/" . $hariPsrnJawa . "; Neptu: " . $neptu . "; Bulan (Kawi): " . $blnKawi . "; " . $tglJawa . "; Pranata Mangsa: " . $PM . "; Wuku: " . $wuku . "; Tahun/Windu: " . $namaThnJawa . "; " . $tglHijriyah . "; Posisi Bulan: " . $pssBulan . "; Zodiac: " . $zodiac . "; Shio: " . $shio . "; sumber: <a href='http://src.great-site.net/pngl/pngl.php'>http://src.great-site.net/pngl/pngl.php" . "</p>";
 	    
 	    

 	    $now=date('d-m-Y H:i:s ');
 	    $clientIP=get_client_ip();


 	    //$clientIP="103.119.141.19"; //"114.142.170.35";
 	    $geoDataArr=geoData($clientIP);
		$clientIpAddress="" . $now . " " . $clientIP . "  " . $vtgl . "    ";
		$location="";
		for ($i=0; $i<5; $i++) {
			if ($i==0) {
			  $clientIpAddress .= $geoDataArr[$i];
			  $location .= $geoDataArr[$i];
			} else {
			  $clientIpAddress .= ", " . $geoDataArr[$i];
			  $location .="  " .  $geoDataArr[$i];
			}
		  }
		  $insert="insert into application_access (APPLICATION_NAME, ACCESS_DATE, LOCATION, IP_ADDRESS, TO_FIND) values " .
		  "('http://src.great-site.net/pngl','$now','$location','$clientIP','$hariPsrn $vtanggal $jam ')";
		//   // echo $insert;
		  $conn->query($insert);  
		  $conn->close();



		// $clientIpAddress .= ", pngl.php\r\n";
		// //echo "Client Address= " . $clientIpAddress;
		// $myIPsFile = fopen("client_access.log", "a") or die("Unable to open file!");
		// 	fwrite($myIPsFile, $clientIpAddress);
		// fclose($myIPsFile);


		// $myIPsFile="client_access.log";
		// $clientAccessData= sprintf("%s\n%s\n%s\n", $clientIpAddress);
		// file_put_contents($myIPsFile, $clientAccessData, FILE_APPEND);
		//echo $clientIpAddress;
		//<?=$calender
		//<p id="p1"> tttttttt </p>
	?>  
	
	<button onclick="copyToClipboard('#p1')"><img src="https://img.icons8.com/plasticine/50/000000/copy.png"/></button>
	<!-- <button onclick="copyToClipboard('#calTable')"><img src="https://img.icons8.com/plasticine/50/000000/copy.png"/></button> -->
	<!-- <img src="https://img.icons8.com/plasticine/100/000000/copy.png"/> -->
	<!-- <p>Date Value: <?php echo DateValue($vtgl); ?> </p> -->
	 <script>
	  $( function() {
	    $( "#datepicker" ).datepicker();
	  } );

	//   function clickCounter() {
	//   if (typeof(Storage) !== "undefined") {
	//     if (sessionStorage.clickcount) {
	//       sessionStorage.clickcount = Number(sessionStorage.clickcount)+1;
	//     } else {
	//       sessionStorage.clickcount = 1;
	//     }
	//     document.getElementById("result").innerHTML = "You have clicked the button " + sessionStorage.clickcount + " time(s) in this session.";
	//   } else {
	//     document.getElementById("result").innerHTML = "Sorry, your browser does not support web storage...";
	//   }  
	// }
        function clearJam(){
			// alert("The button was pressed");
			document.getElementById('jam').value = "";
			// document.getElementById('okemview').innerHTML = "";
            // alert("clear");
		};   
	</script>
	<!--
	<p><button onclick="clickCounter()" type="button">Click me!</button></p>
	<div id="result"></div>
	<p>Click the button to see the counter increase.</p>
	<p>Close the browser tab (or window), and try again, and the counter is reset.</p> -->


	<div>
		<p style="font-size:75%;"> <br><br><br><br><br><br>by Imam Subarkah in January 2021</p>
	</div>


<?php
        


function tglTahunJawaKabisat($kabisat, $bulan) {
	If ($bulan >= 0 && $bulan < 30) {
		$namaBulan = "Suro";
		$tgl = $bulan + 1;
	}
	$bulan -=30;
	If ($bulan >= 0 && $bulan < 29) {
		$namaBulan = "Sapar";
		$tgl = $bulan + 1;
	}
	$bulan -=29;
	If ($bulan >= 0 && $bulan < 30) {
		$namaBulan = "Mulud";
		$tgl = $bulan + 1;
	}
	$bulan -=30;
	If ($bulan >= 0 && $bulan < 29) {
		$namaBulan = "Bakda Mulud";
		$tgl = $bulan + 1;
	}
	$bulan -=29;
	If ($bulan >= 0 && $bulan < 30) {
		$namaBulan = "Jumadilawal";
		$tgl = $bulan + 1;
	}
	$bulan -=30;
	If ($bulan >= 0 && $bulan < 29) {
		$namaBulan = "Jumadilakir";
		$tgl = $bulan + 1;
	}
	$bulan -=29;
	If ($bulan >= 0 && $bulan < 30) {
		$namaBulan = "Rejeb";
		$tgl = $bulan + 1;
	}
	$bulan -=30;
	If ($bulan >= 0 && $bulan < 29) {
		$namaBulan = "Ruwah";
		$tgl = $bulan + 1;
	}
	$bulan -=29;
	If ($bulan >= 0 && $bulan < 30) {
		$namaBulan = "Pasa";
		$tgl = $bulan + 1;
	}
	$bulan -=30;
	If ($bulan >= 0 && $bulan < 29) {
		$namaBulan = "Sawal";
		$tgl = $bulan + 1;
	}
	$bulan -=29;
	If ($bulan >= 0 && $bulan < 30) {
		$namaBulan = "Dulkangidah";
		$tgl = $bulan + 1;
	}
	$bulan -=30;
	
	if ($kabisat==true) {
		If ($bulan >= 0 && $bulan < 30) {
			$namaBulan = "Besar";
			$tgl = $bulan + 1;
		} 
	} else {
		If ($bulan >= 0 && $bulan < 29) {
			$namaBulan = "Besar";
			$tgl = $bulan + 1;
		}
	}
	return $tgl . " " . $namaBulan;
	

}




function get_IP_addressX()
{
    foreach (array('HTTP_CLIENT_IP',
                   'HTTP_X_FORWARDED_FOR',
                   'HTTP_X_FORWARDED',
                   'HTTP_X_CLUSTER_CLIENT_IP',
                   'HTTP_FORWARDED_FOR',
                   'HTTP_FORWARDED',
                   'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $IPaddress){
                $IPaddress = trim($IPaddress); // Just to be safe

                if (filter_var($IPaddress,
                               FILTER_VALIDATE_IP,
                               FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)
                    !== false) {

                    return $IPaddress;
                }
            }
        }
    }
}

// function get_IP_address() {
// 	$ipaddress = '';
//     if ($_SERVER['HTTP_CLIENT_IP'] != '127.0.0.1')
//         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
//     else if ($_SERVER['HTTP_X_FORWARDED_FOR'] != '127.0.0.1')
//         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
//     else if ($_SERVER['HTTP_X_FORWARDED'] != '127.0.0.1')
//         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
//     else if ($_SERVER['HTTP_FORWARDED_FOR'] != '127.0.0.1')
//         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
//     else if ($_SERVER['HTTP_FORWARDED'] != '127.0.0.1')
//         $ipaddress = $_SERVER['HTTP_FORWARDED'];
//     else if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1')
//         $ipaddress = $_SERVER['REMOTE_ADDR'];
//     else
//         $ipaddress = 'UNKNOWN';
//     return $ipaddress
// }
function bulanKawi($tanggal) {
	$bln= substr($tanggal,3,2);
	$bln=(int)$bln-1;
	//echo $bln;
	$bulanKawi=array("Wadana","Wijangga","Wiyana","Widada","Widarpa","Wilapa","Wahana","Wanana","Wurana","Wujana","Wujala","Warana");
	
	return $bulanKawi[$bln];
}

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    
    return $ipaddress . "\n";
}



?>

</body>
</html>
