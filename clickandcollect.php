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

<body onload="asignar();">
<script>
    var int=self.setInterval("refresh()",1000);
    function refresh()
    {
        fecha = new Date();
        if((fecha.getMinutes() == 0 && fecha.getSeconds() == 0) || (fecha.getMinutes() == 10 && fecha.getSeconds() == 0) ||
            (fecha.getMinutes() == 20 && fecha.getSeconds() == 0) || (fecha.getMinutes() == 30 && fecha.getSeconds() == 0) ||
            (fecha.getMinutes() == 40 && fecha.getSeconds() == 0) || (fecha.getMinutes() == 50 && fecha.getSeconds() == 0))
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


        fechainicio = yearpast + monthpast + daypast;

        fechafin    = year + month + day;

        document.getElementById("exportar").href = "fecha.php?mes="+month+"&anio="+year+"&dia="+day+"&mesant="+monthpast+"&anioant="+yearpast+"&diaant="+daypast;


        document.getElementById("exportarbase").href = "export_base.php?fechainicio="+fechainicio+"&fechafin="+fechafin;
    }
</script>

<header class="container">
    <nav class="navbar navbar-default">
        <div class="btn-group-sm">
            <div class="row">
                <div class="col-md-12"><h3 class="text-center"><a href="http://10.95.17.114/paneles"><img src="paris.png" width="140px" height="100px" title="Reportes Paris"></a> Performance Click & Collect por Fecha</h3></div>
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

            <form action="clickandcollect.php" method="post" class="row">

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

                <div class="col-lg-3 col-sm-6">
                    <label id="etiqueta2" class="label label-primary">Entre</label>
                    <select name="dia" id="dia" class="btn btn-default btn-sm" title="Día" data-style="btn btn-default btn-sm" data-width="40px" onchange="asignar();">
                        <?php
                        date_default_timezone_set("America/Santiago");
                        if(isset($_POST['dia'])){
                            $select = $_POST['dia'];

                            $d = date("Ymd");

                            $d = new DateTime($d);

                            $d = $d->modify('last day of this month');

                            for($day = 1; $day <= 31; $day++){
                                $dia = $day;
                                if(strlen($dia) < 2)
                                    $dia = '0'.$dia;
                                if($select == $dia)
                                    echo "<option selected='selected' value='" . $dia . "'>" . $dia . "</option>";
                                else
                                    echo "<option value='" . $dia . "'>" . $dia . "</option>";
                            }
                        }else{
                            $actual = '01';

                            $d = date("Ymd");

                            $d = new DateTime($d);

                            $d = $d->modify('last day of this month');

                            for($day = '01'; $day <= 31; $day++) {
                                $dia = $day;
                                if(strlen($dia) < 2)
                                    $dia = '0'.$dia;
                                if ($actual == $dia)
                                    echo "<option value='" . $dia . "' selected='selected'>" . $dia . "</option>";
                                else
                                    echo "<option value='" . $dia . "'>" . $dia . "</option>";
                            }
                        }
                        ?>
                    </select>
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

                <div class="col-lg-3 col-sm-6">
                    <label id="etiqueta" class="label label-primary"> y</label>
                    <select name="diaant" id="diaant" class="btn btn-default btn-sm" title="Día" data-style="btn btn-default btn-sm" data-width="50px" onchange="asignar();">
                        <?php
                        date_default_timezone_set("America/Santiago");
                        if(isset($_POST['diaant'])){
                            $select = $_POST['diaant'];

                            $d = date("Ymd");

                            $d = new DateTime($d);

                            $d = $d->modify('last day of this month');

                            for($day = 1; $day <= 31; $day++){
                                $dia = $day;
                                if(strlen($dia) < 2)
                                    $dia = '0'.$dia;
                                if($select == $dia)
                                    echo "<option selected='selected' value='" . $dia . "'>" . $dia . "</option>";
                                else
                                    echo "<option value='" . $dia . "'>" . $dia . "</option>";
                            }
                        }else{
                            $actual = date("Ymd");
                            $actual = new DateTime($actual);

                            for($day = '01'; $day <= 31; $day++) {
                                $dia = $day;
                                if(strlen($dia) < 2)
                                    $dia = '0'.$dia;
                                if ($actual->format("d") == $dia)
                                    echo "<option value='" . $dia . "' selected='selected'>" . $dia . "</option>";
                                else
                                    echo "<option value='" . $dia . "'>" . $dia . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <select name="mesant" id="mesant" class="btn btn-default btn-sm" title="Mes" data-style="btn btn-default btn-sm" data-width="100px" onchange="asignar();">
                        <?php
                        if(isset($_POST['mesant'])){
                            $mes = $_POST['mesant'];
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
                            if($actual->format("m") == '01')
                                echo "<option value='01' selected='selected'>Enero</option>";
                            else
                                echo "<option value='01'>Enero</option>";

                            if($actual->format("m") === '02')
                                echo "<option value='02' selected='selected'>Febrero</option>";
                            else
                                echo "<option value='02'>Febrero</option>";

                            if($actual->format("m") == '03')
                                echo "<option value='03' selected='selected'>Marzo</option>";
                            else
                                echo "<option value='03'>Marzo</option>";

                            if($actual->format("m") == '04')
                                echo "<option value='04' selected='selected'>Abril</option>";
                            else
                                echo "<option value='04'>Abril</option>";

                            if($actual->format("m") == '05')
                                echo "<option value='05' selected='selected'>Mayo</option>";
                            else
                                echo "<option value='05'>Mayo</option>";

                            if($actual->format("m") == '06')
                                echo "<option value='06' selected='selected'>Junio</option>";
                            else
                                echo "<option value='06'>Junio</option>";

                            if($actual->format("m") == '07')
                                echo "<option value='07' selected='selected'>Julio</option>";
                            else
                                echo "<option value='07'>Julio</option>";

                            if($actual->format("m") == '08')
                                echo "<option value='08' selected='selected'>Agosto</option>";
                            else
                                echo "<option value='08'>Agosto</option>";

                            if($actual->format("m") == '09')
                                echo "<option value='09' selected='selected'>Septiembre</option>";
                            else
                                echo "<option value='09'>Septiembre</option>";

                            if($actual->format("m") == '10')
                                echo "<option value='10' selected='selected'>Octubre</option>";
                            else
                                echo "<option value='10'>Octubre</option>";

                            if($actual->format("m") == '11')
                                echo "<option value='11' selected='selected'>Noviembre</option>";
                            else
                                echo "<option value='11'>Noviembre</option>";

                            if($actual->format("m") == '12')
                                echo "<option value='12' selected='selected'>Diciembre</option>";
                            else
                                echo "<option value='12'>Diciembre</option>";
                        }
                        ?>
                    </select>
                    <select name="anioant" id="anioant" class="btn btn-default btn-sm" title="Año" data-style="btn btn-default btn-sm" data-width="70px" onchange="asignar();">
                        <?php

                        if(isset($_POST['anioant'])){
                            $anio = $_POST['anioant'];
                            $actual = date("Y");
                            for($dia = 2015; $dia <= $actual; $dia++){
                                if($anio == $dia)
                                    echo "<option selected='selected' value='" . $dia . "'>" . $dia . "</option>";
                                else
                                    echo "<option value='" . $dia . "'>" . $dia . "</option>";
                            }
                        }else{
                            $ac = date("Y");
                            for($dia = 2015; $dia <= $ac; $dia++) {
                                if ($actual->format("Y") == $dia)
                                    echo "<option value='" . $dia . "' selected='selected'>" . $dia . "</option>";
                                else
                                    echo "<option value='" . $dia . "'>" . $dia . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>



                <div class="col-lg-1 col-sm-4">
                    <button class="btn btn-primary btn-sm" style="width: 100px;">Actualizar</button>
                </div>

                <div class="col-lg-1 col-sm-4">
                    <a href="#" id="exportar" class="btn btn-success btn-sm">Exportar</a>
                </div>

                <div class="col-lg-1 col-sm-4">
                    <a href="#" id="exportarbase" class="btn btn-success btn-sm">Exportar Base</a>
                </div>

            </form>
        </div>
    </nav>
</header>

<?php
require_once 'tiendas.php';

echo '<div id="fecha">';

if(isset($_POST['dia']) && isset($_POST['mes']) && isset($_POST['anio']) && isset($_POST['diaant']) && isset($_POST['mesant']) && isset($_POST['anioant'])){
    ini_set("max_execution_time", 0);

    $dia = $_POST['dia'];
    $mes = $_POST['mes'];
    $anio = $_POST['anio'];

    $buscaract = $anio . $mes . $dia;

    $diaant = $_POST['diaant'];
    $mesant = $_POST['mesant'];
    $anioant = $_POST['anioant'];

    $buscarant = $anioant . $mesant . $diaant;

    $fecha_actual = new Datetime($buscaract);
    $buscaractAnt = $fecha_actual->modify("-1 year");
    $buscaractAnt = $buscaractAnt->format("Ymd");
    $fecha_actual = $fecha_actual->format("d-m-Y");

    $fecha_anterior = new Datetime($buscarant);
    $buscarantAnt = $fecha_anterior->modify("-1 year");
    $buscarantAnt = $buscarantAnt->format("Ymd");
    $fecha_anterior = $fecha_anterior->format("d-m-Y");



    echo '<table class="table table-condensed table-bordered table-hover">';
    echo '<thead>';
    echo '<tr>';
    echo '<th colspan="8" style="background-color: #337ab7; color: white; border-right: 10px solid white;">Año Actual</th>';
    echo "<th colspan='4' style='background-color: #337ab7; color: white;'>Año Anterior (Entre $fecha_actual y $fecha_anterior)</th>";
    echo "</tr>";

    echo '<tr>';
    echo '<th rowspan="2" style="background-color: #337ab7; color: white;"><h6 class="text-center"><b>Tiendas</b></h6></th>';
    echo '<th colspan="2" style="background-color: #4E85FC; color: white;"><h6 class="text-center"><b>Ingreso Bruto</b></h6></th>';
    echo '<th colspan="2" style="background-color: #4E85FC; color: white;"><h6 class="text-center"><b>Notas de Crédito</br></h6></th>';
    echo '<th colspan="3" style="background-color: #7E9FE7; color: white;  border-right: 10px solid white;"><h6 class="text-center"><b>Ingreso Neto (Sin IVA)</b></h6></th>';

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

    $con = new mysqli('localhost', 'root', '', 'clickcollect');

    $query = "select sum(ingresobruto) as monto, sum(costo) as costo, sum(ordTienda) as ordTienda, sum(ncredito) as ncredito,
                         sum(ordncredito) as ordncredito

                  from montos

                  where tienda not in ('Paris Internet') and fecha between $buscaract and $buscarant";

    $res = $con->query($query);

    $monto = 0;

    $sumOrd = 0;

    $sumN = 0;

    $sumON = 0;

    while($row = mysqli_fetch_assoc($res)){
        $monto = $row['monto'];
        $sumOrd = $row['ordTienda'];
        $sumN = $row['ncredito'];
        $sumON = $row['ordncredito'];
    }

    $ingresoneto = round(($monto - $sumN) / 1.19);

    $ordenesneto = $sumOrd - $sumON;

    $ticketpro = 0;
    if($ordenesneto > 0)
        $ticketpro = $ingresoneto/$ordenesneto;

    //ANTERIOR

    $con = new mysqli('localhost', 'root', '', 'clickcollect');

    $query = "select sum(ingresobruto) as monto, sum(costo) as costo, sum(ordTienda) as ordTienda, sum(ncredito) as ncredito,
                         sum(ordncredito) as ordncredito

                  from montos

                  where tienda not in ('Paris Internet') and fecha between $buscaractAnt and $buscarantAnt";

    $res = $con->query($query);

    $montoAnt = 0;

    $sumOrdAnt = 0;

    $sumNAnt = 0;

    $sumONAnt = 0;

    while($row = mysqli_fetch_assoc($res)){
        $montoAnt = $row['monto'];
        $sumOrdAnt = $row['ordTienda'];
        $sumNAnt = $row['ncredito'];
        $sumONAnt = $row['ordncredito'];
    }

    $ingresonetoAnt = round(($montoAnt - $sumNAnt) / 1.19);

    $ordenesnetoAnt = $sumOrdAnt - $sumONAnt;

    $ticketproAnt = 0;
    if($ordenesnetoAnt > 0)
        $ticketproAnt = $ingresonetoAnt/$ordenesnetoAnt;

    $rpast = 0;
    if($ingresonetoAnt != 0)
        $rpast = round((($ingresoneto / $ingresonetoAnt) - 1) * 100);

    $label = "";

    if($rpast > 0)
        $label = 'label label-success';

    if($rpast == 0)
        $label = 'label label-warning';

    if($rpast < 0)
        $label = 'label label-danger';

    echo "<tr><td class='text-center' style=''><h6 style='font-size: 14px;'><b>Total C&C</b></h6></td>";
    echo "<td class='text-center'><h6>" . number_format($monto, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center'><h6>" . number_format($sumOrd, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center'><h6>" . number_format($sumN, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center'><h6>" . number_format($sumON, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center'><h6>" . number_format($ingresoneto, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center'><h6>" . number_format($ordenesneto, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center' style='border-right: 10px solid white;'><h6>" . number_format($ticketpro, 0, ',', '.') . "</h6></td>";

    echo "<td class='text-center'><h6>" . number_format($ingresonetoAnt, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center'><h6>" . number_format($ordenesnetoAnt, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center'><h6>" . number_format($ticketproAnt, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center'><h6 class='$label'>" . number_format($rpast, 0, ',', '.') . " %</h6></td>";

    //COMIENZO DE CALCULO POR TIENDA

    //COMIENZO PARIS

    tienda($con, 'Paris', $buscaract, $buscarant, $buscaractAnt, $buscarantAnt);

    //=========================================== FIN PARIS ============================================================

    //COMIENZO JOHNSON

    tienda($con, 'Johnson', $buscaract, $buscarant, $buscaractAnt, $buscarantAnt);

    //=========================================== FIN JOHNSON =========================================================

    //COMIENZO EASY

    tienda($con, 'Easy', $buscaract, $buscarant, $buscaractAnt, $buscarantAnt);

    //======================================== FIN EASY ============================================================

    //COMIENZO JUMBO

    tienda($con, 'Jumbo', $buscaract, $buscarant, $buscaractAnt, $buscarantAnt);

    // ================================= FIN JUMBO =====================================================

    //COMIENZO SANTA ISABEL

    tienda($con, 'Santa Isabel', $buscaract, $buscarant, $buscaractAnt, $buscarantAnt);

    //========================================= FIN SANTA ISABEL ================================================

}else{
    ini_set("max_execution_time", 0);

    $dia = '01';
    $mes = date("m");
    $anio = date("Y");

    $buscaract = $anio . $mes . $dia;

    $diaant = date("d");
    $mesant = date("m");
    $anioant = date("Y");

    $buscarant = $anioant . $mesant . $diaant;

    $dia = '01';
    $mes = date("m");
    $anio = date("Y", strtotime("-1 year"));

    $buscaractAnt = $anio . $mes . $dia;

    $diaant = date("d");
    $mesant = date("m");
    $anioant = date("Y", strtotime("-1 year"));

    $buscarantAnt = $anioant . $mesant . $diaant;

    $fecha_actual = new Datetime($buscaractAnt);
    $fecha_actual = $fecha_actual->format("d-m-Y");

    $fecha_anterior = new Datetime($buscarantAnt);
    $fecha_anterior = $fecha_anterior->format("d-m-Y");

    echo '<table class="table table-condensed table-bordered table-hover">';
    echo '<thead>';
    echo '<tr>';
    echo '<th colspan="8" style="background-color: #337ab7; color: white; border-right: 10px solid white;">Año Actual</th>';
    echo "<th colspan='4' style='background-color: #337ab7; color: white;'>Año Anterior (Entre $fecha_actual y $fecha_anterior)</th>";
    echo "</tr>";

    echo '<tr>';
    echo '<th rowspan="2" style="background-color: #337ab7; color: white;"><h6 class="text-center"><b>Tiendas</b></h6></th>';
    echo '<th colspan="2" style="background-color: #4E85FC; color: white;"><h6 class="text-center"><b>Ingreso Bruto</b></h6></th>';
    echo '<th colspan="2" style="background-color: #4E85FC; color: white;"><h6 class="text-center"><b>Notas de Crédito</br></h6></th>';
    echo '<th colspan="3" style="background-color: #7E9FE7; color: white;  border-right: 10px solid white;"><h6 class="text-center"><b>Ingreso Neto (Sin IVA)</b></h6></th>';

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

    $con = new mysqli('localhost', 'root', '', 'clickcollect');

    $query = "select sum(ingresobruto) as monto, sum(costo) as costo, sum(ordTienda) as ordTienda, sum(ncredito) as ncredito,
                         sum(ordncredito) as ordncredito

                  from montos

                  where tienda not in ('Paris Internet') and fecha between $buscaract and $buscarant";

    $res = $con->query($query);

    $monto = 0;

    $sumOrd = 0;

    $sumN = 0;

    $sumON = 0;

    while($row = mysqli_fetch_assoc($res)){
        $monto = $row['monto'];
        $sumOrd = $row['ordTienda'];
        $sumN = $row['ncredito'];
        $sumON = $row['ordncredito'];
    }

    $ingresoneto = round(($monto - $sumN) / 1.19);

    $ordenesneto = $sumOrd - $sumON;

    $ticketpro = 0;
    if($ordenesneto > 0)
        $ticketpro = $ingresoneto/$ordenesneto;

    //ANTERIOR

    $dia = '01';
    $mes = date("m");
    $anio = date("Y", strtotime("-1 year"));

    $buscaractAnt = $anio . $mes . $dia;

    $diaant = date("d");
    $mesant = date("m");
    $anioant = date("Y", strtotime("-1 year"));

    $buscarantAnt = $anioant . $mesant . $diaant;

    $query = "select sum(ingresobruto) as monto, sum(costo) as costo, sum(ordTienda) as ordTienda, sum(ncredito) as ncredito,
                         sum(ordncredito) as ordncredito

                  from montos

                  where tienda not in ('Paris Internet') and fecha between $buscaractAnt and $buscarantAnt";

    $res = $con->query($query);

    $montoAnt = 0;

    $sumOrdAnt = 0;

    $sumNAnt = 0;

    $sumONAnt = 0;

    while($row = mysqli_fetch_assoc($res)){
        $montoAnt = $row['monto'];
        $sumOrdAnt = $row['ordTienda'];
        $sumNAnt = $row['ncredito'];
        $sumONAnt = $row['ordncredito'];
    }

    $ingresonetoAnt = round(($montoAnt - $sumNAnt) / 1.19);

    $ordenesnetoAnt = $sumOrdAnt - $sumONAnt;

    $ticketproAnt = 0;
    if($ordenesnetoAnt > 0)
        $ticketproAnt = $ingresonetoAnt/$ordenesnetoAnt;

    $rpast = 0;
    if($ingresonetoAnt != 0)
        $rpast = round((($ingresoneto / $ingresonetoAnt) - 1) * 100);

    $label = "";

    if($rpast > 0)
        $label = "label label-success";

    if($rpast == 0)
        $label = "label label-warning";

    if($rpast < 0)
        $label = "label label-danger";

    echo "<tr><td class='text-center' style='background-color: #D1E0EC;'><h6 style='font-size: 14px;'><b>Total C&C</b></h6></td>";
    echo "<td class='text-center' style='background-color: #D1E0EC;'><h6>" . number_format($monto, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center' style='background-color: #D1E0EC;'><h6>" . number_format($sumOrd, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center' style='background-color: #D1E0EC;'><h6>" . number_format($sumN, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center' style='background-color: #D1E0EC;'><h6>" . number_format($sumON, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center' style='background-color: #D1E0EC;'><h6>" . number_format($ingresoneto, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center' style='background-color: #D1E0EC;'><h6>" . number_format($ordenesneto, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center' style='border-right: 10px solid white; background-color: #D1E0EC;''><h6>" . number_format($ticketpro, 0, ',', '.') . "</h6></td>";

    echo "<td class='text-center' style='background-color: #D1E0EC;'><h6>" . number_format($ingresonetoAnt, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center' style='background-color: #D1E0EC;'><h6>" . number_format($ordenesnetoAnt, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center' style='background-color: #D1E0EC;'><h6>" . number_format($ticketproAnt, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center' style='background-color: #D1E0EC;'><h5 class='$label'>" . number_format($rpast, 0, ',', '.') . " %</h5></td>";

    //COMIENZO DE CALCULO POR TIENDA

    //COMIENZO PARIS

    tienda($con, 'Paris', $buscaract, $buscarant, $buscaractAnt, $buscarantAnt);

    //=========================================== FIN PARIS ============================================================

    //COMIENZO JOHNSON

    tienda($con, 'Johnson', $buscaract, $buscarant, $buscaractAnt, $buscarantAnt);

    //=========================================== FIN JOHNSON =========================================================

    //COMIENZO EASY

    tienda($con, 'Easy', $buscaract, $buscarant, $buscaractAnt, $buscarantAnt);

    //======================================== FIN EASY ============================================================

    //COMIENZO JUMBO

    tienda($con, 'Jumbo', $buscaract, $buscarant, $buscaractAnt, $buscarantAnt);

    // ================================= FIN JUMBO =====================================================

    //COMIENZO SANTA ISABEL

    tienda($con, 'Santa Isabel', $buscaract, $buscarant, $buscaractAnt, $buscarantAnt);

    //========================================= FIN SANTA ISABEL ================================================
}

?>

<script src="jquery-1.12.0.min.js"></script>
<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script src="bootstrap-select-1.9.4/dist/js/bootstrap-select.min.js"></script>
<script src="jquery.stickytableheaders.js"></script>
<script>
    $('table').stickyTableHeaders();
</script>
<script>
    function mostrar(id){
        var estado = document.querySelectorAll(id);
        var cant   = estado.length;

        for(var i = 0; i < cant; i++){
            var vista = estado[i].style.display;
            if(vista == 'none')
                vista = 'table-cell';
            else
                vista = 'none';
            estado[i].style.display = vista;
        }
    }
</script>
</body>
</html>