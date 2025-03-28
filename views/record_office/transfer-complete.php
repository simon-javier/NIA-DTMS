<?php 
    session_start();
    require '../../connection.php';
    $id = $_GET['id'];


    $docu_query = "SELECT * FROM tbl_uploaded_document where id = :id";
    $stmt = $pdo->prepare($docu_query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $docu_detail = $stmt->fetch(PDO::FETCH_ASSOC);

    $select = "SELECT * from tbl_action_taken where docu_id = :id";
    $stmt = $pdo->prepare($select);
    $stmt->bindParam(':id', $docu_detail['id']);
    $stmt->execute();
    $actions_taken = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $tracking_query = "SELECT * FROM tbl_document_tracking where docu_id = :id";
    $stmt = $pdo->prepare($tracking_query);
    $stmt->bindParam(':id', $docu_detail['id']);
    $stmt->execute();
    $tracking_status = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $uploadedTime = new DateTime($docu_detail['uploaded_at']);

    // Get the current time
    $currentTime = new DateTime();

    // Calculate the time difference
    $timeDiffInSeconds = $currentTime->getTimestamp() - $uploadedTime->getTimestamp();
    if ($timeDiffInSeconds < 24 * 60 * 60) {
        // If less than 24 hours, display hours
        $age = floor($timeDiffInSeconds / (60 * 60));
        $ageFormat = $age . " hours ago";
    } else {
        // If 24 hours or more, display days
        $age = floor($timeDiffInSeconds / (60 * 60 * 24));
        $ageFormat = $age . " days ago";
    }

    // Format the uploaded time
    $formattedDate = $uploadedTime->format("F j, Y g:i a");
    $office = $_SESSION['office'];
    $officesQuery = "SELECT DISTINCT tbl_offices.office_name FROM tbl_offices 
    JOIN tbl_userinformation ON tbl_offices.office_name = tbl_userinformation.office where tbl_offices.office_name != :office and tbl_userinformation.status != 'archived'";

    $statement = $pdo->prepare($officesQuery);
    $statement->bindParam(':office', $office);
    $statement->execute();
    $offices = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Tracking System</title>
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/cloudflare/all.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/boxicons/boxicons.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/datatable/jquery.dataTables.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        :root {
            --primary-color: #069734;
            --lighter-primary-color: #07b940;
            --white-color: #FFFFFF;
            --black-color: #181818;
            --border-color: #E9ECEF;
            --bold: 600;
            --transition: all 0.5s ease;
            --box-shadow: 0 0.5rem 0.8rem rgba(0, 0, 0, 0.2)
        }

        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', 'Arial';
        }
        p, h1, h2, h3, h4, h5, h6{
            margin: 0;
        }
        .dropdown-menu-left{
            float: left;
        }
        .navbar{
            background-color: var(--white-color);
            justify-content: normal;
        }
        .content{
            width: 100%;
            padding: 1rem;
  
        }  
        .subject, .details, .code, .sender, .content-details, .attachment{
            width: 100%;
            padding: 0.5rem;
            border-top: 2px solid var(--border-color);
            border-left: 2px solid var(--border-color);
            border-right: 2px solid var(--border-color);
        }
        .code, .details{
            background-color: var(--primary-color);
            color: var(--white-color);
        }
        .code p{
            font-size: 1.5rem;
        }

        .name{
            padding: 5px;
        }
        .name i{
            font-size: 2rem;
        }
        .date p {
            font-size: 12px;
        }

        .subject img{
            height: 100px;
        }
        .subject p{
            font-size: 20px;
        }
        .details i{
            margin-left: 10px;
            font-size: 1.5rem;
            margin-right: 10px;
        }
        .content-details, .attachment{
            padding: 1.5rem;
        }
        .attachment{
            border-bottom: 2px solid var(--border-color);
        }
        .attachment .content{
            border: 2px solid var(--border-color);
       
        }
        .attachment .content i{
            color: red;
            font-size: 3rem;
        }
        .timeline {
  position: relative;
  max-width: 1200px;
  margin: 0 auto;
}

/* The actual timeline (the vertical ruler) */
.timeline::after {
  content: '';
  position: absolute;
  width: 6px;
  background-color: var(--primary-color);
  top: 0;
  bottom: 0;
  left: 50%;
  margin-left: -8px;
}

/* Container around content */
.containers {
  padding: 10px 40px;
  position: relative;
  background-color: inherit;
  width: 50%;
}

/* The circles on the timeline */
.containers::after {
  content: '';
  position: absolute;
  width: 25px;
  height: 25px;
  right: -8px;
  background-color: white;
  border: 4px solid var(--primary-color);
  top: 15px;
  border-radius: 50%;
  z-index: 1;
}

/* Place the container to the left */
.left {
  left: 0;
}

/* Place the container to the right */
.right {
  left: 50%;
}

/* Add arrows to the left container (pointing right) */
.left::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  right: 30px;
  border: medium solid white;
  border-width: 10px 0 10px 10px;
  border-color: transparent transparent transparent white;
}

/* Add arrows to the right container (pointing left) */
.right::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  left: 30px;
  border: medium solid white;
  border-width: 10px 10px 10px 0;
  border-color: transparent white transparent transparent;
}

/* Fix the circle for containers on the right side */
.right::after {
  left: -16px;
}

/* The actual content */
.content {
  padding: 20px 30px;
  background-color: white;
  position: relative;
  border-radius: 6px;
}

/* Media queries - Responsive timeline on screens less than 600px wide */
@media screen and (max-width: 600px) {
  /* Place the timelime to the left */
  .timeline::after {
  left: 31px;
  }
  
  /* Full-width containers */
  .containers {
  width: 100%;
  padding-left: 70px;
  padding-right: 25px;
  }
  
  /* Make sure that all arrows are pointing leftwards */
  .containers::before {
  left: 60px;
  border: medium solid white;
  border-width: 10px 10px 10px 0;
  border-color: transparent white transparent transparent;
  }

  /* Make sure all circles are at the same spot */
  .left::after, .right::after {
  left: 15px;
  }
  
  /* Make all right containers behave like the left ones */
  .right {
  left: 0%;
  }
}



    </style>
</head>
<body>
<?php require '../../assets/loader/loader.php'; ?>
    <!-- Just an image -->
    <nav class="navbar">
        <a class="btn btn-danger" href="incoming-documents.php">
            <i class="bx bx-arrow-back"></i>Back</a>
    </nav>
    <div class="content">
        <div class="code d-flex justify-content-center align-item-center">
            <p>DOCUMENT CODE: <strong><?php echo $docu_detail['document_code'] ?></strong></p>
        </div>
        <div class="sender d-flex justify-content-between align-item-center flex-column flex-sm-row">
            <div class="name d-flex align-item-center">
                <i class="bx bx-user-circle" style="margin-right: 10px"></i><p style="margin-top: 4px;">
                <?php echo $docu_detail['sender'] ?></p>
            </div>
            <div class="date">
                <p><i><?php echo $formattedDate; ?> (<?php echo $ageFormat; ?>)</i></p>
            </div>
        </div>
        <div class="subject d-flex">
            <img src="<?php echo $env_basePath; ?>assets/qr-codes/<?php echo $docu_detail['qr_filename'] ?>" alt="QR Code">
            <p class="mt-4"><?php echo $docu_detail['document_type'] ?> - <?php echo $docu_detail['subject'] ?></p>
        </div>


        <div class="details d-flex align-item-center">
            <i class='bx bxs-file'></i> Status
        </div>


        <div class="attachment">
            

        <div class="timeline">
            <?php $currentPosition = 'left'; ?>
            <?php foreach ($tracking_status as $status): ?>
                <div class="containers <?php echo $currentPosition; ?>">
                    <div class="content">
                        <p><?php echo date('F j, Y', strtotime($status['timestamp'])); ?></p>
                        <p><?php echo htmlspecialchars($status['action_taken']); ?></p>
                        <p>By: <?php echo htmlspecialchars($status['person']); ?></p>
                    </div>
                </div>
                
                <?php // Toggle position for the next iteration
                $currentPosition = ($currentPosition === 'left') ? 'right' : 'left'; ?>
            <?php endforeach; ?>
        </div>
        </div>


        <div class="details d-flex align-item-center">
            <i class='bx bx-detail'></i> Details
        </div>
        <div class="content-details">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="action">Required Action</label>
                        <input type="text" class="form-control" name="action" id="action" value="<?php echo $docu_detail['required_action'] ?>" placeholder="Required Action" readonly required>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" placeholder="Description" id="description" cols="5" rows="5" readonly><?php echo $docu_detail['description'] ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="details d-flex align-item-center">
            <i class='bx bx-detail'></i> Action Taken
        </div>
        <div class="content-details">
            <div class="row">  

            <div class="col-md-12">
                <div class="form-group">
                <?php if (empty($actions_taken)): ?>
                    <p>No actions taken yet</p>
                <?php else: ?>
                    <?php foreach($actions_taken as $action): ?>
                        <p><?php echo $action['action_taken'] ?></p><br>
                    <?php endforeach; ?>
                <?php endif; ?>

                </div>
            </div>
            </div>
        </div>
        <div class="details d-flex align-item-center">
            <i class='bx bxs-file'></i> Attachment
        </div>
        <div class="attachment">
            <div class="content d-flex align-item-center justify-content-between">
                <div class="d-flex align-item-center">
                    <i class='bx bxs-file-pdf'></i> <p class="mt-3"><?php echo $docu_detail['document_size'] ?></p>
                </div>
                <div class="d-flex align-item-center">
                <button class="btn btn-dark" data-toggle="modal" data-target="#pdfViewerModal">
                    View
                </button>
                </div>
            </div>
        </div>
        <div class="details d-flex align-item-center">
            <i class='bx bxs-file'></i> Action
        </div>
        <div class="attachment">
            <div class="row">
                <div class="col-md-11">
                    <input type="text" id="action_taken" list="action_required_list" placeholder="Action taken" class="form-control" name="action_taken"/>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary" data-id="<?php echo $id; ?>" onclick="confirmTransfer(event)">Send</button>
                </div>
            
            </div>
    
        </div>
    </div>
    <div class="modal fade" id="pdfViewerModal" tabindex="-1" role="dialog" aria-labelledby="pdfViewerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfViewerModalLabel">Document Viewer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- PDF Viewer container -->
                <div id="pdfViewerContainer" style="height: 500px;">
                    <embed src="<?php echo $env_basePath; ?>assets/uploaded-pdf/<?php echo $docu_detail['pdf_filename'] ?>" type="application/pdf" width="100%" height="500px">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<datalist id="action_required_list">
        <option value="For appropirate action">
        <option value="For comments/recommendation">
        <option value="For initial/signature">
        <option value="For information/reference/file">
        <option value="Please follow-up and report action taken">
        <option value="Please see me">
        <option value="For inspection">
        <option value="For compliance">

    </datalist>

</body>


<script src="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.bundle.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.2.1.slim.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jsdelivr/popper.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jsdelivr/sweetalert2.all.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.6.4.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/datatable/jquery.dataTables.min.js"></script>


<script>
    function confirmTransfer(event) {
        const actionTaken = document.getElementById('action_taken').value;

        if (!actionTaken) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please provide an action before completing!',
            });
            return;
        }
         
        const button = event.currentTarget;
        const dataId = button.getAttribute('data-id');
        Swal.fire({
            title: 'Select where you want to send',
            html: `<select id="officeDropdown" class="form-control">
                        <?php foreach ($offices as $office) { ?>
                            <option value="<?php echo $office['office_name']; ?>"><?php echo $office['office_name']; ?></option>
                        <?php } ?>
                    </select>`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Send!'
        }).then((result) => {
            if (result.isConfirmed) {
            var selectedOffice = $('#officeDropdown').val();
            

            $('.loader-container').fadeIn();
            var formData = new FormData();
            formData.append("action", "transfer_document");
            formData.append("id", dataId);
            formData.append("office", selectedOffice);
            formData.append("action_taken", actionTaken);
            
            $.ajax({
                url: "../../controller/transfer-document-controller.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success:function(response){
                    setTimeout(function() {
                    $('.loader-container').fadeOut();
                    }, 500);
                
                    if(response.status === "failed"){
                        Swal.fire({
                            title: 'Something went wrong!',
                            text: response.message,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }else if(response.status === "error"){
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                    }
                    else if(response.status === "success"){
                        Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "received-documents.php";

                            }
                        });
                        }
                    
                   
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    var errorMessage = 'An error occurred while processing your request.';
                    if (xhr.statusText) {
                        errorMessage += ' ' + xhr.statusText;
                    }
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage + '<br><br>' + JSON.stringify(xhr, null, 2), // Include the entire error object for debugging
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // Check if the user clicked the "OK" button
                        if (result.isConfirmed) {
                            // Reload the page
                            location.reload();
                        }
                    });
                }
            });
        
            }
        });
       
    }
</script>
</html>