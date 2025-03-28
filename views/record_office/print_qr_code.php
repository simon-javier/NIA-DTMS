<?php
require '../../connection.php';


$docu_code = $_GET['docu_code'];
if ($docu_code === null) {
    header('Location: create_document.php');
}

$sql = "SELECT * from tbl_uploaded_document where document_code = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $docu_code);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$result){
    echo "<script>alert('No Document Found!')</script>";
    exit;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Document Tracking</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        :root {
            --primary-color: #069734;
            --lighter-primary-color: #07b940;
            --white-color: #FFFFFF;
            --black-color: #181818;
            --bold: 600;
            --transition: all 0.5s ease;
            --box-shadow: 0 0.5rem 0.8rem rgba(0, 0, 0, 0.2)
        }



        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', 'Arial';
            scroll-behavior: smooth;

        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .main-content {
            border: 2px solid var(--black-color);
            height: 90vh;
            width: 50%;
            display: flex;
            padding: 5rem;
            flex-direction: column;
            justify-content: center;
            align-items: center;

        }

        .qr-code {
            height: 500px;
        }

        .buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }


        .btn-back {
            background-color: #dc3545;
            text-decoration: none;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }


        .btn-print {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-back:hover,
        .btn-print:hover {
            opacity: 0.8;
        }

        @media print {
            .buttons {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="main-content">
            <h1>Tracking Slip</h1>
            <br>
            <p>Document Type</p>
            <h2><?php echo htmlspecialchars($result['document_type']); ?></h2>
            <br>
            <p>Name in the Document</p>
            <h2><?php echo htmlspecialchars($result['sender']); ?></h2>
            <br>
            <p>Description</p>
            <h2><?php echo htmlspecialchars($result['description']); ?></h2>
            <br>
            <p>Tracking Code</p>
            <img class="qr-code" src="<?php echo $env_basePath; ?>assets/qr-codes/<?php echo htmlspecialchars($result['qr_filename']); ?>" alt="QR Code">
            <p><?php echo htmlspecialchars($result['document_code']); ?></p>
            <div class="buttons">
                <a href="create_document.php" class="btn btn-back">Back</a>
                <button class="btn btn-print" onclick="printPage()">Print</button>
            </div>
        </div>
    </div>
</body>
<script>
    function printPage() {
        window.print();
    }
</script>

</html>