<?php
$con = new mysqli('localhost', 'root', '', 'ventas');

$query = "select pxq from ingreso where coddesp not in (18, 22) and fectrantsl =20160601";

$res = $con->query($query);

$sum = 0;

while($row = mysqli_fetch_assoc($res)){
    $sum += $row['pxq'];
}

echo $sum;