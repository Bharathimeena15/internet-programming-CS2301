function checkDetails() {
// Get values
let name = document.getElementById("fullname").value.trim();
let email = document.getElementById("mail").value.trim();
let contact = document.getElementById("contact").value.trim();
let password = document.getElementById("pass").value;
let rePassword = document.getElementById("repass").value;

// Error message elements
let nameError = document.getElementById("nameError");
let emailError = document.getElementById("emailError");
let contactError = document.getElementById("contactError");
let passError = document.getElementById("passError");
let repassError = document.getElementById("repassError");

// Clear old errors
nameError.innerHTML = "";
emailError.innerHTML = "";
contactError.innerHTML = "";
passError.innerHTML = "";
repassError.innerHTML = "";

let valid = true;

// Name validation
let namePattern = /^[A-Za-z ]+$/;

if (name === "") {
    nameError.innerHTML = "Full name is required";
    valid = false;
} 
else if (!namePattern.test(name)) {
    nameError.innerHTML = "Name should contain only letters";
    valid = false;
} 
else if (name.length < 3) {
    nameError.innerHTML = "Name must contain at least 3 characters";
    valid = false;
}

// Email validation
let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

if (email === "") {
    emailError.innerHTML = "Email address is required";
    valid = false;
} 
else if (!emailPattern.test(email)) {
    emailError.innerHTML = "Enter a valid email address";
    valid = false;
}

// Contact number validation
let contactPattern = /^[0-9]{10}$/;

if (contact === "") {
    contactError.innerHTML = "Contact number is required";
    valid = false;
} 
else if (!contactPattern.test(contact)) {
    contactError.innerHTML = "Enter a valid 10-digit contact number";
    valid = false;
}

// Password validation
if (password === "") {
    passError.innerHTML = "Password is required";
    valid = false;
} 
else if (password.length < 8) {
    passError.innerHTML = "Password must contain at least 8 characters";
    valid = false;
} 
else if (!/[A-Z]/.test(password)) {
    passError.innerHTML = "Password must contain at least one uppercase letter";
    valid = false;
} 
else if (!/[a-z]/.test(password)) {
    passError.innerHTML = "Password must contain at least one lowercase letter";
    valid = false;
} 
else if (!/[0-9]/.test(password)) {
    passError.innerHTML = "Password must contain at least one number";
    valid = false;
} 
else if (!/[!@#$%^&*]/.test(password)) {
    passError.innerHTML = "Password must contain at least one special character";
    valid = false;
}

// Confirm password validation
if (rePassword === "") {
    repassError.innerHTML = "Please re-enter your password";
    valid = false;
} 
else if (password !== rePassword) {
    repassError.innerHTML = "Passwords do not match";
    valid = false;
}

// Successful registration
if (valid) {
    alert("Registration successful!");

    // Redirect to login page
    window.location.href = "signin.html";

    return false;
}

return false;


}
