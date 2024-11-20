<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli('localhost', 'root', '', 'inventoryproj');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Fetch student borrowers
$studentQuery = "SELECT name, email, student_id AS id, grade FROM borrowers WHERE type = 'Student'";
$studentResult = $conn->query($studentQuery);
$students = [];
while ($row = $studentResult->fetch_assoc()) {
    $students[] = $row;
}

// Fetch teacher borrowers
$teacherQuery = "SELECT name, email, employee_id AS id, department FROM borrowers WHERE type = 'Teacher'";
$teacherResult = $conn->query($teacherQuery);
$teachers = [];
while ($row = $teacherResult->fetch_assoc()) {
    $teachers[] = $row;
}

$conn->close();

echo json_encode(['students' => $students, 'teachers' => $teachers]);
?>