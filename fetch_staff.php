<?php
include 'includes/db_connect.php';

if (isset($_GET['staff_type'])) {
    $staff_type = $_GET['staff_type'];
    $result = [];

    if ($staff_type === 'Teacher') {
        $query = "SELECT TeacherID as id, Name as name FROM Teachers";
    } elseif ($staff_type === 'TeachingAssistant') {
        $query = "SELECT AssistantID as id, Name as name FROM TeachingAssistants";
    }

    $res = $conn->query($query);

    if (!$res) {
        echo json_encode(["error" => "Query failed: " . $conn->error]);
    } else {
        while ($row = $res->fetch_assoc()) {
            $result[] = $row;
        }
        echo json_encode($result);
    }
} else {
    echo json_encode(["error" => "No staff_type specified."]);
}
