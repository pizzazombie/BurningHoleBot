<?php
/*подключение к базе данных*/

$host = "localhost"; // в 90% случаев это менять не надо
$password = "l23456789";
$username = "u1049343_orden";
$databasename = "u1049343_orden";

global $db;
$db = mysqli_connect($host,$username,$password) or die("error: Failed_connect_database");

mysqli_select_db($db, $databasename) or die("error:Database not selected witch mysql_select_db");

mysqli_query($db, 'SET NAMES utf8');
mysqli_query($db, 'SET CHARACTER SET utf8' );
mysqli_query($db, 'SET COLLATION_CONNECTION="utf8_general_ci"'); 
setlocale(LC_ALL,"ru_RU.UTF8");