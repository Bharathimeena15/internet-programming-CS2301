<?php

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];
$creditcard = $_POST['creditcard'];

$errors = array();


/* Name validation */

if (!preg_match("/^[A-Za-z ]+$/", $name)) {

    $errors[] = "Invalid name";

}


/* Email validation */

if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {

    $errors[] = "Invalid email address";

}


/* Password validation */

if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$/", $password)) {

    $errors[] = "Password must contain at least 8 characters, one uppercase, one lowercase and one number";

}


/* Phone validation */

if (!preg_match("/^[0-9]{10}$/", $phone)) {

    $errors[] = "Phone number must contain exactly 10 digits";

}


/* Credit card validation */

if (!preg_match("/^[0-9]{16}$/", $creditcard)) {

    $errors[] = "Credit card number must contain exactly 16 digits";

}


/* Display result */

if (count($errors) > 0) {

    echo "<h2>Registration Failed</h2>";

    echo "<ul>";

    foreach ($errors as $error) {

        echo "<li>$error</li>";

    }

    echo "</ul>";

    echo "<br>";

    echo "<a href='index.html'>Go Back</a>";

}

else {

    echo "<h2>Registration Successful</h2>";

    echo "<p>Welcome, " . htmlspecialchars($name) . "</p>";

    echo "<p>Email: " . htmlspecialchars($email) . "</p>";

    echo "<p>Phone: " . htmlspecialchars($phone) . "</p>";

    echo "<p>Credit Card: Valid 16-digit number</p>";

    echo "<p>Password: Valid</p>";

}

?>