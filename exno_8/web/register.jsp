<%@ page contentType="text/html;charset=UTF-8" %>

<!DOCTYPE html> <html> <head> <meta charset="UTF-8"> <title>Job Registration Details</title>
<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 30px;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .container {
        max-width: 700px;
        margin: auto;
        background-color: white;
        padding: 35px 45px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    h1 {
        text-align: center;
        color: #28a745;
        margin-bottom: 10px;
    }

    .message {
        text-align: center;
        color: #666;
        margin-bottom: 25px;
    }

    .section-title {
        margin-top: 25px;
        padding: 10px;
        background-color: #667eea;
        color: white;
        border-radius: 5px;
    }

    .details {
        border: 1px solid #ddd;
        border-radius: 7px;
        overflow: hidden;
    }

    .row {
        display: flex;
        border-bottom: 1px solid #ddd;
        min-height: 45px;
    }

    .row:last-child {
        border-bottom: none;
    }

    .label {
        width: 40%;
        padding: 12px;
        background-color: #f5f5f5;
        font-weight: bold;
        color: #444;
    }

    .value {
        width: 60%;
        padding: 12px;
        color: #333;
        word-break: break-word;
    }

    .back-btn {
        display: block;
        width: 100%;
        margin-top: 25px;
        padding: 12px;
        text-align: center;
        text-decoration: none;
        background-color: #667eea;
        color: white;
        border-radius: 6px;
        font-weight: bold;
    }

    .back-btn:hover {
        background-color: #4c63c7;
    }
</style>

</head> <body>

<%
String username = request.getParameter("username");
String password = request.getParameter("password");
String name = request.getParameter("name");
String dob = request.getParameter("dob");
String gender = request.getParameter("gender");
String email = request.getParameter("email");
String phone = request.getParameter("phone");
String address = request.getParameter("address");

String qualification = request.getParameter("qualification");
String specialization = request.getParameter("specialization");
String skills = request.getParameter("skills");
String experience = request.getParameter("experience");
String jobrole = request.getParameter("jobrole");
String salary = request.getParameter("salary");

String location = request.getParameter("location");
String linkedin = request.getParameter("linkedin");


%>

<div class="container">
<h1>Registration Successful!</h1>

<p class="message">
    Your job application has been submitted successfully.
</p>


<h3 class="section-title">Account Details</h3>

<div class="details">

    <div class="row">
        <div class="label">User Name</div>
        <div class="value"><%= username %></div>
    </div>

    <div class="row">
        <div class="label">Password</div>
        <div class="value">********</div>
    </div>

</div>


<h3 class="section-title">Personal Details</h3>

<div class="details">

    <div class="row">
        <div class="label">Full Name</div>
        <div class="value"><%= name %></div>
    </div>

    <div class="row">
        <div class="label">Date of Birth</div>
        <div class="value"><%= dob %></div>
    </div>

    <div class="row">
        <div class="label">Gender</div>
        <div class="value"><%= gender %></div>
    </div>

    <div class="row">
        <div class="label">Email</div>
        <div class="value"><%= email %></div>
    </div>

    <div class="row">
        <div class="label">Phone</div>
        <div class="value"><%= phone %></div>
    </div>

    <div class="row">
        <div class="label">Address</div>
        <div class="value"><%= address %></div>
    </div>

</div>


<h3 class="section-title">Education & Career</h3>

<div class="details">

    <div class="row">
        <div class="label">Qualification</div>
        <div class="value"><%= qualification %></div>
    </div>

    <div class="row">
        <div class="label">Specialization</div>
        <div class="value"><%= specialization %></div>
    </div>

    <div class="row">
        <div class="label">Skills</div>
        <div class="value"><%= skills %></div>
    </div>

    <div class="row">
        <div class="label">Experience</div>
        <div class="value"><%= experience %></div>
    </div>

    <div class="row">
        <div class="label">Preferred Job Role</div>
        <div class="value"><%= jobrole %></div>
    </div>

    <div class="row">
        <div class="label">Expected Salary</div>
        <div class="value"><%= salary %></div>
    </div>

</div>


<h3 class="section-title">Other Details</h3>

<div class="details">

    <div class="row">
        <div class="label">Preferred Location</div>
        <div class="value"><%= location %></div>
    </div>

    <div class="row">
        <div class="label">LinkedIn Profile</div>
        <div class="value"><%= linkedin %></div>
    </div>

</div>


<a href="register.html" class="back-btn">
    Back to Registration
</a>

</div> </body> </html>