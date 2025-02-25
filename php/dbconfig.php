<?php
try{
$servername = "127.0.0.1"; //localhost at port 8889
$usernamesql = "root";
$passwordsql = "root";
$dbname = "geotracer";
$con = mysqli_connect($servername, $usernamesql ,$passwordsql ,$dbname);

//Check connection 
if(!$con)
{
   echo "Connect failed: " . mysqli_connect_error();
}
echo "connected succesfully!";
}catch(Exception $e){
echo $e->getMessage();
}
?>