<?php require 'template/top-template.php'; ?>

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


<div class="h-full bg-neutral-50 p-4">
    <?php if (empty($statusPercentages)): ?>
        <div class="mb-4 p-4 shadow-sm">
            <div class="">
                <h4 class="text-center text-2xl text-gray-500">No office performance yet.</h4>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($statusPercentages as $officeName => $percentage): ?>
            <div class="shadow-sm col-md-12 mb-4 p-4 rounded-md">
                <div class="">
                    <h5 class="mb-3">
                        <?php echo $officeName; ?>
                    </h5>
                    <div class="progress" style="height: 30px">
                        <?php
                        if ($percentage >= 80) {
                            $color = "bg-green-600 rounded-full text-neutral-50";
                        } elseif ($percentage >= 60) {
                            $color = "bg-green-400 rounded-full";
                        } elseif ($percentage >= 40) {
                            $color = "bg-yellow-500 rounded-full";
                        } elseif ($percentage >= 20) {
                            $color = "bg-orange-400 rounded-full";
                        } else {
                            $color = "bg-red-600 rounded-full text-neutral-50";
                        }

                        ?>
                        <div class="progress-bar <?php echo $color; ?>" role="progressbar"
                            style="width: <?php echo $percentage; ?>%;" aria-valuenow="100%" aria-valuemin="0"
                            aria-valuemax="100">
                            <p class="text-center text-sm">
                                <?php echo $percentage; ?>%
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>
<?php require 'template/bottom-template.php'; ?>
