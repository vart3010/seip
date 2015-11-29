<?php

namespace Pequiven\SEIPBundle\Controller\Sip;

use Pequiven\SEIPBundle\Controller\SEIPController;
use Symfony\Component\HttpFoundation\Request;
use Pequiven\SEIPBundle\Form\Sip\ReportType;
use Pequiven\SEIPBundle\Repository\Sip\reportSIPRepository;

/**
 * Controlador de gráficos en el SEIP
 *
 */
class ReportSIPController extends SEIPController {

    public function showAction(Request $request) {

        return $this->render('PequivenSEIPBundle:Sip:showReport.html.twig', array(
                    'user' => $this->getUser(),
        ));
    }

    public function AssistAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        $date = $request->get("asist");

        $result = $this->get('pequiven.repository.report')->getAsist($date);

        $path = $this->get('kernel')->locateResource('@PequivenSEIPBundle/Resources/Skeleton/Sip/Asistencia.xlsx');
        $objPHPExcel = \PHPExcel_IOFactory::load($path);
        $objPHPExcel
                ->getProperties()
                ->setCreator("SEIP")
                ->setTitle('SIP - Asistencia del día ' . $date)
                ->setCreated()
                ->setLastModifiedBy('SIP')
                ->setModified()
        ;
        $objPHPExcel
                ->setActiveSheetIndex(0);


        $activeSheet = $objPHPExcel->getActiveSheet();

        $activeSheet->setCellValue('K2', $date);
        $row = 4; //Fila Inicial del skeleton

        foreach ($result as $fila) {

            $activeSheet->setCellValue('A' . $row, $date);
            $activeSheet->setCellValue('B' . $row, $fila["Estado"]);
            $activeSheet->setCellValue('C' . $row, $fila["Municipio"]);
            $activeSheet->setCellValue('D' . $row, $fila["Parroquia"]);
            $activeSheet->setCellValue('E' . $row, $fila["Eje"]);
            $activeSheet->setCellValue('F' . $row, $fila["Codigo"]);
            $activeSheet->setCellValue('G' . $row, $fila["Centro"]);
            $activeSheet->setCellValue('H' . $row, $fila["Cedula"]);
            $activeSheet->setCellValue('I' . $row, $fila["Nombre"]);
            $activeSheet->setCellValue('J' . $row, $fila["Telefono"]);
            $activeSheet->setCellValue('K' . $row, $fila["Asistencia"]);
            $activeSheet->setCellValue('L' . $row, $fila["Observaciones"]);
            $activeSheet->setCellValue('M' . $row, $fila["StatusAct"]);
            $activeSheet->setCellValue('N' . $row, $fila["ObservacionesStatus"]);
            $row++;
        }

        $fileName = sprintf('SIP - Asistencia de Cutls %s.xlsx', str_replace("/", "-", $date));

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
        exit;
    }

    public function AssistHistoryAction() {

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        $date = date("d/m/Y");

        $result = $this->get('pequiven.repository.report')->getAsistHistory();

        $path = $this->get('kernel')->locateResource('@PequivenSEIPBundle/Resources/Skeleton/Sip/Historico_Asistencia.xlsx');
        $objPHPExcel = \PHPExcel_IOFactory::load($path);
        $objPHPExcel
                ->getProperties()
                ->setCreator("SEIP")
                ->setTitle('SIP - Historico de Asistencias ' . $date)
                ->setCreated()
                ->setLastModifiedBy('SIP')
                ->setModified()
        ;
        $objPHPExcel
                ->setActiveSheetIndex(0);


        $activeSheet = $objPHPExcel->getActiveSheet();

        $activeSheet->setCellValue('I3', $date);
        $row = 6; //Fila Inicial del skeleton

        foreach ($result as $fila) {

            $activeSheet->setCellValue('A' . $row, $fila["Estado"]);
            $activeSheet->setCellValue('B' . $row, $fila["Municipio"]);
            $activeSheet->setCellValue('C' . $row, $fila["Parroquia"]);
            $activeSheet->setCellValue('D' . $row, $fila["eje"]);
            $activeSheet->setCellValue('E' . $row, $fila["Codigo"]);
            $activeSheet->setCellValue('F' . $row, $fila["Centro"]);
            $activeSheet->setCellValue('G' . $row, $fila["Cedula"]);
            $activeSheet->setCellValue('H' . $row, $fila["Nombre"]);
            $activeSheet->setCellValue('I' . $row, $fila["Telefono"]);
            $activeSheet->setCellValue('J' . $row, $fila["Asist08112015"]);
            $activeSheet->setCellValue('K' . $row, $fila["Asist09112015"]);
            $activeSheet->setCellValue('L' . $row, $fila["Asist10112015"]);
            $activeSheet->setCellValue('M' . $row, $fila["Asist11112015"]);
            $activeSheet->setCellValue('N' . $row, $fila["Asist12112015"]);
            $activeSheet->setCellValue('O' . $row, $fila["Asist13112015"]);
            $activeSheet->setCellValue('P' . $row, $fila["Asist14112015"]);
            $activeSheet->setCellValue('Q' . $row, $fila["Asist15112015"]);
            $activeSheet->setCellValue('R' . $row, $fila["Asist16112015"]);
            $activeSheet->setCellValue('S' . $row, $fila["Asist17112015"]);
            $activeSheet->setCellValue('T' . $row, $fila["Asist18112015"]);
            $activeSheet->setCellValue('U' . $row, $fila["Asist19112015"]);
            $activeSheet->setCellValue('V' . $row, $fila["Asist20112015"]);
            $activeSheet->setCellValue('W' . $row, $fila["Asist21112015"]);
            $activeSheet->setCellValue('X' . $row, $fila["Asist22112015"]);
            $activeSheet->setCellValue('Y' . $row, $fila["Asist23112015"]);
            $activeSheet->setCellValue('Z' . $row, $fila["Asist24112015"]);
            $activeSheet->setCellValue('AA' . $row, $fila["Asist25112015"]);
            $activeSheet->setCellValue('AB' . $row, $fila["Asist26112015"]);
            $activeSheet->setCellValue('AC' . $row, $fila["Asist27112015"]);
            $activeSheet->setCellValue('AD' . $row, $fila["Asist28112015"]);
            $activeSheet->setCellValue('AE' . $row, $fila["Asist29112015"]);
            $activeSheet->setCellValue('AF' . $row, $fila["Asist30112015"]);
            $activeSheet->setCellValue('AG' . $row, $fila["Asist01122015"]);
            $activeSheet->setCellValue('AH' . $row, $fila["Asist02122015"]);
            $activeSheet->setCellValue('AI' . $row, $fila["Asist03122015"]);
            $activeSheet->setCellValue('AJ' . $row, $fila["Asist04122015"]);
            $activeSheet->setCellValue('AK' . $row, $fila["Asist05122015"]);
            $activeSheet->setCellValue('AL' . $row, $fila["Asist06122015"]);
            $activeSheet->setCellValue('AM' . $row, '=CONTAR.SI(J' . $row . ':AL' . $row . ';"P")');
            $activeSheet->setCellValue('AN' . $row, '=(AM' . $row . '/(($I$3-$G$3)+1))');

            $row++;
        }

        $fileName = sprintf('SIP - Asistencia Historica de Cutls %s.xlsx', str_replace("/", "-", $date));

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
        exit;
    }

    public function ActiveHistoryAction() {

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        $date = date("d/m/Y");

        $result = $this->get('pequiven.repository.report')->getActiveHistory();

        $path = $this->get('kernel')->locateResource('@PequivenSEIPBundle/Resources/Skeleton/Sip/Historico_Status.xlsx');
        $objPHPExcel = \PHPExcel_IOFactory::load($path);
        $objPHPExcel
                ->getProperties()
                ->setCreator("SEIP")
                ->setTitle('SIP - Historico de Status ' . $date)
                ->setCreated()
                ->setLastModifiedBy('SIP')
                ->setModified()
        ;
        $objPHPExcel
                ->setActiveSheetIndex(0);


        $activeSheet = $objPHPExcel->getActiveSheet();

        $activeSheet->setCellValue('L3', $date);
        $row = 6; //Fila Inicial del skeleton

        foreach ($result as $fila) {

            $activeSheet->setCellValue('A' . $row, $fila["Estado"]);
            $activeSheet->setCellValue('B' . $row, $fila["Municipio"]);
            $activeSheet->setCellValue('C' . $row, $fila["Parroquia"]);
            $activeSheet->setCellValue('D' . $row, $fila["eje"]);
            $activeSheet->setCellValue('E' . $row, $fila["Codigo"]);
            $activeSheet->setCellValue('F' . $row, $fila["Centro"]);
            $activeSheet->setCellValue('G' . $row, $fila["Status08112015"]);
            $activeSheet->setCellValue('H' . $row, $fila["Status09112015"]);
            $activeSheet->setCellValue('I' . $row, $fila["Status10112015"]);
            $activeSheet->setCellValue('J' . $row, $fila["Status11112015"]);
            $activeSheet->setCellValue('K' . $row, $fila["Status12112015"]);
            $activeSheet->setCellValue('L' . $row, $fila["Status13112015"]);
            $activeSheet->setCellValue('M' . $row, $fila["Status14112015"]);
            $activeSheet->setCellValue('N' . $row, $fila["Status15112015"]);
            $activeSheet->setCellValue('O' . $row, $fila["Status16112015"]);
            $activeSheet->setCellValue('P' . $row, $fila["Status17112015"]);
            $activeSheet->setCellValue('Q' . $row, $fila["Status18112015"]);
            $activeSheet->setCellValue('R' . $row, $fila["Status19112015"]);
            $activeSheet->setCellValue('S' . $row, $fila["Status20112015"]);
            $activeSheet->setCellValue('T' . $row, $fila["Status21112015"]);
            $activeSheet->setCellValue('U' . $row, $fila["Status22112015"]);
            $activeSheet->setCellValue('V' . $row, $fila["Status23112015"]);
            $activeSheet->setCellValue('W' . $row, $fila["Status24112015"]);
            $activeSheet->setCellValue('X' . $row, $fila["Status25112015"]);
            $activeSheet->setCellValue('Y' . $row, $fila["Status26112015"]);
            $activeSheet->setCellValue('Z' . $row, $fila["Status27112015"]);
            $activeSheet->setCellValue('AA' . $row, $fila["Status28112015"]);
            $activeSheet->setCellValue('AB' . $row, $fila["Status29112015"]);
            $activeSheet->setCellValue('AC' . $row, $fila["Status30112015"]);
            $activeSheet->setCellValue('AD' . $row, $fila["Status01122015"]);
            $activeSheet->setCellValue('AE' . $row, $fila["Status02122015"]);
            $activeSheet->setCellValue('AF' . $row, $fila["Status03122015"]);
            $activeSheet->setCellValue('AG' . $row, $fila["Status04122015"]);
            $activeSheet->setCellValue('AH' . $row, $fila["Status05122015"]);
            $activeSheet->setCellValue('AI' . $row, $fila["Status06122015"]);
            $activeSheet->setCellValue('AJ' . $row, '=CONTAR.SI(G' . $row . ':AI' . $row . ';"A")');
            $activeSheet->setCellValue('AK' . $row, '=(AJ' . $row . '/(($L$3-$F$3)+1))');

            $row++;
        }

        $fileName = sprintf('SIP -  Historico de Actividad de Puntos Rojos %s.xlsx', str_replace("/", "-", $date));

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);
        $objWriter->save('php://output');
        exit;
    }

}
