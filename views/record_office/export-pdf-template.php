<?php 
session_start();
    require '../../connection.php';
        $doc_type = $_GET['doc_type'];
        $date_from = $_GET['from'];
        $date_to = $_GET['dateto'];
        $office = $_SESSION['office'];
        
        if ($doc_type != 'Select') {
            // If document type is selected
            if ($date_from != null && $date_to != null) {
                // If both dates are provided
                $selectDocumentQuery = "SELECT * FROM tbl_uploaded_document WHERE DATE(uploaded_at) BETWEEN :date_from AND :date_to AND completed = :doc_type";
                $stmt = $pdo->prepare($selectDocumentQuery);
                $stmt->bindParam(':date_from', $date_from);
                $stmt->bindParam(':date_to', $date_to);
                $stmt->bindParam(':doc_type', $doc_type);

           
            
                
            } else {
                // If only document type is provided
                $selectDocumentQuery = "SELECT * FROM tbl_uploaded_document WHERE completed = :doc_type";
                $stmt = $pdo->prepare($selectDocumentQuery);
                $stmt->bindParam(':doc_type', $doc_type);
          
                
            }
        } elseif ($date_from != null && $date_to != null) {
            // If document type is not selected, but both dates are provided
            $selectDocumentQuery = "SELECT * FROM tbl_uploaded_document WHERE DATE(uploaded_at) BETWEEN :date_from AND :date_to";
            $stmt = $pdo->prepare($selectDocumentQuery);
            $stmt->bindParam(':date_from', $date_from);
            $stmt->bindParam(':date_to', $date_to);
           
         
        } else {
            // Handle other cases or provide a default query
            $selectDocumentQuery = "SELECT * FROM tbl_uploaded_document where completed != 'decline' or completed != 'pulled'";
            $stmt = $pdo->prepare($selectDocumentQuery);

            
        }
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', 'Arial';
        }

        .button-container{
            padding: 1rem;
            display: flex;
            justify-content: start;
            gap: 10px;
        }
        .button {
            text-decoration: none;
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            cursor: pointer;
            
            /* border-color: #007bff; */
        }
        .button.primary{
            background-color: #007bff;
            color: #fff;
        }
        
        .button.primary:hover {
            background-color: #0056b3;
            color: #fff;
           
        }
        .button.danger{
            background-color: #db2612;
            color: #fff;
        }
        .button.danger:hover {
            background-color: #a61e0f;
            color: #fff;
        }
        .button.success{
            background-color: #069734;
            color: #fff;
        }
        .button.success:hover {
            background-color: #10a115;
            color: #fff;

        }
        th, td{
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        @media print{
            .button-container{
                display: none;
            }
        }

        
    </style>
</head>
<body>
<div class="button-container">
    <a href="generate-report.php" class="button danger">Back</a>
    <button class="button primary" onclick="downloadAsPdf()">Save as PDF</button>
    <button class="button success" onclick="saveAsCsv()">Save as CSV</button>
</div>
<div class="container" style="display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;" id="capture" style="padding: 1rem">
    <img style="width: 150px; height: 150px" src="<?php echo $env_basePath; ?>assets/img/logo.png" alt="NIA Logo">
    <h2 align="center" style="margin: 0;"><strong>National Irrigation Administration</strong></h2>
    <?php
        if ($doc_type == 'Select' && $date_from == '' && $date_to == '') {
            echo '<h2 align="center" style="margin: 0;">All Documents Created</h2>';
        } elseif ($doc_type != 'Select' && $date_from == '' && $date_to == '') {
            echo '<h2 align="center" style="margin: 0;">' . ucfirst($doc_type) . ' Documents</h2>';
        } elseif ($doc_type == 'Select' && $date_from != '' && $date_to != '') {
            echo '<h2 align="center" style="margin: 0;">Created Documents on</h2>';
            echo '<h4 align="center" style="margin: 0;">' . date('F j, Y', strtotime($date_from)) . ' to ' . date('F j, Y', strtotime($date_to)).' </h4>';
            echo '<br/>';
        } elseif ($doc_type != 'Select' && $date_from != '' && $date_to != '') {
            echo '<h2 align="center" style="margin: 0;">' . ucfirst($doc_type) . ' Documents created on </h2>';
            echo '<h4 align="center" style="margin: 0;">' . date('F j, Y', strtotime($date_from)) . ' to ' . date('F j, Y', strtotime($date_to)).' </h4>';
            echo '<br/>';

            
        } else {
            // Handle other cases if needed
        }
    ?>


    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <th>QR Code</th>
            <th>Document Code</th>
            <th>Document Date</th>
            <th>Subject</th>
            <th>From</th>
            <th>Actions Requested</th>
            <th>Actions Taken</th>
        </tr>
        <?php
        if (empty($result)) {
            echo '<tr><td colspan="7" style="text-align: center;">No available data</td></tr>';
        } else {
            foreach ($result as $row) {
                ?>
                <tr>
                <td>
                    <?php 
                    if ($row['qr_filename'] !== null) {
                        echo '<img src="' . $env_basePath . 'assets/qr-codes/' . $row['qr_filename'] . '" alt="QR Code" style="height: 80px">';
                    } else {
                        echo 'No generated qr code';
                    }
                    ?>
                </td>
                    <td><?php echo $row['document_code']; ?></td>
                    <td><?php echo $row['uploaded_at']; ?></td>
                    <td><?php echo $row['subject']; ?></td>
                    <td><?php echo $row['sender']; ?></td>
                    <td><?php echo $row['required_action']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
            <?php
            }
        }
        ?>

        
    </table>

</div>



<script src="<?php echo $env_basePath; ?>assets/cloudflare/html2pdf.bundle.min.js"></script>
<!-- <script>
    function downloadAsPdf() {
        var element = document.querySelector('.container');

        html2pdf(element, {
            margin: 10,
            filename: 'document.pdf',
            image: { type: 'jpeg', quality: 1 },
            html2canvas: { scale: 1 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
        });
    }
</script> -->
<script>
    function downloadAsPdf() {
        window.print();
    }

    function saveAsCsv(){
        alert("TO DO: Export as CSV");
    }
</script>

</body>
</html>


