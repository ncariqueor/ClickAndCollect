<?php
ini_set("max_execution_time", 0);

$fechainicio = $_GET['fechainicio'];

$fechafin    = $_GET['fechafin'];

$local = new mysqli('localhost', 'root', '', 'ventas');

$query = "select fectrantsl, numorden, codsku, tienda, canvend, pxq, cosprom, coddesp, depto1 from ingreso where fectrantsl between $fechafin and $fechainicio";

$res = $local->query($query);

$array = array();

$i = 0 ;

while($row = mysqli_fetch_assoc($res)){
    $array[$i][0] = $row['fectrantsl'];
    $array[$i][1] = $row['numorden'];
    $array[$i][2] = $row['codsku'];
    $array[$i][3] = $row['tienda'];
    $array[$i][4] = $row['canvend'];
    $array[$i][5] = $row['pxq'];
    $array[$i][6] = $row['cosprom'];
    $array[$i][7] = $row['coddesp'];
    $array[$i][8] = $row['depto1'];
    $i++;
}

$query = "select feceminc, numorden, totvtactdo, tienda, coddesp from ncredito where feceminc between $fechafin and $fechainicio";

$res = $local->query($query);

$array2 = array();

$j = 0;

while($row = mysqli_fetch_assoc($res)){
    $array2[$j][0] = $row['feceminc'];
    $array2[$j][1] = $row['numorden'];
    $array2[$j][2] = $row['totvtactdo'];
    $array2[$j][3] = $row['tienda'];
    $array2[$j][4] = $row['coddesp'];

    $j++;
}

if($j < $i) {
    $linea = array();

    $k = 0;

    for ($l = 0; $l < $i; $l++) {
        $linea[$k] =
            $array[$l][0] . ";" .
            $array[$l][1] . ";" .
            $array[$l][2] . ";" .
            $array[$l][3] . ";" .
            $array[$l][4] . ";" .
            $array[$l][5] . ";" .
            $array[$l][6] . ";" .
            $array[$l][7] . ";" .
            $array[$l][8] . "; ;";

        $k++;
    }

    $m = 0;

    for ($l = 0; $l < $j; $l++) {
        $linea[$m] = $linea[$m] .
            $array2[$l][0] . ";" .
            $array2[$l][1] . ";" .
            $array2[$l][2] . ";" .
            $array2[$l][3] . ";" .
            $array2[$l][4] . ";";

        $m++;
    }
}else{
    $linea = array();

    $k = 0;

    for ($l = 0; $l < $j; $l++) {
        $linea[$k] =
            $array2[$l][0] . ";" .
            $array2[$l][1] . ";" .
            $array2[$l][2] . ";" .
            $array2[$l][3] . ";" .
            $array2[$l][4] . "; ;";

        $k++;
    }

    $m = 0;

    for ($l = 0; $l < $i; $l++) {
        $linea[$m] = $linea[$m] .
            $array[$l][0] . ";" .
            $array[$l][1] . ";" .
            $array[$l][2] . ";" .
            $array[$l][3] . ";" .
            $array[$l][4] . ";" .
            $array[$l][5] . ";" .
            $array[$l][6] . ";" .
            $array[$l][7] . ";" .
            $array[$l][8] . ";";
        $m++;
    }
}

$name = "ClickCollect_" . "entre_" . $fechainicio . "_y_" . $fechafin . ".csv";

header('Content-Type: application/vnd.ms-excel');
header("Content-disposition: attachment; filename=" . $name);

$f = fopen("php://output", "w");
$line = "FECTRANTSL; NUMORDEN; CODSKU; TIENDA; CANVEND; PXQ; COSPROM; CODDESP; DEPTO; ; FECHA NC; NUMORDEN NC ;MONTO NC; TIENDA NC; CODDESP NC;\n";

fwrite($f, $line);

for($i=0; $i<$k; $i++){
    $line = $linea[$i] . "\n";
    fwrite($f, $line);
}

fclose($f);
exit;

