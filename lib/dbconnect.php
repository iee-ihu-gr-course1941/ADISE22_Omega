<?php
$host="localhost";
$db="pinacle";
$username="root";
$pass="";
$mysqli= mysqli_connect($host,$username,$pass,$db);
mysqli_select_db($mysqli,"pinacle");

    if (!$mysqli){
        echo("<P> CONNECTION FAILED "."DATABASE SERVER IS NOT AVAILABLE </P>");
		header('HTTP/1.1 503 Service Unavailable');
        exit();
    }else{
		print "succefully connected";
	}

if(!mysqli_select_db($mysqli,"pinacle")){
	echo "failed to connect db";
	header('HTTP/1.1 503 Service Unavailable');
	
}else{
	echo "database selected";
	
}
?>

