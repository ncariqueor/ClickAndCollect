<?php
ini_set('max_execution_time', 0);

$con = new mysqli('localhost', 'root', '', 'ventas');

$con2 = new mysqli('localhost', 'root', '', 'clickcollect');

function montoTienda($con, $dia, $tienda){

    $query = "select pxq from ingreso where tienda = '$tienda' and fectrantsl = $dia";

    $res = $con->query($query);

    $sum = 0;

    while($row = mysqli_fetch_assoc($res)){
        $sum += $row['pxq'];
    }

    return $sum;
}

function ordTienda($con, $dia, $tienda){
    $query = "select distinct numorden from ingreso where tienda = '$tienda' and fectrantsl = $dia";

    $res = $con->query($query);

    return mysqli_num_rows($res);
}

function ncreditoTienda($con, $dia, $tienda){
    $query = "select totvtactdo from ncredito where tienda = '$tienda' and feceminc = $dia";

    $res = $con->query($query);

    $sum = 0;

    while($row = mysqli_fetch_assoc($res)){
        $sum += $row['totvtactdo'];
    }

    return $sum;
}

function ordNcredito($con, $dia, $tienda){
    $query = "select numorden from ncredito where tienda = '$tienda' and feceminc = $dia";

    $res = $con->query($query);

    return mysqli_num_rows($res);
}

function costo($con, $dia, $tienda){
    $conexion = odbc_connect('CECEBUGD', 'USRVNP', 'USRVNP');

    $query = "select codsku, canvend from ingreso where tienda = '$tienda' and fectrantsl = $dia";

    $res = $con->query($query);

    $cant = mysqli_num_rows($res);

    $buscar = "(";

    $i = 0;
    $sum = 0;
    while($row = mysqli_fetch_assoc($res)){
        $codsku = $row['codsku'];
        $codsku = str_split($codsku);
        $codsku = $codsku[0] . $codsku[1] . $codsku[2] . $codsku[3] . $codsku[4] . $codsku[5];
        $canvend = $row['canvend'];

        $query = "select EXKPF01.COSPROM from rdbparis2.exgcbugd.EXKPF01 EXKPF01 where EXKPF01.ESTILO = '$codsku'";

        $result = odbc_exec($conexion, $query);

        $i = 0;
        while(odbc_fetch_row($result)){
            $i = odbc_result($result, 1)*$canvend;
        }

        $sum += $i;

        /*$buscar = $buscar . "'" . $codsku . "'";

        if($i < $cant - 1)
            $buscar = $buscar . ",<br>";

        $i++;*/
    }

    $buscar = $buscar . ")";

    return $sum;


}



function montoInternet($con, $dia){
    $query = "select pxq from ingreso where coddesp not in (18, 22) and fectrantsl = $dia";

    $res = $con->query($query);

    $sum = 0;

    while($row = mysqli_fetch_assoc($res)){
        $sum += $row['pxq'];
    }

    return $sum;
}

function ordInternet($con, $dia){
    $query = "select distinct numorden from ingreso where coddesp not in (18, 22) and fectrantsl = $dia";

    $res = $con->query($query);

    return mysqli_num_rows($res);
}

function ncreditoInternet($con, $dia){
    $query = "select totvtactdo from ncredito where tienda = '' and feceminc = $dia";

    $res = $con->query($query);

    $sum = 0;

    while($row = mysqli_fetch_assoc($res)){
        $sum += $row['totvtactdo'];
    }

    return $sum;
}

function ordNcreditoI($con, $dia){
    $query = "select numorden from ncredito where tienda = '' and feceminc = $dia";

    $res = $con->query($query);

    return mysqli_num_rows($res);
}

function costoI($con, $dia){
    $conexion = odbc_connect('CECEBUGD', 'USRVNP', 'USRVNP');

    $query = "select codsku, canvend from ingreso where coddesp not in (18, 22) and fectrantsl = $dia";

    $res = $con->query($query);

    $sum = 0;
    while($row = mysqli_fetch_assoc($res)){
        $codsku = $row['codsku'];
        $codsku = str_split($codsku);
        $codsku = $codsku[0] . $codsku[1] . $codsku[2] . $codsku[3] . $codsku[4] . $codsku[5];
        $canvend = $row['canvend'];

        $query = "select EXKPF01.COSPROM from rdbparis2.exgcbugd.EXKPF01 EXKPF01 where EXKPF01.ESTILO = '$codsku'";

        $result = odbc_exec($conexion, $query);

        $i = 0;
        while(odbc_fetch_row($result)){
            $i = odbc_result($result, 1)*$canvend;
        }

        $sum += $i;
    }

    return $sum;
}

$query ="select tipo, tienda2 from tiendas";

$res = $con2->query($query);

$i = 0;

$tienda[] = array();
$tipo[] = array();

while($row = mysqli_fetch_assoc($res)){
    $tienda[$i] = $row['tienda2'];
    $tipo[$i] = $row['tipo'];
    $i++;
}

$cant = count($tienda);

for($dia = new DateTime (20161110); $dia->format("Ymd") >= 20161101; $dia->modify("-1 day")){
    $fecha = $dia->format("Ymd");
    for($i=0; $i<$cant; $i++){
        $type= $tipo[$i];
        $ingresobruto = montoTienda($con, $fecha, $tienda[$i]);
        $ordingresobruto = ordTienda($con, $fecha, $tienda[$i]);
        $ncredito     = ncreditoTienda($con, $fecha, $tienda[$i]);
        $ordncredito = ordNcredito($con, $fecha, $tienda[$i]);
        $costo      =  costo($con, $fecha, $tienda[$i]);

        $con2->query("delete from montos where fecha = $fecha and tienda = '" . $tienda[$i] . "'");

        $insertar = "insert into montos values('$type','" . $tienda[$i] . "', $fecha, $ingresobruto, $ordingresobruto, $ncredito, $ordncredito, $costo)";

        $res = $con2->query($insertar);

        if($res)
            echo $tienda[$i] . " - " . $fecha . "<br>";
        else
            echo $con2->error;
    }
    /*$ingresobruto = montoInternet($con, $fecha);
    $ordingresobruto = ordInternet($con, $fecha);
    $ncredito     = ncreditoInternet($con, $fecha);
    $ordncredito = ordNcreditoI($con, $fecha);
    $costo      =  costoI($con, $fecha);

    $con2->query("delete from montos where fecha = $fecha and tienda = 'PARIS INTERNET'");

    $insertar = "insert into montos values('Paris','PARIS INTERNET', $fecha, $ingresobruto, $ordingresobruto, $ncredito, $ordncredito, $costo)";

    $res = $con2->query($insertar);

    if($res)
        echo "Paris Internet - " . $fecha . "<br>";
    else
        echo $con2->error;*/

}
