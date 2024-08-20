

<?php

include 'db.php';



if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    $sql = "DELETE FROM receipts WHERE id = $id";
    $result = $conn->query( $sql);

    if ($result) {
        echo "Deleted successfully";
    } else {
        die("Connection failed: " . $conn->connect_error);
    }
} else {
    echo "No ID provided";
}
?>


