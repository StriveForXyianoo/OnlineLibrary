<?php
// Include your database connection code here
include '../Configure.php';
if (isset($_GET['month'])) {
    $selectedMonth = $_GET['month'];
    // Adjust the query according to your database schema
    $query = "
        SELECT section, SUM(borrowedCount) as borrowedCount
        FROM (
            SELECT section, COUNT(*) as borrowedCount
            FROM book_status
            WHERE DATE_FORMAT(date_confirmed, '%m') = ? 
            GROUP BY section

            UNION ALL

            SELECT section, COUNT(*) as borrowedCount
            FROM book_inventory
            WHERE DATE_FORMAT(date_confirmed, '%m') = ? 
            GROUP BY section
        ) AS combined_data
        GROUP BY section
    ";

    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ss", $selectedMonth, $selectedMonth);
        $stmt->execute();
        $result = $stmt->get_result();

        // Format the data into JSON
        $data = [
            'sections' => [],
            'borrowedCount' => [],
        ];

        while ($row = $result->fetch_assoc()) {
            $data['sections'][] = $row['section'];
            $data['borrowedCount'][] = $row['borrowedCount'];
        }

        echo json_encode($data);
    } else {
        echo json_encode(['sections' => [], 'borrowedCount' => []]);
    }
} else {
    echo json_encode(['sections' => [], 'borrowedCount' => []]);
}
?>
