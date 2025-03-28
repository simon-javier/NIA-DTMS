<?php require 'template/top-template.php'; ?>

<?php 
    require '../../connection.php';
    $id = $_GET['id'];

   
    try {
        //code...
        $get_user_data = "
           select * from tbl_userinformation where id = '$id';
        ";
        $stmt = $pdo->prepare($get_user_data);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $type = $result['role'];
        if($result['status'] == 'pending'){
            $href = 'pending-account.php';
        }else{
            if($type != 'guest'){
                $href = 'offices.php';
            }else{
                $href = 'guest.php';
            }
        }
            
        
        // print_r($result);
    } catch (\PDOException $th) {
        echo "Error: " . $th->getMessage();
    }
?>

    <style>
        :root {
        --primary-color: #069734;
        --lighter-primary-color: #07b940;
        --white-color: #FFFFFF;
        --black-color: #181818;
        --bold: 600;
        --transition: all 0.5s ease;
        --box-shadow: 0 0.1rem 0.8rem rgba(0, 0, 0, 0.2);
        }
        p, h1, h2, h3, h4, h5, h6{
            margin: 0;
        }

        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        *{
            font-family: 'Poppins', 'Arial' !important;
        }
        .top-bar{
            background-color: var(--primary-color);
            padding: 20px;
            color: var(--white-color);
        }
        .content{
            padding: 20px;
            box-shadow: var(--box-shadow);
        }

    </style>
<!-- </head>
<body> -->
 
        <!-- <div class="top-bar d-flex justify-content-start align-items-start">

            <a href="offices.php" class="btn btn-danger d-flex align-items-center" style="gap: 10px"><i class='bx bx-arrow-back' style="font-size: 18px;"></i> Back</a>
        </div> -->
        <div class="content">
        <div class="mb-3 d-flex justify-content-start align-items-start">
            <!-- <h2>User Details</h2> -->
            <a href="<?php echo $href; ?>" class="btn btn-danger d-flex align-items-center" style="gap: 10px"><i class='bx bx-arrow-back' style="font-size: 18px;"></i> Back</a>
        </div>
        <div class="row">
            <div class="col-md-10 col-sm-10">
                <div class="form-group">
                    <label for="input1">Full Name</label>
                    <input type="text" class="form-control" id="input1" value="<?php echo $result['firstname']; ?> <?php echo $result['lastname']; ?>" placeholder="N/A" readonly>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="form-group">
                    <label for="input1">Status</label>
                    <p><span class="badge <?php echo ($result['status'] === 'active') ? 'badge-success' : 'badge-danger'; ?>" style="text-transform: uppercase;"><?php echo $result['status']; ?></span></p>


                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="input1">Contact Number</label>
                    <input type="text" class="form-control" id="input1" value="<?php echo $result['contact']; ?>" placeholder="N/A" readonly>
                </div>
                <div class="form-group">
                    <label for="input2">Position</label>
                    <input type="text" class="form-control" value="<?php echo $result['position']; ?>" id="input2" placeholder="N/A" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="input4">Email address</label>
                    <input type="text" class="form-control" value="<?php echo $result['email']; ?>" id="input4" placeholder="N/A" readonly>
                </div>
                <div class="form-group">
                    <label for="input5">Role</label>
                    <input type="text" class="form-control" value="<?php echo $result['role']; ?>" id="input5" placeholder="N/A" readonly>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="input3">Office</label>
                    <input type="text" class="form-control" value="<?php echo $result['office']; ?>" id="input3" placeholder="N/A" readonly>
                </div>
            </div>
            
        </div>
        <div class="d-flex justify-content-end align-items-end">
            
        </div>
        
        </div>
 
    <?php require 'template/bottom-template.php'; ?>

