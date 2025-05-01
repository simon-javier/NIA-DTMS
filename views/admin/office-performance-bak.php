<?php require 'template/top-template-bak.php'; ?>

<?php

$offices = "SELECT office from tbl_userinformation where role = 'handler' and status = 'active' group by office";
$stmt = $pdo->prepare($offices);
$stmt->execute();
$list_offices = $stmt->fetchAll(PDO::FETCH_ASSOC);


try {
    $sql = "SELECT * FROM tbl_handler_incoming GROUP BY docu_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $officeCounts = array();
    foreach ($list_offices as $active_office) {
        $officeCounts[$active_office['office']] = 0;
    }
    foreach ($result as $row) {

        $officeName = $row['office_name'];
        if (isset($officeCounts[$officeName])) {
            $officeCounts[$officeName]++;
        } else {
            $officeCounts[$officeName] = 1;
        }
    }

    $k = 0.5; // Adjust as needed
    $statusPercentages = array();
    foreach ($officeCounts as $officeName => $count) {
        $status_percentage = 100 - ($count * $k);
        // Ensure status_percentage is within the range [0, 100]
        $status_percentage = max(min($status_percentage, 100), 0);
        // Store the status percentage for the current office in the array
        $statusPercentages[$officeName] = $status_percentage;
    }
} catch (PDOException $e) {
    // Handle errors
    echo "Error: " . $e->getMessage();
}
?>


<div class="row p-4">
    <?php if (empty($statusPercentages)): ?>
        <div class="border col-md-12 mb-4 p-4">
            <div class=" shadow-sm bg-white">
                <h4 class="text-center">No office performance yet.</h4>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($statusPercentages as $officeName => $percentage): ?>
            <div class="border col-md-12 mb-4 p-4">
                <div class=" shadow-sm bg-white">
                    <h5 class="mb-3">
                        <?php echo $officeName; ?>
                    </h5>
                    <div class="progress" style="height: 30px">
                        <?php
                        if ($percentage >= 80) {
                            $color = "bg-primary"; // Blue for high percentages
                        } elseif ($percentage >= 60) {
                            $color = "bg-info"; // Light blue for medium-high percentages
                        } elseif ($percentage >= 40) {
                            $color = "bg-warning"; // Yellow for medium percentages
                        } elseif ($percentage >= 20) {
                            $color = "bg-secondary"; // Gray for low-medium percentages
                        } else {
                            $color = "bg-danger"; // Red for low percentages
                        }

                        ?>
                        <div class="progress-bar <?php echo $color; ?>" role="progressbar"
                            style="width: <?php echo $percentage; ?>%;" aria-valuenow="100%" aria-valuemin="0"
                            aria-valuemax="100">
                            <?php echo $percentage; ?>%
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>
<?php require 'template/bottom-template.php'; ?>
