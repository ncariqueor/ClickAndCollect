<?php

ini_set("max_execution_time", 0);

header('Content-Type: text/html; charset=utf-8');

$con = new mysqli('localhost', 'root', '', 'ventas');

$query = "select pxq from ingreso where tienda like 'nunoa' and fectrantsl = 20160212";

$res = $con->query($query);

$sum = 0;

while($row = mysqli_fetch_assoc($res)){
    $sum += $row['pxq'];
}

echo $sum;