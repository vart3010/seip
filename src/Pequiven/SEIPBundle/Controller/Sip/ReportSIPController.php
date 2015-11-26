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

        $form = $this->createForm(new ReportType());

        return $this->render('PequivenSEIPBundle:Sip:showReport.html.twig', array(
                    'user' => $this->getUser(),
                    'form' => $form->createView()
        ));
    }

    public function AssistAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new ReportType());
        $form->handleRequest($request);

        $em->getConnection()->beginTransaction();

        if ($form->isSubmitted()) {
            $date = $request->get("sip_report")["date"];
            $result = $this->get('pequiven.repository.report')->getAsist($date);

            $path = $this->get('kernel')->locateResource('@PequivenSEIPBundle/Resources/Skeleton/Sip/Asistencia.xlsx');
            $now = new \DateTime();
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
            $objWriter->save('php://output');
            exit;
        }
    }

}
