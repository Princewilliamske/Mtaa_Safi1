<?php
//  Connecting to Database 
$con = mysqli_connect("localhost","root","","mtaa_safi");

if(!$con){
echo "database connection failed";
}
