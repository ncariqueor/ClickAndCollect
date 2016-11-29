<?php
date_default_timezone_set("America/Santiago");
ini_set("max_execution_time", 0);
require_once 'Classes/PHPExcel.php';

$mes  = $_GET['mes'];
$anio = $_GET['anio'];

$buscaract = $anio . $mes;

$tienda = $_GET['tienda'];

$con = new mysqli('localhost', 'root', '', 'clickcollect');

$excel = new PHPExcel();

$excel->getProperties()->setCreator("Operaciones")
    ->setLastModifiedBy("Operaciones")
    ->setTitle("Panel Click & Collect");

$titulo = "Panel Click & Collect Mes " . nommes($mes) . " de " . $anio . " - " . $tienda;

$titulos1 = array('Fecha', 'Ingreso Bruto', 'Notas de Crédito', 'Ingreso Neto (Sin IVA)', 'Costo Venta', 'Contribución', 'Márgen');

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

$query = "select ingresobruto, ordTienda, ncredito, ordncredito, costo, fecha

                              from montos

                              where tienda = '$tienda' and fecha like '" . $buscaract . "%' order by fecha desc";

$res = $con->query($query);

$i = 4;
while($row = mysqli_fetch_assoc($res)){
    $ingresobruto = $row['ingresobruto'];
    $ordTienda = $row['ordTienda'];
    $ncredito = $row['ncredito'];
    $ordncredito = $row['ordncredito'];
    $costo = $row['costo'];
    $fecha = new DateTime($row['fecha']);

    $ingresoneto = round(($ingresobruto - $ncredito) / 1.19);

    $ordneto = $ordTienda - $ordncredito;

    $contribucion = $ingresoneto - $costo;

    $margen = 0;
    if($ingresoneto != 0)
        $margen = $contribucion / $ingresoneto;

    $excel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, diasem($fecha->format("D")) . ", " . $fecha->format("d-m-Y"))
        ->setCellValue('B'.$i, $ingresobruto)
        ->setCellValue('C'.$i, $ordTienda)
        ->setCellValue('D'.$i, $ncredito)
        ->setCellValue('E'.$i, $ordncredito)
        ->setCellValue('F'.$i, $ingresoneto)
        ->setCellValue('G'.$i, $ordneto)
        ->setCellValue('H'.$i, $costo)
        ->setCellValue('I'.$i, $contribucion)
        ->setCellValue('J'.$i, $margen);

    if($margen*100 > 0)
        $excel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($colorbueno);

    if($margen*100 < 0)
        $excel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($colormalo);

    if($margen*100 == 0)
        $excel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($colormedio);

    $i++;
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
$excel->getActiveSheet()->getStyle('A4:J'.($i-1))->applyFromArray($estiloInformacion);

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

$excel->getActiveSheet()->getStyle('B4:I' . ($i-1))->getNumberFormat()->setFormatCode('#,##0');
$excel->getActiveSheet()->getStyle('J4:J' . ($i-1))->getNumberFormat()->setFormatCode('#,##0.0 %');

for($j=2; $j<=($i-1); $j++)
    $excel->getActiveSheet()->getRowDimension($j)->setRowHeight(25);

// Se asigna el nombre a la hoja
$excel->getActiveSheet()->setTitle('Panel Click & Collect');

// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
$excel->setActiveSheetIndex(0);

// Inmovilizar paneles
//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
$excel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="clickandcollecttienda.xlsx"');
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

function nommes($diasem){
    if($diasem == '01')
        return 'enero';
    if($diasem == '02')
        return 'febrero';
    if($diasem == '03')
        return 'marzo';
    if($diasem == '04')
        return 'abril';
    if($diasem == '05')
        return 'mayo';
    if($diasem == '06')
        return 'junio';
    if($diasem == '07')
        return 'julio';
    if($diasem == '08')
        return 'agosto';
    if($diasem == '09')
        return 'septiembre';
    if($diasem == '10')
        return 'octubre';
    if($diasem == '11')
        return 'noviembre';
    if($diasem == '12')
        return 'diciembre';

}