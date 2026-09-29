<?php

$errors = array();

$email = $_POST['email'];
$password = $_POST['password'];
$ccnumber = $_POST['ccnumber'];
$phone = $_POST['phone'];


/* Email validation */
if (!preg_match("/^[\w\.-]+@[\w\.-]+\.\w{2,4}$/", $email)) {
    $errors[] = "Please enter a valid email address.";
}


/* Password validation */
if (!preg_match("/^.{6,}$/", $password)) {
    $errors[] = "Password must contain at least 6 characters.";
}


/* Credit card validation */
if (!preg_match("/^[0-9]{16}$/", $ccnumber)) {
    $errors[] = "Credit card number must contain exactly 16 digits.";
}


/* Phone number validation */
if (!preg_match("/^[0-9]{10}$/", $phone)) {
    $errors[] = "Phone number must contain exactly 10 digits.";
}


/* Display result */
if (empty($errors)) {

    echo "<h2>Registration Successful!</h2>";
    echo "<p>Your details have been validated successfully.</p>";

} else {

    echo "<h2>Registration Failed</h2>";

    foreach ($errors as $error) {
        echo "<p>" . $error . "</p>";
    }
}

?>