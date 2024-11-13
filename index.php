<?php
// index.php

// Display a basic message to verify deployment is working
echo "Welcome to my PHP app on Heroku!";

// Optionally, include other PHP files
// include('header.php');   // Uncomment if you have other files to include
// include('footer.php');

// Define any routes or logic here (example)
if (isset($_GET['page']) && $_GET['page'] === 'about') {
    echo "<h1>About Us</h1>";
    echo "<p>This is a basic PHP app deployed on Heroku.</p>";
} else {
    echo "<h1>Home Page</h1>";
    echo "<p>Welcome to the home page of this PHP application.</p>";
}
