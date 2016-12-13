<!DOCTYPE html>
<html lang="es">
<head>
    <title>Performance Click & Collect</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <link rel="stylesheet" type="text/css" href="bootstrap-3.3.6-dist/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="bootstrap-select-1.9.4/dist/css/bootstrap-select.css"/>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-88784345-1', 'auto');
        ga('send', 'pageview');

    </script>
</head>

<body onload="asignar(); ocultar();">
<script>
    var int=self.setInterval("refresh()",1000);
    function refresh()
    {
        fecha = new Date();
        if((fecha.getMinutes() == 10 && fecha.getSeconds() == 0) || (fecha.getMinutes() == 40 && fecha.getSeconds() == 0))
            location.reload(true);
    }
</script>

<script>
    function asignar(){
        var month = document.getElementById("mes").value;
        var year = document.getElementById("anio").value;
        var day = document.getElementById("dia").value;

        var monthpast = document.getElementById("mesant").value;
        var yearpast = document.getElementById("anioant").value;
        var daypast = document.getElementById("diaant").value;

        var tienda = document.getElementById("tienda").value;

        var tipo = document.getElementById("tipo").value;

        fechainicio = yearpast + monthpast + daypast;

        fechafin    = year + month + day;

        if(tipo == 'fecha')
            document.getElementById("exportar").href = tipo+".php?mes="+month+"&anio="+year+"&dia="+day+"&mesant="+monthpast+"&anioant="+yearpast+"&diaant="+daypast;

        if(tipo == 'tienda')
            document.getElementById("exportar").href = tipo+".php?mes="+month+"&anio="+year+"&tienda="+tienda;

        document.getElementById("exportarbase").href = "export_base.php?fechainicio="+fechainicio+"&fechafin="+fechafin;
    }
</script>

<header class="container">
    <nav class="navbar navbar-default">
        <div class="btn-group-sm">
            <div class="row">
                <div class="col-md-12"><h3 class="text-center"><a href="http://10.95.17.114/paneles"><img src="ParisTiendaLogo_03.jpg" width="65px" title="Reportes Paris"></a> Performance Click & Collect por Tienda</h3></div>
            </div>

            <div class="row">
                <div class="col-md-12"><h5 class="text-center text-success">Última actualización a las <?php
                        $con = new mysqli('localhost', 'root', '', 'ventas');
                        $query = "select hora from actualizar";
                        $res = $con->query($query);
                        $hour = 0;
                        while($row = mysqli_fetch_assoc($res)){
                            $h = $row['hora'];

                            if(strlen($row['hora']) == 1)
                                $h = "00000" . $h;

                            if(strlen($row['hora']) == 2)
                                $h = "0000" . $h;

                            if(strlen($row['hora']) == 3)
                                $h = "000" . $h;

                            if(strlen($row['hora']) == 4)
                                $h = "00" . $h;

                            if(strlen($row['hora']) == 5)
                                $h = "0" . $row['hora'];

                            $h = new DateTime($h);
                        }
                        echo $h->format("H:i") . " horas.";
                        ?></h5></div>
            </div><br>

            <form action="click_tiendas.php" method="post" class="row">

                <div class="col-lg-2 col-sm-4">
                    <div class="dropdown">
                        <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Tipo Panel
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="http://10.95.17.114/clickcollect/clickandcollect.php">Por Fecha / Todas las Tiendas</a></li>
                            <li><a href="http://10.95.17.114/clickcollect/click_tiendas.php">Por Tienda / Mes Completo</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <select name="mes" id="mes" class="btn btn-default btn-sm" title="Mes" data-style="btn btn-default btn-sm" data-width="100px" onchange="asignar();">
                        <?php
                        if(isset($_POST['mes'])){
                            $mes = $_POST['mes'];
                            if($mes == '01') {
                                echo "<option value='01' selected='selected'>Enero</option>";
                                echo "<option value='02'>Febrero</option>";
                                echo "<option value='03'>Marzo</option>";
                                echo "<option value='04'>Abril</option>";
                                echo "<option value='05'>Mayo</option>";
                                echo "<option value='06'>Junio</option>";
                                echo "<option value='07'>Julio</option>";
                                echo "<option value='08'>Agosto</option>";
                                echo "<option value='09'>Septiembre</option>";
                                echo "<option value='10'>Octubre</option>";
                                echo "<option value='11'>Noviembre</option>";
                                echo "<option value='12'>Diciembre</option>";
                            }else{
                                if($mes == '02'){
                                    echo "<option value='01'>Enero</option>";
                                    echo "<option value='02' selected='selected'>Febrero</option>";
                                    echo "<option value='03'>Marzo</option>";
                                    echo "<option value='04'>Abril</option>";
                                    echo "<option value='05'>Mayo</option>";
                                    echo "<option value='06'>Junio</option>";
                                    echo "<option value='07'>Julio</option>";
                                    echo "<option value='08'>Agosto</option>";
                                    echo "<option value='09'>Septiembre</option>";
                                    echo "<option value='10'>Octubre</option>";
                                    echo "<option value='11'>Noviembre</option>";
                                    echo "<option value='12'>Diciembre</option>";
                                } else{
                                    if($mes == '03'){
                                        echo "<option value='01'>Enero</option>";
                                        echo "<option value='02'>Febrero</option>";
                                        echo "<option value='03' selected='selected'>Marzo</option>";
                                        echo "<option value='04'>Abril</option>";
                                        echo "<option value='05'>Mayo</option>";
                                        echo "<option value='06'>Junio</option>";
                                        echo "<option value='07'>Julio</option>";
                                        echo "<option value='08'>Agosto</option>";
                                        echo "<option value='09'>Septiembre</option>";
                                        echo "<option value='10'>Octubre</option>";
                                        echo "<option value='11'>Noviembre</option>";
                                        echo "<option value='12'>Diciembre</option>";
                                    }else{
                                        if($mes == '04'){
                                            echo "<option value='01'>Enero</option>";
                                            echo "<option value='02'>Febrero</option>";
                                            echo "<option value='03'>Marzo</option>";
                                            echo "<option value='04' selected='selected'>Abril</option>";
                                            echo "<option value='05'>Mayo</option>";
                                            echo "<option value='06'>Junio</option>";
                                            echo "<option value='07'>Julio</option>";
                                            echo "<option value='08'>Agosto</option>";
                                            echo "<option value='09'>Septiembre</option>";
                                            echo "<option value='10'>Octubre</option>";
                                            echo "<option value='11'>Noviembre</option>";
                                            echo "<option value='12'>Diciembre</option>";
                                        }else{
                                            if($mes == '05'){
                                                echo "<option value='01'>Enero</option>";
                                                echo "<option value='02'>Febrero</option>";
                                                echo "<option value='03'>Marzo</option>";
                                                echo "<option value='04'>Abril</option>";
                                                echo "<option value='05' selected='selected'>Mayo</option>";
                                                echo "<option value='06'>Junio</option>";
                                                echo "<option value='07'>Julio</option>";
                                                echo "<option value='08'>Agosto</option>";
                                                echo "<option value='09'>Septiembre</option>";
                                                echo "<option value='10'>Octubre</option>";
                                                echo "<option value='11'>Noviembre</option>";
                                                echo "<option value='12'>Diciembre</option>";
                                            }else{
                                                if($mes == '06'){
                                                    echo "<option value='01'>Enero</option>";
                                                    echo "<option value='02'>Febrero</option>";
                                                    echo "<option value='03'>Marzo</option>";
                                                    echo "<option value='04'>Abril</option>";
                                                    echo "<option value='05'>Mayo</option>";
                                                    echo "<option value='06' selected='selected'>Junio</option>";
                                                    echo "<option value='07'>Julio</option>";
                                                    echo "<option value='08'>Agosto</option>";
                                                    echo "<option value='09'>Septiembre</option>";
                                                    echo "<option value='10'>Octubre</option>";
                                                    echo "<option value='11'>Noviembre</option>";
                                                    echo "<option value='12'>Diciembre</option>";
                                                }else{
                                                    if($mes == '07'){
                                                        echo "<option value='01'>Enero</option>";
                                                        echo "<option value='02'>Febrero</option>";
                                                        echo "<option value='03'>Marzo</option>";
                                                        echo "<option value='04'>Abril</option>";
                                                        echo "<option value='05'>Mayo</option>";
                                                        echo "<option value='06'>Junio</option>";
                                                        echo "<option value='07' selected='selected'>Julio</option>";
                                                        echo "<option value='08'>Agosto</option>";
                                                        echo "<option value='09'>Septiembre</option>";
                                                        echo "<option value='10'>Octubre</option>";
                                                        echo "<option value='11'>Noviembre</option>";
                                                        echo "<option value='12'>Diciembre</option>";
                                                    }else{
                                                        if($mes == '08'){
                                                            echo "<option value='01'>Enero</option>";
                                                            echo "<option value='02'>Febrero</option>";
                                                            echo "<option value='03'>Marzo</option>";
                                                            echo "<option value='04'>Abril</option>";
                                                            echo "<option value='05'>Mayo</option>";
                                                            echo "<option value='06'>Junio</option>";
                                                            echo "<option value='07'>Julio</option>";
                                                            echo "<option value='08' selected='selected'>Agosto</option>";
                                                            echo "<option value='09'>Septiembre</option>";
                                                            echo "<option value='10'>Octubre</option>";
                                                            echo "<option value='11'>Noviembre</option>";
                                                            echo "<option value='12'>Diciembre</option>";
                                                        }else{
                                                            if($mes == '09'){
                                                                echo "<option value='01'>Enero</option>";
                                                                echo "<option value='02'>Febrero</option>";
                                                                echo "<option value='03'>Marzo</option>";
                                                                echo "<option value='04'>Abril</option>";
                                                                echo "<option value='05'>Mayo</option>";
                                                                echo "<option value='06'>Junio</option>";
                                                                echo "<option value='07'>Julio</option>";
                                                                echo "<option value='08'>Agosto</option>";
                                                                echo "<option value='09' selected='selected'>Septiembre</option>";
                                                                echo "<option value='10'>Octubre</option>";
                                                                echo "<option value='11'>Noviembre</option>";
                                                                echo "<option value='12'>Diciembre</option>";
                                                            }else{
                                                                if($mes == '10'){
                                                                    echo "<option value='01'>Enero</option>";
                                                                    echo "<option value='02'>Febrero</option>";
                                                                    echo "<option value='03'>Marzo</option>";
                                                                    echo "<option value='04'>Abril</option>";
                                                                    echo "<option value='05'>Mayo</option>";
                                                                    echo "<option value='06'>Junio</option>";
                                                                    echo "<option value='07'>Julio</option>";
                                                                    echo "<option value='08'>Agosto</option>";
                                                                    echo "<option value='09'>Septiembre</option>";
                                                                    echo "<option value='10' selected='selected'>Octubre</option>";
                                                                    echo "<option value='11'>Noviembre</option>";
                                                                    echo "<option value='12'>Diciembre</option>";
                                                                }else{
                                                                    if($mes == '11'){
                                                                        echo "<option value='01'>Enero</option>";
                                                                        echo "<option value='02'>Febrero</option>";
                                                                        echo "<option value='03'>Marzo</option>";
                                                                        echo "<option value='04'>Abril</option>";
                                                                        echo "<option value='05'>Mayo</option>";
                                                                        echo "<option value='06'>Junio</option>";
                                                                        echo "<option value='07'>Julio</option>";
                                                                        echo "<option value='08'>Agosto</option>";
                                                                        echo "<option value='09'>Septiembre</option>";
                                                                        echo "<option value='10'>Octubre</option>";
                                                                        echo "<option value='11' selected='selected'>Noviembre</option>";
                                                                        echo "<option value='12'>Diciembre</option>";
                                                                    }else{
                                                                        if($mes == '12'){
                                                                            echo "<option value='01'>Enero</option>";
                                                                            echo "<option value='02'>Febrero</option>";
                                                                            echo "<option value='03'>Marzo</option>";
                                                                            echo "<option value='04'>Abril</option>";
                                                                            echo "<option value='05'>Mayo</option>";
                                                                            echo "<option value='06'>Junio</option>";
                                                                            echo "<option value='07'>Julio</option>";
                                                                            echo "<option value='08'>Agosto</option>";
                                                                            echo "<option value='09'>Septiembre</option>";
                                                                            echo "<option value='10'>Octubre</option>";
                                                                            echo "<option value='11'>Noviembre</option>";
                                                                            echo "<option value='12' selected='selected'>Diciembre</option>";
                                                                        }else{
                                                                            echo "<option value='01'>Enero</option>";
                                                                            echo "<option value='02'>Febrero</option>";
                                                                            echo "<option value='03'>Marzo</option>";
                                                                            echo "<option value='04'>Abril</option>";
                                                                            echo "<option value='05'>Mayo</option>";
                                                                            echo "<option value='06'>Junio</option>";
                                                                            echo "<option value='07'>Julio</option>";
                                                                            echo "<option value='08'>Agosto</option>";
                                                                            echo "<option value='09'>Septiembre</option>";
                                                                            echo "<option value='10'>Octubre</option>";
                                                                            echo "<option value='11'>Noviembre</option>";
                                                                            echo "<option value='12'>Diciembre</option>";
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }else{
                            if(date("m") == '01')
                                echo "<option value='01' selected='selected'>Enero</option>";
                            else
                                echo "<option value='01'>Enero</option>";

                            if(date("m") === '02')
                                echo "<option value='02' selected='selected'>Febrero</option>";
                            else
                                echo "<option value='02'>Febrero</option>";

                            if(date("m") == '03')
                                echo "<option value='03' selected='selected'>Marzo</option>";
                            else
                                echo "<option value='03'>Marzo</option>";

                            if(date("m") == '04')
                                echo "<option value='04' selected='selected'>Abril</option>";
                            else
                                echo "<option value='04'>Abril</option>";

                            if(date("m") == '05')
                                echo "<option value='05' selected='selected'>Mayo</option>";
                            else
                                echo "<option value='05'>Mayo</option>";

                            if(date("m") == '06')
                                echo "<option value='06' selected='selected'>Junio</option>";
                            else
                                echo "<option value='06'>Junio</option>";

                            if(date("m") == '07')
                                echo "<option value='07' selected='selected'>Julio</option>";
                            else
                                echo "<option value='07'>Julio</option>";

                            if(date("m") == '08')
                                echo "<option value='08' selected='selected'>Agosto</option>";
                            else
                                echo "<option value='08'>Agosto</option>";

                            if(date("m") == '09')
                                echo "<option value='09' selected='selected'>Septiembre</option>";
                            else
                                echo "<option value='09'>Septiembre</option>";

                            if(date("m") == '10')
                                echo "<option value='10' selected='selected'>Octubre</option>";
                            else
                                echo "<option value='10'>Octubre</option>";

                            if(date("m") == '11')
                                echo "<option value='11' selected='selected'>Noviembre</option>";
                            else
                                echo "<option value='11'>Noviembre</option>";

                            if(date("m") == '12')
                                echo "<option value='12' selected='selected'>Diciembre</option>";
                            else
                                echo "<option value='12'>Diciembre</option>";
                        }
                        ?>
                    </select>
                    <select name="anio" id="anio" class="btn btn-default btn-sm" title="Año" data-style="btn btn-default btn-sm" data-width="70px" onchange="asignar();">
                        <?php
                        if(isset($_POST['anio'])){
                            $anio = $_POST['anio'];
                            $actual = date("Y");
                            for($dia = 2015; $dia <= $actual; $dia++){
                                if($anio == $dia)
                                    echo "<option selected='selected' value='" . $dia . "'>" . $dia . "</option>";
                                else
                                    echo "<option value='" . $dia . "'>" . $dia . "</option>";
                            }
                        }else{
                            $actual = date("Y");
                            for($dia = 2015; $dia <= $actual; $dia++) {
                                if (date("Y") == $dia)
                                    echo "<option value='" . $dia . "' selected='selected'>" . $dia . "</option>";
                                else
                                    echo "<option value='" . $dia . "'>" . $dia . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>



                <div class="col-lg-2 col-sm-4">
                    <select name="tienda" id="tienda" class="btn btn-default btn-sm" title="Tienda" data-style="btn btn-default btn-sm" data-width="180px" onchange="asignar();">
                        <?php
                        $click = new mysqli('localhost', 'root', '', 'clickcollect');
                        if(isset($_POST['tienda'])){
                            $shopping = $_POST['tienda'];

                            if($shopping == 'Total Click & Collect') {
                                echo "<option value='clickcollect' selected='selected'>Total Click & Collect</option>";

                                $query = "select tienda, tienda2 from tiendas";

                                $res = $click->query($query);

                                while($row = mysqli_fetch_assoc($res)){
                                    $tien1 = $row['tienda'];
                                    $tien = $row['tienda2'];
                                    echo "<option value='$tien'>" . utf8_encode($tien1) . "</option>";
                                }
                            }else{
                                echo "<option value='clickcollect'>Total Click & Collect</option>";

                                $query = "select tienda, tienda2 from tiendas";

                                $res = $click->query($query);

                                while($row = mysqli_fetch_assoc($res)){
                                    $tien1 = $row['tienda'];
                                    $tien = $row['tienda2'];
                                    if($tien == $shopping)
                                        echo "<option value='$tien' selected='selected'>" . utf8_encode($tien1) . "</option>";
                                    else
                                        echo "<option value='$tien'>" . utf8_encode($tien1) . "</option>";
                                }
                            }
                        }
                        else
                        {
                            $query = "select tienda, tienda2 from tiendas";

                            $res = $click->query($query);

                            echo "<option value='clickcollect' selected='selected'>Total Click & Collect</option>";

                            while($row = mysqli_fetch_assoc($res)){
                                $tien1 = $row['tienda'];
                                $tien = $row['tienda2'];
                                echo "<option value='$tien'>" . utf8_encode($tien1) . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-lg-1 col-sm-4">
                    <button class="btn btn-primary btn-sm" style="width: 100px;">Actualizar</button>
                </div>

                <!--<div class="col-lg-1 col-sm-4">
                    <a href="#" id="exportar" class="btn btn-success btn-sm">Exportar</a>
                </div>-->

            </form>
        </div>
    </nav>
</header>

<?php
require_once 'fechas.php';

function diasem($diasem){
    if($diasem == 'Mon')
        return 'Lunes';
    if($diasem == 'Tue')
        return 'Martes';
    if($diasem == 'Wed')
        return 'Miércoles';
    if($diasem == 'Thu')
        return 'Jueves';
    if($diasem == 'Fri')
        return 'Viernes';
    if($diasem == 'Sat')
        return 'Sábado';
    if($diasem == 'Sun')
        return 'Domingo';
}

echo '<div id="fecha">';
echo '<table class="table table-condensed table-bordered table-hover">';
echo '<thead>';
echo '<tr>';
echo '<th colspan="8" style="background-color: #337ab7; color: white; border-right: 10px solid white;"><h6 class="text-center"><b>Año Actual</b></h6></th>';
echo '<th colspan="5" style="background-color: #337ab7; color: white;"><h6 class="text-center"><b>Año Anterior</b></h6></th>';
echo '</tr>';

echo '<tr>';
echo '<th rowspan="2" style="background-color: #337ab7; color: white;"><h6 class="text-center"><b>Fecha Día Actual</b></h6></th>';
echo '<th colspan="2" style="background-color: #4E85FC; color: white;"><h6 class="text-center"><b>Ingreso Bruto</b></h6></th>';
echo '<th colspan="2" style="background-color: #4E85FC; color: white;"><h6 class="text-center"><b>Notas de Crédito</br></h6></th>';
echo '<th colspan="3" style="background-color: #7E9FE7; color: white; border-right: 10px solid white;"><h6 class="text-center"><b>Ingreso Neto (Sin IVA)</b></h6></th>';

echo '<th rowspan="2" style="background-color: #337ab7; color: white;"><h6 class="text-center"><b>Fecha Día Anterior</b></h6></th>';
echo '<th colspan="3" style="background-color: #7E9FE7; color: white;"><h6 class="text-center"><b>Ingreso Neto (Sin IVA)</b></h6></th>';
echo '<th rowspan="2" style="background-color: #7E9FE7; color: white;"><h6 class="text-center"><b>% R/Past</b></h6></th>';
echo '</tr>';

echo '<tr>';
echo '<th style="background-color: #4E85FC; color: white;"><h6 class="text-center"><b>Monto $</b></h6></th>';
echo '<th style="background-color: #4E85FC; color: white;"><h6 class="text-center"><b>#</b></h6></th>';
echo '<th style="background-color: #4E85FC; color: white;"><h6 class="text-center"><b>Monto $</b></h6></th>';
echo '<th style="background-color: #4E85FC; color: white;"><h6 class="text-center"><b>#</b></h6></th>';
echo '<th style="background-color: #7E9FE7; color: white;"><h6 class="text-center"><b>Monto $</b></h6></th>';
echo '<th style="background-color: #7E9FE7; color: white;"><h6 class="text-center"><b>#</b></h6></th>';
echo '<th style="background-color: #7E9FE7; color: white; border-right: 10px solid white;"><h6 class="text-center"><b>Ticket Promedio</b></h6></th>';

echo '<th style="background-color: #7E9FE7; color: white;"><h6 class="text-center"><b>Monto $</b></h6></th>';
echo '<th style="background-color: #7E9FE7; color: white;"><h6 class="text-center"><b>#</b></h6></th>';
echo '<th style="background-color: #7E9FE7; color: white;"><h6 class="text-center"><b>Ticket Promedio</b></h6></th>';
echo '</tr>';
echo '</thead>';

if(isset($_POST['mes']) && isset($_POST['anio'])) {
    if (isset($_POST['tienda']) && $_POST['tienda'] != 'clickcollect') {
        $tiendas = $_POST['tienda'];

        $dia = date("d");
        $mes = $_POST['mes'];
        $anio = $_POST['anio'];

        $buscaract = $anio . $mes;

        $buscaractTMP1 = $anio . $mes . $dia;

        $buscarant_act = $anio . $mes . '01';

        $buscaractTMP = fecha($buscaractTMP1);

        $buscarant = fecha($buscarant_act);

        $con = new mysqli('localhost', 'root', '', 'clickcollect');

        $query = "select ingresobruto, ordTienda, ncredito, ordncredito, fecha

                  from montos

                  where tienda = '$tiendas' and fecha like '" . $buscaract . "%' order by fecha desc";

        $resultado = $con->query($query);

        $existe_actual = mysqli_num_rows($resultado);

        $ingresobruto = array();
        $ordTienda = array();
        $ncredito = array();
        $ordncredito = array();
        $fecha = array();
        $ingresoneto = array();
        $ordneto = array();
        $ticketprom = array();

        $i = 0;

        if($existe_actual > 0) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $ingresobruto[$i] = $row['ingresobruto'];
                $ordTienda[$i] = $row['ordTienda'];
                $ncredito[$i] = $row['ncredito'];
                $ordncredito[$i] = $row['ordncredito'];
                $fecha[$i] = new DateTime($row['fecha']);

                $ingresoneto[$i] = round(($ingresobruto[$i] - $ncredito[$i]) / 1.19);

                $ordneto[$i] = $ordTienda[$i] - $ordncredito[$i];

                $ticketprom[$i] = 0;
                if ($ordneto[$i] > 0)
                    $ticketprom[$i] = round(($ingresoneto[$i] / $ordneto[$i]));

                $i++;
            }
        }else{
            for($fec = new DateTime($buscaractTMP1); $fec->format("Ymd") >= $buscarant_act; $fec->modify("-1 day")){
                $ingresobruto[$i] = 0;
                $ordTienda[$i] = 0;
                $ncredito[$i] = 0;
                $ordncredito[$i] = 0;
                $fecha[$i] = new Datetime($fec->format("Ymd"));

                $ingresoneto[$i] = 0;
                $ordneto[$i] = 0;
                $ticketprom[$i] = 0;
                $i++;
            }
        }

        //Año Anterior

        $query = "select ingresobruto, ordTienda, ncredito, ordncredito, fecha

              from montos

              where tienda = '$tiendas' and fecha between $buscarant and $buscaractTMP order by fecha desc";

        $resultado = $con->query($query);

        $existen = mysqli_num_rows($resultado);

        $ingresobrutoAnt = array();
        $ordTiendaAnt = array();
        $ncreditoAnt = array();
        $ordncreditoAnt = array();
        $fechaAnt = array();
        $ingresonetoAnt = array();
        $ordnetoAnt = array();
        $ticketpromAnt = array();

        $i = 0;

        if($existen > 0) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $ingresobrutoAnt[$i] = $row['ingresobruto'];
                $ordTiendaAnt[$i] = $row['ordTienda'];
                $ncreditoAnt[$i] = $row['ncredito'];
                $ordncreditoAnt[$i] = $row['ordncredito'];
                $fechaAnt[$i] = new DateTime($row['fecha']);

                $ingresonetoAnt[$i] = round(($ingresobrutoAnt[$i] - $ncreditoAnt[$i]) / 1.19);

                $ordnetoAnt[$i] = $ordTiendaAnt[$i] - $ordncreditoAnt[$i];

                $ticketpromAnt[$i] = 0;
                if ($ordnetoAnt[$i] > 0)
                    $ticketpromAnt[$i] = round(($ingresonetoAnt[$i] / $ordnetoAnt[$i]));

                $i++;
            }
        }else{
            for($fec = new DateTime($buscaractTMP); $fec->format("Ymd") >= $buscarant; $fec->modify("-1 day")){
                $ingresobrutoAnt[$i] = 0;
                $ordTiendaAnt[$i] = 0;
                $ncreditoAnt[$i] = 0;
                $ordncreditoAnt[$i] = 0;
                $fechaAnt[$i] = new Datetime($fec->format("Ymd"));
                $ingresonetoAnt[$i] = 0;
                $ordnetoAnt[$i] = 0;
                $ticketpromAnt[$i] = 0;
                $i++;
            }
        }

        for ($j = 0; $j < $i; $j++) {
            $rpast = 0;
            if ($ingresonetoAnt[$j] != 0)
                $rpast = round((($ingresoneto[$j] / $ingresonetoAnt[$j]) - 1) * 100);

            $diasem = '';
            if ($fecha[$j]->format("D") == 'Mon')
                $diasem = 'Lun';

            if ($fecha[$j]->format("D") == 'Tue')
                $diasem = 'Mar';

            if ($fecha[$j]->format("D") == 'Wed')
                $diasem = 'Mie';

            if ($fecha[$j]->format("D") == 'Thu')
                $diasem = 'Jue';

            if ($fecha[$j]->format("D") == 'Fri')
                $diasem = 'Vie';

            if ($fecha[$j]->format("D") == 'Sat')
                $diasem = 'Sab';

            if ($fecha[$j]->format("D") == 'Sun')
                $diasem = 'Dom';

            $diasemAnt = '';
            if ($fechaAnt[$j]->format("D") == 'Mon')
                $diasemAnt = 'Lun';

            if ($fechaAnt[$j]->format("D") == 'Tue')
                $diasemAnt = 'Mar';

            if ($fechaAnt[$j]->format("D") == 'Wed')
                $diasemAnt = 'Mie';

            if ($fechaAnt[$j]->format("D") == 'Thu')
                $diasemAnt = 'Jue';

            if ($fechaAnt[$j]->format("D") == 'Fri')
                $diasemAnt = 'Vie';

            if ($fechaAnt[$j]->format("D") == 'Sat')
                $diasemAnt = 'Sab';

            if ($fechaAnt[$j]->format("D") == 'Sun')
                $diasemAnt = 'Dom';

            $label = "";

            if ($rpast > 0)
                $label = "label label-success";

            if ($rpast == 0)
                $label = "label label-warning";

            if ($rpast < 0)
                $label = "label label-danger";

            echo "<tr><td class='text-center'><h6 class='text-primary'><b>" . $diasem . ", " . $fecha[$j]->format("d-m-Y") . "</b></h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ingresobruto[$j], 0, ',', '.') . "</h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ordTienda[$j], 0, ',', '.') . "</h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ncredito[$j], 0, ',', '.') . "</h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ordncredito[$j], 0, ',', '.') . "</h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ingresoneto[$j], 0, ',', '.') . "</h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ordneto[$j], 0, ',', '.') . "</h6></td>";
            echo "<td class='text-center' style='border-right: 10px solid white;'><h6>" . number_format($ticketprom[$j], 0, ',', '.') . "</h6></td>";

            echo "<td class='text-center'><h6 class='text-primary'><b>" . $diasemAnt . ", " . $fechaAnt[$j]->format("d-m-Y") . "</b></h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ingresonetoAnt[$j], 0, ',', '.') . "</h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ordnetoAnt[$j], 0, ',', '.') . "</h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ticketpromAnt[$j], 0, ',', '.') . "</h6></td>";

            echo "<td class='text-center'><h6 class='$label' style='font-size: 12px;'>" . number_format($rpast, 0, ',', '.') . " %</h6></td></tr>";
        }

    }else {
        $dia = date("d");
        $mes = $_POST['mes'];
        $anio = $_POST['anio'];

        $tmp = $anio . $mes;

        if ($tmp < date("Ym")) {
            $tmp = $anio . $mes . '01';
            $tmp = date("Ymd", strtotime("{$tmp}+1 month"));
            $tmp = date("d", strtotime("{$tmp}-1 day"));
            $dia = $tmp;
        }

        $buscaract = $anio . $mes;

        $buscaractTMP1 = $anio . $mes . $dia;

        $buscarant_act = $anio . $mes . '01';

        $buscaractTMP = fecha($buscaractTMP1);

        $buscarant = fecha($buscarant_act);

        $con = new mysqli('localhost', 'root', '', 'clickcollect');

        $query = "select sum(ingresobruto) as ingresobruto, sum(ordTienda) as ordTienda, sum(ncredito) as ncredito, sum(ordncredito) as ordncredito, fecha

                  from montos

                  where fecha like '" . $buscaract . "%'  and tienda not in ('Paris Internet') group by fecha order by fecha desc";

        $resultado = $con->query($query);

        $existe_actual = mysqli_num_rows($resultado);

        $ingresobruto = array();
        $ordTienda = array();
        $ncredito = array();
        $ordncredito = array();
        $fecha = array();
        $ingresoneto = array();
        $ordneto = array();
        $ticketprom = array();

        $i = 0;

        if ($existe_actual > 0) {
            while ($row = mysqli_fetch_assoc($resultado)) {
                $ingresobruto[$i] = $row['ingresobruto'];
                $ordTienda[$i] = $row['ordTienda'];
                $ncredito[$i] = $row['ncredito'];
                $ordncredito[$i] = $row['ordncredito'];
                $fecha[$i] = new DateTime($row['fecha']);

                $ingresoneto[$i] = round(($ingresobruto[$i] - $ncredito[$i]) / 1.19);

                $ordneto[$i] = $ordTienda[$i] - $ordncredito[$i];

                $ticketprom[$i] = 0;
                if ($ordneto[$i] > 0)
                    $ticketprom[$i] = round(($ingresoneto[$i] / $ordneto[$i]));

                $i++;
            }
        } else {
            for ($fec = new DateTime($buscaractTMP1); $fec->format("Ymd") >= $buscarant_act; $fec->modify("-1 day")) {
                $ingresobruto[$i] = 0;
                $ordTienda[$i] = 0;
                $ncredito[$i] = 0;
                $ordncredito[$i] = 0;
                $fecha[$i] = new Datetime($fec->format("Ymd"));

                $ingresoneto[$i] = 0;
                $ordneto[$i] = 0;
                $ticketprom[$i] = 0;
                $i++;
            }
        }

        //Año Anterior

        $query = "select sum(ingresobruto) ingresobruto, sum(ordTienda) as ordTienda, sum(ncredito) as ncredito, sum(ordncredito) as ordncredito, fecha

              from montos

              where fecha between $buscarant and $buscaractTMP  and tienda not in ('Paris Internet') group by fecha order by fecha desc";

        $resultado = $con->query($query);

        $existe = mysqli_num_rows($resultado);

        $ingresobrutoAnt = array();
        $ordTiendaAnt = array();
        $ncreditoAnt = array();
        $ordncreditoAnt = array();
        $fechaAnt = array();
        $ingresonetoAnt = array();
        $ordnetoAnt = array();
        $ticketpromAnt = array();

        $i = 0;

        if ($existe > 0){

            while ($row = mysqli_fetch_assoc($resultado)) {
                $ingresobrutoAnt[$i] = $row['ingresobruto'];
                $ordTiendaAnt[$i] = $row['ordTienda'];
                $ncreditoAnt[$i] = $row['ncredito'];
                $ordncreditoAnt[$i] = $row['ordncredito'];
                $fechaAnt[$i] = new DateTime($row['fecha']);

                $ingresonetoAnt[$i] = round(($ingresobrutoAnt[$i] - $ncreditoAnt[$i]) / 1.19);

                $ordnetoAnt[$i] = $ordTiendaAnt[$i] - $ordncreditoAnt[$i];

                $ticketpromAnt[$i] = 0;
                if ($ordnetoAnt[$i] > 0)
                    $ticketpromAnt[$i] = round(($ingresonetoAnt[$i] / $ordnetoAnt[$i]));

                $i++;
            }
        }else{

            for($fec = new DateTime($buscaractTMP); $fec->format("Ymd") >= $buscarant; $fec->modify("-1 day")){
                $ingresobrutoAnt[$i] = 0;
                $ordTiendaAnt[$i] = 0;
                $ncreditoAnt[$i] = 0;
                $ordncreditoAnt[$i] = 0;
                $fechaAnt[$i] = new Datetime($fec->format("Ymd"));

                $ingresonetoAnt[$i] = 0;
                $ordnetoAnt[$i] = 0;
                $ticketpromAnt[$i] = 0;
                $i++;
            }
        }

        for($j = 0; $j < $i; $j++){
            $rpast = 0;
            if($ingresonetoAnt[$j] != 0)
                $rpast = round((($ingresoneto[$j] / $ingresonetoAnt[$j]) - 1) * 100);

            $diasem = '';
            if ($fecha[$j]->format("D") == 'Mon')
                $diasem = 'Lun';

            if ($fecha[$j]->format("D") == 'Tue')
                $diasem = 'Mar';

            if ($fecha[$j]->format("D") == 'Wed')
                $diasem = 'Mie';

            if ($fecha[$j]->format("D") == 'Thu')
                $diasem = 'Jue';

            if ($fecha[$j]->format("D") == 'Fri')
                $diasem = 'Vie';

            if ($fecha[$j]->format("D") == 'Sat')
                $diasem = 'Sab';

            if ($fecha[$j]->format("D") == 'Sun')
                $diasem = 'Dom';

            $diasemAnt = '';
            if ($fechaAnt[$j]->format("D") == 'Mon')
                $diasemAnt = 'Lun';

            if ($fechaAnt[$j]->format("D") == 'Tue')
                $diasemAnt = 'Mar';

            if ($fechaAnt[$j]->format("D") == 'Wed')
                $diasemAnt = 'Mie';

            if ($fechaAnt[$j]->format("D") == 'Thu')
                $diasemAnt = 'Jue';

            if ($fechaAnt[$j]->format("D") == 'Fri')
                $diasemAnt = 'Vie';

            if ($fechaAnt[$j]->format("D") == 'Sat')
                $diasemAnt = 'Sab';

            if ($fechaAnt[$j]->format("D") == 'Sun')
                $diasemAnt = 'Dom';

            $label = "";

            if($rpast > 0)
                $label = "label label-success";

            if($rpast == 0)
                $label = "label label-warning";

            if($rpast < 0)
                $label = "label label-danger";

            echo "<tr><td class='text-center'><h6><b>" . $diasem . ", " . $fecha[$j]->format("d-m-Y") . "</b></h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ingresobruto[$j], 0, ',', '.') . "</h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ordTienda[$j], 0, ',', '.') . "</h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ncredito[$j], 0, ',', '.') . "</h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ordncredito[$j], 0, ',', '.') . "</h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ingresoneto[$j], 0, ',', '.') . "</h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ordneto[$j], 0, ',', '.') . "</h6></td>";
            echo "<td class='text-center' style='border-right: 10px solid white;'><h6>" . number_format($ticketprom[$j], 0, ',', '.') . "</h6></td>";

            echo "<td class='text-center'><h6><b>" . $diasemAnt . ", " . $fechaAnt[$j]->format("d-m-Y") . "</b></h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ingresonetoAnt[$j], 0, ',', '.') . "</h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ordnetoAnt[$j], 0, ',', '.') . "</h6></td>";
            echo "<td class='text-center'><h6>" . number_format($ticketpromAnt[$j], 0, ',', '.') . "</h6></td>";

            echo "<td class='text-center'><h6 class='$label' style='font-size: 12px;'>" . number_format($rpast, 0, ',', '.') . " %</h6></td></tr>";
        }
    }
}else{
    $dia = date("d");
    $mes = date("m");
    $anio = date("Y");

    $buscaract = $anio . $mes;

    $buscaractTMP = $anio . $mes . $dia;

    $buscarant = $anio . $mes . '01';

    $buscaractTMP = fecha($buscaractTMP);

    $buscarant = fecha($buscarant);

    $con = new mysqli('localhost', 'root', '', 'clickcollect');

    $query = "select sum(ingresobruto) as ingresobruto, sum(ordTienda) as ordTienda, sum(ncredito) as ncredito, sum(ordncredito) as ordncredito, fecha

                  from montos

                  where fecha like '" . $buscaract . "%'  and tienda not in ('Paris Internet') group by fecha order by fecha desc ";

    $resultado = $con->query($query);

    $ingresobruto = array();
    $ordTienda = array();
    $ncredito = array();
    $ordncredito = array();
    $fecha = array();
    $ingresoneto = array();
    $ordneto = array();
    $ticketprom = array();

    $i = 0;

    while ($row = mysqli_fetch_assoc($resultado)) {
        $ingresobruto[$i] = $row['ingresobruto'];
        $ordTienda[$i] = $row['ordTienda'];
        $ncredito[$i] = $row['ncredito'];
        $ordncredito[$i] = $row['ordncredito'];
        $fecha[$i] = new DateTime($row['fecha']);

        $ingresoneto[$i] = round(($ingresobruto[$i] - $ncredito[$i]) / 1.19);

        $ordneto[$i] = $ordTienda[$i] - $ordncredito[$i];

        $ticketprom[$i] = 0;
        if ($ordneto[$i] > 0)
            $ticketprom[$i] = round(($ingresoneto[$i] / $ordneto[$i]));

        $i++;
    }

    //Año Anterior

    $query = "select sum(ingresobruto) as ingresobruto, sum(ordTienda) as ordTienda, sum(ncredito) as ncredito, sum(ordncredito) as ordncredito, fecha

              from montos

              where fecha between $buscarant and $buscaractTMP and tienda not in ('Paris Internet') group by fecha order by fecha desc";

    $resultado = $con->query($query);

    $ingresobrutoAnt = array();
    $ordTiendaAnt = array();
    $ncreditoAnt = array();
    $ordncreditoAnt = array();
    $fechaAnt = array();
    $ingresonetoAnt = array();
    $ordnetoAnt = array();
    $ticketpromAnt = array();

    $i = 0;

    while ($row = mysqli_fetch_assoc($resultado)) {
        $ingresobrutoAnt[$i] = $row['ingresobruto'];
        $ordTiendaAnt[$i] = $row['ordTienda'];
        $ncreditoAnt[$i] = $row['ncredito'];
        $ordncreditoAnt[$i] = $row['ordncredito'];
        $fechaAnt[$i] = new DateTime($row['fecha']);

        $ingresonetoAnt[$i] = round(($ingresobrutoAnt[$i] - $ncreditoAnt[$i]) / 1.19);

        $ordnetoAnt[$i] = $ordTiendaAnt[$i] - $ordncreditoAnt[$i];

        $ticketpromAnt[$i] = 0;
        if ($ordnetoAnt[$i] > 0)
            $ticketpromAnt[$i] = round(($ingresonetoAnt[$i] / $ordnetoAnt[$i]));

        $i++;
    }

    for($j = 0; $j < $i; $j++){
        $rpast = 0;
        if($ingresonetoAnt[$j] != 0)
            $rpast = round((($ingresoneto[$j] / $ingresonetoAnt[$j]) - 1) * 100);

        $diasem = '';
        if ($fecha[$j]->format("D") == 'Mon')
            $diasem = 'Lun';

        if ($fecha[$j]->format("D") == 'Tue')
            $diasem = 'Mar';

        if ($fecha[$j]->format("D") == 'Wed')
            $diasem = 'Mie';

        if ($fecha[$j]->format("D") == 'Thu')
            $diasem = 'Jue';

        if ($fecha[$j]->format("D") == 'Fri')
            $diasem = 'Vie';

        if ($fecha[$j]->format("D") == 'Sat')
            $diasem = 'Sab';

        if ($fecha[$j]->format("D") == 'Sun')
            $diasem = 'Dom';

        $diasemAnt = '';
        if ($fechaAnt[$j]->format("D") == 'Mon')
            $diasemAnt = 'Lun';

        if ($fechaAnt[$j]->format("D") == 'Tue')
            $diasemAnt = 'Mar';

        if ($fechaAnt[$j]->format("D") == 'Wed')
            $diasemAnt = 'Mie';

        if ($fechaAnt[$j]->format("D") == 'Thu')
            $diasemAnt = 'Jue';

        if ($fechaAnt[$j]->format("D") == 'Fri')
            $diasemAnt = 'Vie';

        if ($fechaAnt[$j]->format("D") == 'Sat')
            $diasemAnt = 'Sab';

        if ($fechaAnt[$j]->format("D") == 'Sun')
            $diasemAnt = 'Dom';

        $label = "";

        if($rpast > 0)
            $label = "label label-success";

        if($rpast == 0)
            $label = "label label-warning";

        if($rpast < 0)
            $label = "label label-danger";

        echo "<tr><td class='text-center'><h6><b>" . $diasem . ", " . $fecha[$j]->format("d-m-Y") . "</b></h6></td>";
        echo "<td class='text-center'><h6>" . number_format($ingresobruto[$j], 0, ',', '.') . "</h6></td>";
        echo "<td class='text-center'><h6>" . number_format($ordTienda[$j], 0, ',', '.') . "</h6></td>";
        echo "<td class='text-center'><h6>" . number_format($ncredito[$j], 0, ',', '.') . "</h6></td>";
        echo "<td class='text-center'><h6>" . number_format($ordncredito[$j], 0, ',', '.') . "</h6></td>";
        echo "<td class='text-center'><h6>" . number_format($ingresoneto[$j], 0, ',', '.') . "</h6></td>";
        echo "<td class='text-center'><h6>" . number_format($ordneto[$j], 0, ',', '.') . "</h6></td>";
        echo "<td class='text-center' style='border-right: 10px solid white;'><h6>" . number_format($ticketprom[$j], 0, ',', '.') . "</h6></td>";

        echo "<td class='text-center'><h6><b>" . $diasemAnt . ", " . $fechaAnt[$j]->format("d-m-Y") . "</b></h6></td>";
        echo "<td class='text-center'><h6>" . number_format($ingresonetoAnt[$j], 0, ',', '.') . "</h6></td>";
        echo "<td class='text-center'><h6>" . number_format($ordnetoAnt[$j], 0, ',', '.') . "</h6></td>";
        echo "<td class='text-center'><h6>" . number_format($ticketpromAnt[$j], 0, ',', '.') . "</h6></td>";

        echo "<td class='text-center'><h6 class='$label' style='font-size: 12px;'>" . number_format($rpast, 0, ',', '.') . " %</h6></td></tr>";
    }
}
?>

<script src="jquery-1.12.0.min.js"></script>
<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="bootstrap-select-1.9.4/dist/js/bootstrap-select.min.js"></script>
<script src="jquery.stickytableheaders.js"></script>
<script>
    $('table').stickyTableHeaders();
</script>
</body>
</html>