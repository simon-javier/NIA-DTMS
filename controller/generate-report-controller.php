<?php 

    
    require '../connection.php';
    require '../TCPDF/tcpdf.php';


    if(isset($_POST['action']) && $_POST['action'] == 'export_pdf'){
      
        
        // $pdf = new TCPDF();
        // $pdf->SetAutoPageBreak(TRUE, 10);
        
        // $pdf->AddPage();
        // $pdf->SetFont('helvetica', '', 12);
        // $pdf->Cell(30, 10, 'Document Code', 1, 0, 'C');
        // $pdf->Cell(40, 10, 'Document Type', 1, 0, 'C');
        // $pdf->Cell(40, 10, 'Uploaded At', 1, 1, 'C');
        
        // foreach ($result as $row) {
        //     $pdf->Cell(30, 10, $row['document_code'], 1, 0, 'C');
        //     $pdf->Cell(40, 10, $row['document_type'], 1, 0, 'C');
        //     $pdf->Cell(40, 10, $row['uploaded_at'], 1, 1, 'C');
        // }
        
        // $filename = '../assets/uploaded-pdf/document_report.pdf';
        // if ($pdf->Output($filename, 'F') === false) {
        //     header('Content-Type: application/json');
        //     echo json_encode(['status' => 'failed', 'message' => 'Failed to generate PDF']);
        //     exit;
        // }


        
  
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' =>  $env_basePath.'views/sysadmin/export-pdf-template.php']);
        exit;
    
    }
    


?>