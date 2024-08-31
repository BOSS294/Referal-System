<?php
header('Content-Type: application/json');
require '../Connectors/db.php';

// Get JSON input from request
$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'];
$referralCode = $data['referralCode'];



$query = $mysqli->prepare("SELECT User_ID, TimesUsed FROM user_refers WHERE Refercode = ?");
$query->bind_param("s", $referralCode);
$query->execute();
$query->store_result();

if ($query->num_rows > 0) {
    $query->bind_result($userId, $timesUsed);
    $query->fetch();

    // Insert into refers table
    $insertQuery = $mysqli->prepare("INSERT INTO refers (User_ID, Refercode, Used_by) VALUES (?, ?, ?)");
    $insertQuery->bind_param("sss", $userId, $referralCode, $username);
    $insertQuery->execute();

    // Update TimesUsed and LastUsed in user_refers
    $timesUsed++;
    $updateQuery = $mysqli->prepare("UPDATE user_refers SET TimesUsed = ?, LastUsed = NOW() WHERE Refercode = ?");
    $updateQuery->bind_param("is", $timesUsed, $referralCode);
    $updateQuery->execute();

    // Return success response
    echo json_encode(['success' => true]);

} else {
    // Return failure response
    echo json_encode(['success' => false]);
}

// Close connections
$query->close();
$insertQuery->close();
$updateQuery->close();
$mysqli->close();
?>
