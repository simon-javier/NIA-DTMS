<?php 

// Assuming $documents contains the number of documents
$documents = 2;

// Define the constant k (you can adjust this value as needed)
$k = 0.5; // Adjust as needed

// Calculate the status percentage
$status_percentage = 100 - ($documents * $k);

// Ensure status_percentage is within the range [0, 100]
$status_percentage = max(min($status_percentage, 100), 0);

echo "Documents: $documents\n";
echo "Status: $status_percentage%";

?>