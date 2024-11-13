<?php
// Include your database connection
include('db.php');

// Check if a delete request has been made via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['client_id'])) {
    // Sanitize and get the client ID
    $clientId = intval($_POST['client_id']);

    // Prepare and execute the SQL DELETE query
    $stmt = $db->prepare("DELETE FROM clients WHERE client_id = ?");
    $stmt->bind_param("i", $clientId);

    // Check if the deletion was successful
    if ($stmt->execute()) {
        // Redirect to the client management page with a success message
        header("Location: ad_client.php?message=Client+Deleted+Successfully");
        exit();
    } else {
        // Redirect with an error message if something went wrong
        header("Location: ad_client.php?message=Error+Deleting+Client");
        exit();
    }
}
