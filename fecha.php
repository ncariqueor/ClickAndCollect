<?php
date_default_timezone_set("America/Santiago");
ini_set("max_execution_time", 0);
require_once 'Classes/PHPExcel.php';
require_once 'fecha_es.php';

$mes  = $_GET['mes'];
$anio = $_GET['anio'];
$dia  = $_GET['dia'];

$buscaract = $anio . $mes . $dia;

$mes  = $_GET['mesant'];
$anio = $_GET['anioant'];
$dia  = $_GET['diaant'];

$buscarant = $anio . $mes . $dia;

$buscaractAnt = date("Ymd", strtotime("{$buscaract} -1 year"));

$buscarantAnt = date("Ymd", strtotime("{$buscarant} -1 year"));

$con = new mysqli('localhost', 'root', '', 'clickcollect');

$excel = new PHPExcel();

$excel->getProperties()->setCreator("Operaciones")
    ->setLastModifiedBy("Operaciones")
    ->setTitle("Panel Click & Collect");

$titulo_general_1 = "Click & Collect entre " . obtenerDia(date("D", strtotime("{$buscaract}"))) . ", " . date("d/m/Y", strtotime("{$buscaract}")) . " y " . obtenerDia(date("D", strtotime("{$buscarant}"))) . ", " . date("d/m/Y", strtotime("{$buscarant}")) . " (actual).";

$titulo_general_2 = "Click & Collect entre " . obtenerDia(date("D", strtotime("{$buscaractAnt}"))) . ", " . date("d/m/Y", strtotime("{$buscaractAnt}")) . " y " . obtenerDia(date("D", strtotime("{$buscarantAnt}"))) . ", " . date("d/m/Y", strtotime("{$buscarantAnt}")) . " (anterior).";

$titulos1 = array('Tiendas', 'Ingreso Bruto', 'Notas de Crédito', 'Ingreso Neto (Sin IVA)', '% R/Past');

$titulos2 = array('Monto $', '#', 'Ticket Promedio');

$excel->setActiveSheetIndex(0)
    ->mergeCells('B1:H1') //Titulo 1
    ->mergeCells('I1:L1') //Titulo 2

    ->mergeCells('A1:A3') //Tiendas
    ->mergeCells('B2:C2') //Ingreso Bruto
    ->mergeCells('D2:E2') //Notas de Crédito
    ->mergeCells('F2:H2') //Ingreso Neto actual
    ->mergeCells('I2:K2') //Ingreso Neto anterior
    ->mergeCells('L2:L3');// %R/past

$excel->setActiveSheetIndex(0)
    ->setCellValue('B1', $titulo_general_1)
    ->setCellValue('I1', $titulo_general_2)

    ->setCellValue('A1', $titulos1[0])
    ->setCellValue('B2', $titulos1[1])
    ->setCellValue('D2', $titulos1[2])
    ->setCellValue('F2', $titulos1[3])
    ->setCellValue('I2', $titulos1[3])
    ->setCellValue('L2', $titulos1[4])

    ->setCellValue('B3', $titulos2[0])
    ->setCellValue('C3', $titulos2[1])
    ->setCellValue('D3', $titulos2[0])
    ->setCellValue('E3', $titulos2[1])
    ->setCellValue('F3', $titulos2[0])
    ->setCellValue('G3', $titulos2[1])
    ->setCellValue('H3', $titulos2[2])
    ->setCellValue('I3', $titulos2[0])
    ->setCellValue('J3', $titulos2[1])
    ->setCellValue('K3', $titulos2[2]);

$colormalo = array(
    'font' => array(
        'name'  => 'Calibri',
        'color' => array(
            'rgb' => '862828'
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'rgb' => 'D48484'
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'rotation' => 0,
        'wrap' => TRUE
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
            'color' => array(
                'rgb' => 'dddddd'
            )
        )
    )
);

$colorbueno = array(
    'font' => array(
        'name'  => 'Calibri',
        'color' => array(
            'rgb' => '26520E'
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'rgb' => '76AE6C'
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'rotation' => 0,
        'wrap' => TRUE
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
            'color' => array(
                'rgb' => 'dddddd'
            )
        )
    )
);

$colormedio = array(
    'font' => array(
        'name'  => 'Calibri',
        'color' => array(
            'rgb' => '717018'
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'rgb' => 'F3F16D'
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'rotation' => 0,
        'wrap' => TRUE
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
            'color' => array(
                'rgb' => 'dddddd'
            )
        )
    )
);

$query = "select tienda2 from tiendas order by tienda2 asc";

$tienda = array();

$ingreso_bruto_act     = array();
$ord_ingreso_bruto_act = array();
$nota_credito_act      = array();
$ord_nota_credito_act  = array();

$ingreso_bruto_ant     = array();
$ord_ingreso_bruto_ant = array();
$nota_credito_ant      = array();
$ord_nota_credito_ant  = array();

$res = $con->query($query);

$i = 0;

while($row = mysqli_fetch_assoc($res)){
    $tienda[$i] = $row['tienda2'];

    $ingreso_bruto_act[$i]     = 0;
    $ord_ingreso_bruto_act[$i] = 0;
    $nota_credito_act[$i]      = 0;
    $ord_nota_credito_act[$i]  = 0;

    $ingreso_bruto_ant[$i]     = 0;
    $ord_ingreso_bruto_ant[$i] = 0;
    $nota_credito_ant[$i]      = 0;
    $ord_nota_credito_ant[$i]  = 0;

    $i++;
}

//ACTUAL

$query = "select sum(ingresobruto) as monto, sum(ordTienda) as ordTienda, sum(ncredito) as ncredito,
                 sum(ordncredito) as ordncredito, tienda

          from montos

          where tienda <> 'Paris Internet' and fecha between $buscaract and $buscarant group by tienda order by monto asc";

$res = $con->query($query);

while($row = mysqli_fetch_assoc($res)){
    $i                         = array_search($row['tienda'], $tienda);
    $ingreso_bruto_act[$i]     = $row['monto'];
    $ord_ingreso_bruto_act[$i] = $row['ordTienda'];
    $nota_credito_act[$i]      = $row['ncredito'];
    $ord_nota_credito_act[$i]  = $row['ordncredito'];
}

//ANTERIOR

$query = "select sum(ingresobruto) as monto, sum(ordTienda) as ordTienda, sum(ncredito) as ncredito,
                 sum(ordncredito) as ordncredito, tienda

          from montos

          where tienda <> 'Paris Internet' and fecha between $buscaractAnt and $buscarantAnt group by tienda order by monto asc";

$res = $con->query($query);

while($row = mysqli_fetch_assoc($res)){
    $i                         = array_search($row['tienda'], $tienda);
    $ingreso_bruto_ant[$i]     = $row['monto'];
    $ord_ingreso_bruto_ant[$i] = $row['ordTienda'];
    $nota_credito_ant[$i]      = $row['ncredito'];
    $ord_nota_credito_ant[$i]  = $row['ordncredito'];
}

$cant = count($tienda);

$total_ingreso_bruto_act     = 0;
$total_ord_ingreso_bruto_act = 0;
$total_nota_credito_act      = 0;
$total_ord_nota_credito_act  = 0;

$total_ingreso_bruto_ant     = 0;
$total_ord_ingreso_bruto_ant = 0;
$total_nota_credito_ant      = 0;
$total_ord_nota_credito_ant  = 0;

for($i = 0; $i < $cant; $i++){
    $total_ingreso_bruto_act     += $ingreso_bruto_act[$i];
    $total_ord_ingreso_bruto_act += $ord_ingreso_bruto_act[$i];
    $total_nota_credito_act      += $nota_credito_act[$i];
    $total_ord_nota_credito_act  += $ord_nota_credito_act[$i];

    $total_ingreso_bruto_ant     += $ingreso_bruto_ant[$i];
    $total_ord_ingreso_bruto_ant += $ord_ingreso_bruto_ant[$i];
    $total_nota_credito_ant      += $nota_credito_ant[$i];
    $total_ord_nota_credito_ant  += $ord_nota_credito_ant[$i];
}

$total_ingreso_neto_act = round(($total_ingreso_bruto_act - $total_nota_credito_act) / 1.19);

$total_ord_ingreso_neto_act = $total_ord_ingreso_bruto_act - $total_ord_nota_credito_act;

$total_ingreso_neto_ant = round(($total_ingreso_bruto_ant - $total_nota_credito_ant) / 1.19);

$total_ord_ingreso_neto_ant = $total_ord_ingreso_bruto_ant - $total_ord_nota_credito_ant;

$ticketpro = 0;
if($total_ord_ingreso_neto_act != 0)
    $ticketpro = round($total_ingreso_neto_act / $total_ord_ingreso_neto_act);

$ticketproAnt = 0;
if($total_ord_ingreso_neto_ant != 0)
    $ticketproAnt = round($total_ingreso_neto_ant / $total_ord_ingreso_neto_ant);

$rpast = 0;
if($total_ingreso_neto_ant != 0)
    $rpast = round((($total_ingreso_neto_act / $total_ingreso_neto_ant) - 1) * 100);

$excel->setActiveSheetIndex(0)
    ->setCellValue('A4', "Total C&C")
    ->setCellValue('B4', $total_ingreso_bruto_act)
    ->setCellValue('C4', $total_ord_ingreso_bruto_act)
    ->setCellValue('D4', $total_nota_credito_act)
    ->setCellValue('E4', $total_ord_nota_credito_act)
    ->setCellValue('F4', $total_ingreso_neto_act)
    ->setCellValue('G4', $total_ord_ingreso_neto_act)
    ->setCellValue('H4', $ticketpro)
    ->setCellValue('I4', $total_ingreso_neto_ant)
    ->setCellValue('J4', $total_ord_ingreso_neto_ant)
    ->setCellValue('K4', $ticketproAnt)
    ->setCellValue('L4', $rpast);

if($rpast > 0)
    $excel->getActiveSheet()->getStyle('L4')->applyFromArray($colorbueno);

if($rpast < 0)
    $excel->getActiveSheet()->getStyle('L4')->applyFromArray($colormalo);

if($rpast == 0)
    $excel->getActiveSheet()->getStyle('L4')->applyFromArray($colormedio);

for($i = 1; $i < ($cant - 1); $i++){
    for($j = 0; $j < ($cant - 2); $j++){
        if($ingreso_bruto_act[$j] < $ingreso_bruto_act[$j+1]){
            $tmp_tienda = $tienda[$j];
            $tienda[$j] = $tienda[$j+1];
            $tienda[$j+1] = $tmp_tienda;

            $tmp_ingreso_bruto_act = $ingreso_bruto_act[$j];
            $ingreso_bruto_act[$j] = $ingreso_bruto_act[$j+1];
            $ingreso_bruto_act[$j+1] = $tmp_ingreso_bruto_act;

            $tmp_ord_ingreso_bruto_act = $ord_ingreso_bruto_act[$j];
            $ord_ingreso_bruto_act[$j] = $ord_ingreso_bruto_act[$j+1];
            $ord_ingreso_bruto_act[$j+1] = $tmp_ord_ingreso_bruto_act;

            $tmp_nota_credito_act = $nota_credito_act[$j];
            $nota_credito_act[$j] = $nota_credito_act[$j+1];
            $nota_credito_act[$j+1] = $tmp_nota_credito_act;

            $tmp_ord_nota_credito_act = $ord_nota_credito_act[$j];
            $ord_nota_credito_act[$j] = $ord_nota_credito_act[$j+1];
            $ord_nota_credito_act[$j+1] = $tmp_ord_nota_credito_act;

            $tmp_ingreso_bruto_ant = $ingreso_bruto_ant[$j];
            $ingreso_bruto_ant[$j] = $ingreso_bruto_ant[$j+1];
            $ingreso_bruto_ant[$j+1] = $tmp_ingreso_bruto_ant;

            $tmp_ord_ingreso_bruto_ant = $ord_ingreso_bruto_ant[$j];
            $ord_ingreso_bruto_ant[$j] = $ord_ingreso_bruto_ant[$j+1];
            $ord_ingreso_bruto_ant[$j+1] = $tmp_ord_ingreso_bruto_ant;

            $tmp_nota_credito_ant = $nota_credito_ant[$j];
            $nota_credito_ant[$j] = $nota_credito_ant[$j+1];
            $nota_credito_ant[$j+1] = $tmp_nota_credito_ant;

            $tmp_ord_nota_credito_ant = $ord_nota_credito_ant[$j];
            $ord_nota_credito_ant[$j] = $ord_nota_credito_ant[$j+1];
            $ord_nota_credito_ant[$j+1] = $tmp_ord_nota_credito_ant;
        }
    }
}

$j = 5;

for($i = 0; $i < $cant; $i++){
    $ingreso_neto_act = round(($ingreso_bruto_act[$i] - $nota_credito_act[$i]) / 1.19);
    $ord_ingreso_neto_act = $ord_ingreso_bruto_act[$i] - $ord_nota_credito_act[$i];

    $ingreso_neto_ant = round(($ingreso_bruto_ant[$i] - $nota_credito_ant[$i]) / 1.19);
    $ord_ingreso_neto_ant = $ord_ingreso_bruto_ant[$i] - $ord_nota_credito_ant[$i];

    $ticketpro = 0;
    if($ord_ingreso_neto_act != 0)
        $ticketpro = round($ingreso_neto_act / $ord_ingreso_neto_act);

    $ticketproAnt = 0;
    if($ord_ingreso_neto_ant != 0)
        $ticketproAnt = round($ingreso_neto_ant / $ord_ingreso_neto_ant);

    $rpast = 0;
    if($ingreso_neto_ant != 0)
        $rpast = round((($ingreso_neto_act / $ingreso_neto_ant) - 1) * 100);

    $excel->setActiveSheetIndex(0)
        ->setCellValue("A$j", $tienda[$i])
        ->setCellValue("B$j", $ingreso_bruto_act[$i])
        ->setCellValue("C$j", $ord_ingreso_bruto_act[$i])
        ->setCellValue("D$j", $nota_credito_act[$i])
        ->setCellValue("E$j", $ord_nota_credito_act[$i])
        ->setCellValue("F$j", $ingreso_neto_act)
        ->setCellValue("G$j", $ord_ingreso_neto_act)
        ->setCellValue("H$j", $ticketpro)
        ->setCellValue("I$j", $ingreso_neto_ant)
        ->setCellValue("J$j", $ord_ingreso_neto_ant)
        ->setCellValue("K$j", $ticketproAnt)
        ->setCellValue("L$j", $rpast);

    if($rpast > 0)
        $excel->getActiveSheet()->getStyle("L$j")->applyFromArray($colorbueno);

    if($rpast < 0)
        $excel->getActiveSheet()->getStyle("L$j")->applyFromArray($colormalo);

    if($rpast == 0)
        $excel->getActiveSheet()->getStyle("L$j")->applyFromArray($colormedio);

    $j++;
}

$estiloInformacion = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'rotation' => 0,
        'wrap' => TRUE
    )
);

$color1 = array(
    'font' => array(
        'name'  => 'Calibri',
        'size' => '15',
        'color' => array(
            'rgb' => '000000'
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'rgb' => 'dddddd'
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'rotation' => 0,
        'wrap' => TRUE
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
            'color' => array(
                'rgb' => 'dddddd'
            )
        )
    )
);

$color2 = array(
    'font' => array(
        'name'  => 'Calibri',
        'bold' => 'true',
        'size' => '10',
        'color' => array(
            'rgb' => 'ffffff'
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'rgb' => '337ab7'
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'rotation' => 0,
        'wrap' => TRUE
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
            'color' => array(
                'rgb' => 'BCBCBC'
            )
        )
    )
);

$color3 = array(
    'font' => array(
        'name'  => 'Calibri',
        'bold' => 'true',
        'size' => '10',
        'color' => array(
            'rgb' => 'ffffff'
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'rgb' => '4E85FC'
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'rotation' => 0,
        'wrap' => TRUE
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
            'color' => array(
                'rgb' => 'dddddd'
            )
        )
    )
);

$color4 = array(
    'font' => array(
        'name'  => 'Calibri',
        'bold' => 'true',
        'size' => '10',
        'color' => array(
            'rgb' => 'ffffff'
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'rgb' => '7E9FE7'
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'rotation' => 0,
        'wrap' => TRUE
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
            'color' => array(
                'rgb' => 'dddddd'
            )
        )
    )
);


$excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($color1);
$excel->getActiveSheet()->getStyle('A2:A3')->applyFromArray($color2);
$excel->getActiveSheet()->getStyle('B2:E3')->applyFromArray($color3);
$excel->getActiveSheet()->getStyle('F2:H3')->applyFromArray($color2);
$excel->getActiveSheet()->getStyle('I2:L3')->applyFromArray($color4);
$excel->getActiveSheet()->getStyle('A4:L'.($j-1))->applyFromArray($estiloInformacion);

$excel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth('30');
$excel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth('20');
$excel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth('20');
$excel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth('20');
$excel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth('20');
$excel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth('20');
$excel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth('20');
$excel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth('20');
$excel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth('20');
$excel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth('20');
$excel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth('20');
$excel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth('20');

$excel->getActiveSheet()->getStyle('B4:K' . ($j - 1))->getNumberFormat()->setFormatCode('#,##0');

for($i=2; $i<=($j-1); $i++)
    $excel->getActiveSheet()->getRowDimension($i)->setRowHeight(25);

// Se asigna el nombre a la hoja
$excel->getActiveSheet()->setTitle('Panel Click & Collect');

// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
$excel->setActiveSheetIndex(0);

// Inmovilizar paneles
//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
$excel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="clickandcollectfecha.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$objWriter->save('php://output');
exit;

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