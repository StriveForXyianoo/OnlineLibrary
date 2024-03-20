<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<?php

include '../Configure.php';

// User ID (assuming 'juan' is identified by a specific idnum)
$idnum = '1111';

// Query to calculate the total penalty count for the user
$sql = "SELECT SUM(penalty_count) AS total_penalty FROM book_status WHERE idnum = '$idnum'";

$result = mysqli_query($conn, $sql);

if ($result) {
    // Check if any rows are returned
    if (mysqli_num_rows($result) > 0) {
        // Output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $totalPenalty = $row["total_penalty"];
            echo "Total Penalty for User $idnum: $totalPenalty pesos";
        }
    } else {
        echo "User not found or no penalties.";
    }
} else {
    echo "Error executing query: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);

?>

</body>
</html>