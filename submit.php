
<?php

require 'vendor/autoload.php'; // include Composer's autoloader

// Connection string
$uri = "mongodb+srv://Dev_Quarm:LaGata#1221@cluster0.ckxpq.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";

// Create a MongoDB client
$client = new MongoDB\Client($uri);

// Select a database
$db = $client->selectDatabase('trs');

// Select a collection
$collection = $db->selectCollection('users');

// Example: Insert a document into the collection
$result = $collection->insertOne([
    'name' => 'John Doe',
    'email' => 'john.doe@example.com'
]);

echo "Inserted with Object ID '{$result->getInsertedId()}'";

?>
