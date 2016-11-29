<?php
date_default_timezone_set("America/Santiago");
ini_set("max_execution_time", 0);
require_once 'Classes/PHPExcel.php';

$mes  = $_GET['mes'];
$anio = $_GET['anio'];
$dia  = $_GET['dia'];

$buscaract = $anio . $mes . $dia;

$mes  = $_GET['mesant'];
$anio = $_GET['anioant'];
$dia  = $_GET['diaant'];

$buscarant = $anio . $mes . $dia;

$buscaract = new DateTime($buscaract);

$buscarant = new DateTime($buscarant);

$con = new mysqli('localhost', 'root', '', 'clickcollect');

$excel = new PHPExcel();

$excel->getProperties()->setCreator("Operaciones")
    ->setLastModifiedBy("Operaciones")
    ->setTitle("Panel Click & Collect");

$titulo = "Panel Click & Collect - Entre el " . diasem($buscaract->format("D")) . ", " . $buscaract->format("d-m-Y") . " y el " . diasem($buscarant->format("D")) . ", " . $buscarant->format("d-m-Y");

$titulos1 = array('Tiendas', 'Ingreso Bruto', 'Notas de Crédito', 'Ingreso Neto (Sin IVA)', 'Costo Venta', 'Contribución', 'Márgen');

$titulos2 = array('Monto $', '#');

$excel->setActiveSheetIndex(0)
    ->mergeCells('A1:J1')

    ->mergeCells('A2:A3')
    ->mergeCells('B2:C2')
    ->mergeCells('D2:E2')
    ->mergeCells('F2:G2')
    ->mergeCells('J2:J3');

$excel->setActiveSheetIndex(0)
    ->setCellValue('A1', $titulo)

    ->setCellValue('A2', $titulos1[0])
    ->setCellValue('B2', $titulos1[1])
    ->setCellValue('D2', $titulos1[2])
    ->setCellValue('F2', $titulos1[3])
    ->setCellValue('H2', $titulos1[4])
    ->setCellValue('I2', $titulos1[5])
    ->setCellValue('J2', $titulos1[6])

    ->setCellValue('B3', $titulos2[0])
    ->setCellValue('C3', $titulos2[1])
    ->setCellValue('D3', $titulos2[0])
    ->setCellValue('E3', $titulos2[1])
    ->setCellValue('F3', $titulos2[0])
    ->setCellValue('G3', $titulos2[1])
    ->setCellValue('H3', $titulos2[0])
    ->setCellValue('I3', $titulos2[0]);

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

$actual = $buscaract->format('Ymd');

$anterior = $buscarant->format('Ymd');

$query = "select sum(ingresobruto) as monto, sum(costo) as costo, sum(ordTienda) as ordTienda, sum(ncredito) as ncredito,
                 sum(ordncredito) as ordncredito
          from montos

          where tienda = 'Paris Internet' and fecha between $actual and $anterior";

$res = $con->query($query);

$monto = 0;

$sumC = 0;

$sumOrd = 0;

$sumN = 0;

$sumON = 0;

while($row = mysqli_fetch_assoc($res)){
    $monto += $row['monto'];
    $sumC += $row['costo'];
    $sumOrd += $row['ordTienda'];
    $sumN += $row['ncredito'];
    $sumON += $row['ordncredito'];
}

$ingresoneto = round(($monto - $sumN) / 1.19);

$contribucion = $ingresoneto - $sumC;

$ordn = $sumOrd - $sumON;

$margen = 0;
if($ingresoneto != 0)
    $margen = $contribucion / $ingresoneto;

$excel->setActiveSheetIndex(0)
    ->setCellValue('A4', "Paris Internet")
    ->setCellValue('B4', $monto)
    ->setCellValue('C4', $sumOrd)
    ->setCellValue('D4', $sumN)
    ->setCellValue('E4', $sumON)
    ->setCellValue('F4', $ingresoneto)
    ->setCellValue('G4', $ordn)
    ->setCellValue('H4', $sumC)
    ->setCellValue('I4', $contribucion)
    ->setCellValue('J4', $margen);

if($margen*100 > 0)
    $excel->getActiveSheet()->getStyle('J4')->applyFromArray($colorbueno);

if($margen*100 < 0)
    $excel->getActiveSheet()->getStyle('J4')->applyFromArray($colormalo);

if($margen*100 == 0)
    $excel->getActiveSheet()->getStyle('J4')->applyFromArray($colormedio);

$query = "select tienda2 from tiendas";

$res = $con->query($query);

$tienda[] = array();

$i = 0;

while($row = mysqli_fetch_assoc($res)){
    $tienda[$i] = $row['tienda2'];
    $i++;
}

$cantT = count($tienda);

$ingresobruto[] = array();
$ordingresobruto[] = array();
$ncredito[] = array();
$ordncredito[] = array();
$ineto[] = array();
$ordneto[] = array();
$sumcosto[] = array();
$contr[] = array();
$marg[] = array();

for($i=0; $i<$cantT; $i++) {
    $shop = $tienda[$i];

    $query = "select tienda, sum(ingresobruto) as monto, sum(costo) as costo, sum(ordTienda) as ordTienda, sum(ncredito) as ncredito,
                             sum(ordncredito) as ordncredito

                      from montos

                      where tienda = '$shop' and fecha between $actual and $anterior group by tienda order by monto asc";

    $res = $con->query($query);

    $monto = 0;

    $sumC = 0;

    $sumOrd = 0;

    $sumN = 0;

    $sumON = 0;

    while ($row = mysqli_fetch_assoc($res)) {
        $monto += $row['monto'];
        $sumC += $row['costo'];
        $sumOrd += $row['ordTienda'];
        $sumN += $row['ncredito'];
        $sumON += $row['ordncredito'];
    }

    $ingresoneto = round(($monto - $sumN) / 1.19);

    $contribucion = $ingresoneto - $sumC;

    $margen = 0;
    if ($ingresoneto != 0)
        $margen = $contribucion / $ingresoneto;

    $ingresobruto[$i] = $monto;
    $ordingresobruto[$i] = $sumOrd;
    $ncredito[$i] = $sumN;
    $ordncredito[$i] = $sumON;
    $sumcosto[$i] = $sumC;
    $ineto[$i] = $ingresoneto;
    $ordneto[$i] = $sumOrd - $sumON;
    $contr[$i] = $contribucion;
    $marg[$i] = $margen;
}

for($i = 1; $i < $cantT; $i++){
    for($j = 0; $j < ($cantT - $i); $j++){
        if($ineto[$j] < $ineto[$j + 1]){
            $auxtienda = $tienda[$j];
            $auxineto = $ineto[$j];
            $auxingresobruto = $ingresobruto[$j];
            $auxordingresobruo = $ordingresobruto[$j];
            $auxncredito = $ncredito[$j];
            $auxordncredito = $ordncredito[$j];
            $auxsumcosto = $sumcosto[$j];
            $auxordneto = $ordneto[$j];
            $auxcontr = $contr[$j];
            $auxmarg = $marg[$j];

            $tienda[$j] = $tienda[$j+1];
            $ineto[$j] = $ineto[$j+1];
            $ingresobruto[$j] = $ingresobruto[$j+1];
            $ordingresobruto[$j] = $ordingresobruto[$j+1];
            $ncredito[$j] = $ncredito[$j+1];
            $ordncredito[$j] = $ordncredito[$j+1];
            $sumcosto[$j] = $sumcosto[$j+1];
            $ordneto[$j] = $ordneto[$j+1];
            $contr[$j] = $contr[$j+1];
            $marg[$j] = $marg[$j+1];

            $tienda[$j+1] = $auxtienda;
            $ineto[$j+1] = $auxineto;
            $ingresobruto[$j+1] = $auxingresobruto;
            $ordingresobruto[$j+1] = $auxordingresobruo;
            $ncredito[$j+1] = $auxncredito;
            $ordncredito[$j+1] = $auxordncredito;
            $sumcosto[$j+1] = $auxsumcosto;
            $ordneto[$j+1] = $auxordneto;
            $contr[$j+1] = $auxcontr;
            $marg[$j+1] = $auxmarg;
        }
    }
}

$j = 5;
for($i=0; $i<$cantT; $i++){
    if($tienda[$i] == 'Nunoa')
        $tienda[$i] = "Ñuñoa";

    if($tienda[$i] == 'Estacion Central')
        $tienda[$i] = "Estación Central";

    $excel->setActiveSheetIndex(0)
        ->setCellValue('A'.$j, $tienda[$i])
        ->setCellValue('B'.$j, $ingresobruto[$i])
        ->setCellValue('C'.$j, $ordingresobruto[$i])
        ->setCellValue('D'.$j, $ncredito[$i])
        ->setCellValue('E'.$j, $ordncredito[$i])
        ->setCellValue('F'.$j, $ineto[$i])
        ->setCellValue('G'.$j, $ordneto[$i])
        ->setCellValue('H'.$j, $sumcosto[$i])
        ->setCellValue('I'.$j, $contr[$i])
        ->setCellValue('J'.$j, $marg[$i]);

    if($marg[$i]*100 > 0)
        $excel->getActiveSheet()->getStyle('J'.$j)->applyFromArray($colorbueno);

    if($marg[$i]*100 < 0)
        $excel->getActiveSheet()->getStyle('J'.$j)->applyFromArray($colormalo);

    if($marg[$i]*100 == 0)
        $excel->getActiveSheet()->getStyle('J'.$j)->applyFromArray($colormedio);

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
        'size' => '20',
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


$excel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($color1);
$excel->getActiveSheet()->getStyle('A2:A3')->applyFromArray($color2);
$excel->getActiveSheet()->getStyle('B2:E3')->applyFromArray($color3);
$excel->getActiveSheet()->getStyle('F2:H3')->applyFromArray($color2);
$excel->getActiveSheet()->getStyle('I2:J3')->applyFromArray($color4);
$excel->getActiveSheet()->getStyle('I2:J3')->applyFromArray($color4);
$excel->getActiveSheet()->getStyle('A4:J'.($j-1))->applyFromArray($estiloInformacion);

$excel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth('25');
$excel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth('25');
$excel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth('25');
$excel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth('25');
$excel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth('25');
$excel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth('25');
$excel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth('25');
$excel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth('25');
$excel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth('25');
$excel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth('25');

$excel->getActiveSheet()->getStyle('B4:I' . ($j-1))->getNumberFormat()->setFormatCode('#,##0');
$excel->getActiveSheet()->getStyle('J4:J' . ($j-1))->getNumberFormat()->setFormatCode('#,##0.0 %');

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