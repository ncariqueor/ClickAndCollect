<?php

function tienda($con, $tipo, $buscaract, $buscarant, $buscaractAnt, $buscarantAnt){
    $query = "select sum(ingresobruto) as monto, sum(ordTienda) as ordTienda, sum(ncredito) as ncredito,
                     sum(ordncredito) as ordncredito

                  from montos

                  where tipo = '$tipo' and tienda <> 'Paris Internet' and fecha between $buscaract and $buscarant";

    $res = $con->query($query);

    $monto = 0;
    $sumOrd = 0;
    $sumN = 0;
    $sumON = 0;
    $ingresoneto = 0;
    $ordneto = 0;
    $ticketprom = 0;

    while($row = mysqli_fetch_assoc($res)){
        $monto  = $row['monto'];
        $sumOrd = $row['ordTienda'];
        $sumN   = $row['ncredito'];
        $sumON  = $row['ordncredito'];

        $ingresoneto = round(($monto - $sumN) / 1.19);
        $ordneto     = $sumOrd - $sumON;

        $ticketprom = 0;

        if($ordneto > 0)
            $ticketprom = round($ingresoneto/$ordneto);
    }

    $query = "select sum(ingresobruto) as monto, sum(ordTienda) as ordTienda, sum(ncredito) as ncredito,
                     sum(ordncredito) as ordncredito

                  from montos

                  where tipo = '$tipo' and tienda <> 'Paris Internet' and fecha between $buscaractAnt and $buscarantAnt";

    $res = $con->query($query);

    $montoAnt = 0;
    $sumOrdAnt = 0;
    $sumNAnt = 0;
    $sumONAnt = 0;
    $ingresonetoAnt = 0;
    $ordnetoAnt = 0;
    $ticketpromAnt = 0;

    while($row = mysqli_fetch_assoc($res)){
        $montoAnt  = $row['monto'];
        $sumOrdAnt = $row['ordTienda'];
        $sumNAnt   = $row['ncredito'];
        $sumONAnt  = $row['ordncredito'];

        $ingresonetoAnt = round(($montoAnt - $sumNAnt) / 1.19);
        $ordnetoAnt     = $sumOrdAnt - $sumONAnt;

        $ticketpromAnt = 0;

        if($ordnetoAnt > 0)
            $ticketpromAnt = round($ingresonetoAnt/$ordnetoAnt);
    }

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

    $tmp = $tipo;
    if($tipo == 'Santa Isabel') {
        $tipo = 'Santa';
        $tmp = 'Santa Isabel';
    }

    echo '<tr><td class="text-center"><a href="#" title="Pinche aquí para ver tiendas ' . $tipo . '" style="text-decoration: none;" onclick="mostrar'; echo "('.$tipo'); return false;"; echo '"><b>Total C&C ' . $tmp . '</b> <span class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span></a></td>';
    echo "<td class='text-center'><h6>" . number_format($monto, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center'><h6>" . number_format($sumOrd, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center'><h6>" . number_format($sumN, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center'><h6>" . number_format($sumON, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center'><h6>" . number_format($ingresoneto, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center'><h6>" . number_format($ordneto, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center' style='border-right: 10px solid white;'><h6>" . number_format($ticketprom, 0, ',', '.') . "</h6></td>";

    echo "<td class='text-center'><h6>" . number_format($ingresonetoAnt, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center'><h6>" . number_format($ordnetoAnt, 0, ',', '.') . "</h6></td>";
    echo "<td class='text-center'><h6>" . number_format($ticketpromAnt, 0, ',', '.') . "</h6></td>";

    echo "<td class='text-center'><h6 class='$label'>" . number_format($rpast, 0, ',', '.') . " %</h6></td></tr>";


    $query = "select sum(ingresobruto) as monto, sum(ordTienda) as ordTienda, sum(ncredito) as ncredito,
                     sum(ordncredito) as ordncredito, tienda

                  from montos

                  where tipo like '$tipo%' and tienda <> 'Paris Internet' and fecha between $buscaract and $buscarant group by tienda order by monto desc";

    $res = $con->query($query);

    while($row = mysqli_fetch_assoc($res)){
        $monto  = $row['monto'];
        $sumOrd = $row['ordTienda'];
        $sumN   = $row['ncredito'];
        $sumON  = $row['ordncredito'];
        $tienda = $row['tienda'];

        $ingresoneto = round(($monto - $sumN) / 1.19);
        $ordneto     = $sumOrd - $sumON;

        $ticketprom = 0;

        if($ordneto > 0)
            $ticketprom = round($ingresoneto/$ordneto);

        $query = "select sum(ingresobruto) as monto, sum(ordTienda) as ordTienda, sum(ncredito) as ncredito,
                         sum(ordncredito) as ordncredito

                  from montos

                  where tienda = '$tienda' and fecha between $buscaractAnt and $buscarantAnt";

        $montoAnt       = 0;
        $sumOrdAnt      = 0;
        $sumNAnt        = 0;
        $sumONAnt       = 0;
        $ingresonetoAnt = 0;
        $ordnetoAnt     = 0;
        $ticketpromAnt  = 0;

        $result = $con->query($query);

        while($row = mysqli_fetch_assoc($result)){
            $montoAnt  = $row['monto'];
            $sumOrdAnt = $row['ordTienda'];
            $sumNAnt   = $row['ncredito'];
            $sumONAnt  = $row['ordncredito'];

            $ingresonetoAnt = round(($montoAnt - $sumNAnt) / 1.19);
            $ordnetoAnt     = $sumOrdAnt - $sumONAnt;

            if($ordnetoAnt > 0)
                $ticketpromAnt = round($ingresonetoAnt / $ordnetoAnt);
        }

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

        echo "<tr><td class='text-center $tipo' style='display: none;'><h6><b>" . utf8_encode($tienda) . "</b></h6></td>";
        echo "<td class='text-center $tipo' style='display: none;'><h6>" . number_format($monto, 0, ',', '.') . "</h6></td>";
        echo "<td class='text-center $tipo' style='display: none;'><h6>" . number_format($sumOrd, 0, ',', '.') . "</h6></td>";
        echo "<td class='text-center $tipo' style='display: none;'><h6>" . number_format($sumN, 0, ',', '.') . "</h6></td>";
        echo "<td class='text-center $tipo' style='display: none;'><h6>" . number_format($sumON, 0, ',', '.') . "</h6></td>";
        echo "<td class='text-center $tipo' style='display: none;'><h6>" . number_format($ingresoneto, 0, ',', '.') . "</h6></td>";
        echo "<td class='text-center $tipo' style='display: none;'><h6>" . number_format($ordneto, 0, ',', '.') . "</h6></td>";
        echo "<td class='text-center $tipo' style='border-right: 10px solid white; display: none'><h6>" . number_format($ticketprom, 0, ',', '.') . "</h6></td>";

        echo "<td class='text-center $tipo' style='display: none;'><h6>" . number_format($ingresonetoAnt, 0, ',', '.') . "</h6></td>";
        echo "<td class='text-center $tipo' style='display: none;'><h6>" . number_format($ordnetoAnt, 0, ',', '.') . "</h6></td>";
        echo "<td class='text-center $tipo' style='display: none;'><h6>" . number_format($ticketpromAnt, 0, ',', '.') . "</h6></td>";

        echo "<td class='text-center $tipo' style='display: none;'><h6 class='$label'>" . number_format($rpast, 0, ',', '.') . " %</h6></td></tr>";
    }
}