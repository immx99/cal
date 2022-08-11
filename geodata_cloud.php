<?php
function geoData($ipAddress) {
	//$ipAddr=explode("/", $ipAddress);
	$ipAddrArr=explode(".",$ipAddress);
	$ipAddr1=$ipAddrArr[0];
	$ipAddr2=$ipAddrArr[1];
	$ipAddr3=$ipAddrArr[2];
	$ipAddr4=$ipAddrArr[3];
	//$mask=$ipAddr[1];
	
	$city="";  
	$country="";
	$continent="";
	$lattitude="";
	$longitude="";
 	$servername = "sql200.epizy.com";
	$username = "epiz_27683464";
	$password = "dkVDGAYvTRJt";
	$dbname="epiz_27683464_src";

	// $servername = "localhost";
	// $username = "root";
	// $password = "imMx010m";
	// $dbname="src";
	// $conn = new mysqli($servername, $username, $password, $dbname);

	$sql="select gc.network," .
        "gl.city_name,gl.subdivision_1_name,gl.country_name,gl.continent_name,gc.lattitude,gc.longitude " .
        "from geolite2_city_location gl,geolite2_city_blocks_ipv4 gc " .
        "where gc.geoname_id=gl.geoname_id and ".
        "gc.network like '". $ipAddr1 . "." . $ipAddr2 . "." .
        $ipAddr3 . ".%'  and " .
        "convert(substring_index(substring_index(network,'/',1),'.',-1),unsigned)<=" .
        $ipAddr4 . 
        " order by convert(substring_index(substring_index(network,'/',1),'.',-1),unsigned) desc limit 1";
    $sqli="select network," .
        "lattitude,longitude " .
        "from geolite2_city_blocks_ipv4 where network like '". $ipAddr1 . "." . $ipAddr2 . "." .
        $ipAddr3 . "%'  and " .
        "convert(substring_index(substring_index(network,'/',1),'.',-1),unsigned)<=" .
        $ipAddr4 . 
        " order by convert(substring_index(substring_index(network,'/',1),'.',-1),unsigned) desc  limit 1";  
   

    $sql2= "select gc.network,".
        "gl.city_name,gl.country_name,gl.continent_name,gc.lattitude,gc.longitude " .
        "from geolite2_city_location gl,geolite2_city_blocks_ipv4 gc " .
        "where gc.geoname_id=gl.geoname_id and ".
        "gc.network like '". $ipAddr1 . "." . $ipAddr2 .  "%' and " .
        "convert(substring_index(substring_index(substring_index(network,'/',1),'.',-2),'.',1),unsigned)<=" .
        $ipAddr3 . 
        " order by convert(substring_index(substring_index(substring_index(network,'/',1),'.',-2),'.',1),unsigned) desc  limit 1";
    $sql2i="select network,geoname_id," .
        "lattitude,longitude " .
        "from geolite2_city_blocks_ipv4 where network like '". $ipAddr1 . "." . $ipAddr2 .  ".%'  and " .
        "convert(substring_index(substring_index(substring_index(network,'/',1),'.',-2),'.', 1),unsigned)<=" .
        $ipAddr3 . 
        " order by convert(substring_index(substring_index(substring_index(network,'/',1),'.',-2),'.', 1),unsigned) desc ";


    $sql3= "select gc.network,".
        "gl.city_name,gl.country_name,gl.continent_name,gc.lattitude,gc.longitude " .
        "from geolite2_city_location gl,geolite2_city_blocks_ipv4 gc " .
        "where gc.geoname_id=gl.geoname_id and ".
        "gc.network like '". $ipAddr1 . "%' and " .
        "convert(substring_index(substring_index(substring_index(network,'/',1),'.',2),'.',-1),unsigned)<=" .
        $ipAddr2 . 
        " order by convert(substring_index(substring_index(substring_index(network,'/',1),'.',2),'.',-1),unsigned) desc limit 1";
     $sql3i="select network,geoname_id,lattitude,longitude " .   
        "from geolite2_city_blocks_ipv4 where network like '". $ipAddr1 .  ".%'  and " .
        "convert(substring_index(substring_index(substring_index(network,'/',1),'.',2),'.',-1),unsigned)<=" . 
        $ipAddr2 . 
        " order by convert(substring_index(substring_index(substring_index(network,'/',1),'.',2),'.',-1),unsigned) desc "; 
    
    

    if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
	}
	
	$advQuery=false;
	$i=1;
	$ebreak=false;
	while ( strlen(trim($city))<1 && strlen(trim($country))<1  && $i<=3) {
		
		if ($ebreak==true) {
			//echo "BREAK ke dua!!<br>";
			$ebreak=true;
			break;
	    }
	    //echo "sql " . $i . "= " . $sql . "<br>";
		$result = $conn->query($sql);
		//$result = mysqli_query($conn, $sql);
		//$num_rows = mysql_num_rows($result);
		//echo "rows=" . $result->num_rows;
		//echo "rows=" . mysqli_num_rows($result);
		//if (mysqli_num_rows($result) > 0) {
		if ($result->num_rows > 0) {
			if ($sql!=$sql2i && $sql!=$sql3i) { 
				
				while($row = $result->fetch_assoc()) {					
					$qIpAddress=$row["network"];
					$qIpAddr=explode("/", $qIpAddress);
					//echo "ip0= " . $qIpAddr[0] . "<br>";
					$qIpAddrArr=explode(".",$qIpAddr[0]);
					$qIpAddr4=$ipAddrArr[3];
					$diffIpAddrAbs=abs($qIpAddr4-$ipAddr4);
					$provinsi=$row["subdivision_1_name"];
					if (strlen($provinsi) > 0) {
						$city=$row["city_name"] . "/" . $provinsi; 
					} else {
						$city=$row["city_name"];
					}
                	$country=$row["country_name"];         
                	$continent=$row["continent_name"];
                	$lattitude=$row["lattitude"];
                	$longitude=$row["longitude"];
					//}
					$diffIpAddr=$diffIpAddrAbs;
					// echo "city = " . $city . "<br>";
					// echo "country = " . $country . "<br>";
					// echo "continent = " . $continent . "<br>";
					// echo "lattitude = " . $lattitude . "<br>";
					// echo "longitude = " . $longitude . "<br>";
					//echo "len city= " . strlen($city) . "    BREAK!!<br>";

					if ($diffIpAddr==0 || strlen(trim($city))>1 || strlen(trim($country))>1) {
						//echo "BREAK pertama!!<br>";
						$ebreak=true;
						break;
						
					}

				}

			    if (strlen(trim($city))<1 && strlen(trim($country))<1) {
                    if ($advQuery==false) {
                        $sql4=$sql;
                        $advQuery=true;
                        if ($sql==$sql2) {
                            $sql=$sql3;
//                                System.out.println("5, "+ sql);
                        } else {
                            $sql=$sql2;
//                                System.out.println("2, "+ sql);
                           
                        }
                    } 
                }

            } else {
            	
            	$j=1;
            	$qIpAddrArrOld[1]="";
            	$geoname_idOld="";
            	$lattitudeOld="";
            	$longitudeOld="";
            	while($row = $result->fetch_assoc()) {					
					$qIpAddress=$row["network"];
					$qIpAddr=explode("/", $qIpAddress);
					$qIpAddrArr=explode(".",$qIpAddr[0]);
					$geoname_id=$row["geoname_id"];
                    $lattitude=$row["lattitude"];
                    $longitude=$row["longitude"];
                    // echo $qIpAddress . "<br>";
                    // echo $qIpAddrArr[0] . "<br>";
                    // echo $qIpAddrArr[1] . "<br>";
					if ($qIpAddrArr[1]==$qIpAddrArrOld[1]) {
						$sqliii= "select network,geoname_id," .
        						"lattitude,longitude " .
        						"from geolite2_city_blocks_ipv4 " .
        						"where network like '". $qIpAddrArr[0] . "." .  $qIpAddrArr[1] .  ".%'" .
        						" order by convert(substring_index(substring_index(substring_index( network,'/',1),'.',-2),'.', 1),unsigned) desc  limit 1";
        				//echo "sqliii= " . $sqliii . "<br>";
        				$result3 = $conn->query($sqliii);
        				while($row = $result3->fetch_assoc()) {
        					$geoname_id=$row["geoname_id"];
		                    $lattitude=$row["lattitude"];
		                    $longitude=$row["longitude"];	
        				}
        				$ebreak=true;
						break;
					    
	                    
					} else {
						if (strlen($qIpAddrArrOld[2])>0) {
							$geoname_id=$geoname_idOld;	
							$lattitude=$lattitudeOld;
							$longitude=$longitudeOld;
							$ebreak=true;
							break;
					    } 
					    if ($sql==$sql2i) {
					    	break;
					    }

					}


					$qIpAddrArrOld[1]=$qIpAddrArr[1];
					$geoname_idOld=$geoname_id;
					$lattitudeOld=$lattitude;
					$longitudeOld=$longitude;
					$j++;
				}
					$sqlii="select city_name,subdivision_1_name,country_name,continent_name from geolite2_city_location " .
							"where geoname_id='" . $geoname_id . "' limit 1";

				//echo "sqlii= " . $sqlii . "<br>";
				$result2 = $conn->query($sqlii);
				if ($result2->num_rows > 0) {
					while($row = $result2->fetch_assoc()) {	
						$provinsi=$row["subdivision_1_name"];
						if (strlen($provinsi) > 0) {
							$city=$row["city_name"] . "/" . $provinsi; 
						} else {
							$city=$row["city_name"];
						}
						  
		    			$country=$row["country_name"];  
		    			$continent=$row["continent_name"];       
						

					}
				} 
            }
			


		} else {
			//if ($advQuery==false) {
                $sql4=$sql;
                $advQuery=true;
                if ($sql==$sql2i) {
                    $sql=$sql3i;
//                                System.out.println("5, "+ sql);
                } else {
                    $sql=$sql2i;
//                                System.out.println("2, "+ sql);
                   
                }
            //} 
		}
		$i++;
	}

	//echo "sql check= ". $sql . "<br>";
	
	// echo "city= " . $city . "<br>";
	// echo "country= " . $country . "<br>";	
	
	
	// if (strlen(trim($city))>1 || strlen(trim($country))>1) {

	// 	$ebreak=true;
	// 	break;
	// }
				
	$conn->close();
	$geoDataArr[0] =$city;
	$geoDataArr[1] =$country;
	$geoDataArr[2] =$continent;
	$geoDataArr[3] =$lattitude;
	$geoDataArr[4] =$longitude;
	
	return $geoDataArr;
	
	//return $ipAddrArr;
}
?>