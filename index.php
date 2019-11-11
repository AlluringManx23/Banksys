<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="stylesheet.css">
<link rel="stylesheet" type="text/css" href="//wpcc.io/lib/1.0.2/cookieconsent.min.css"/>
</head>
<body>
<?php
require 'sql_access.php';
require 'validation.php';
?>
<script src="//wpcc.io/lib/1.0.2/cookieconsent.min.js"></script>
<script>window.addEventListener("load", function(){window.wpcc.init({"border":"thin","corners":"small","colors":{"popup":{"background":"#222222","text":"#ffffff","border":"#fde296"},"button":{"background":"#fde296","text":"#000000"}},"position":"bottom","content":{"href":"https://dojivision.com/sample/cookie-policy/"}})});</script>

<button class="Cus-button" onclick="openCusForm()">Customer Login</button>

<button class="Emp-button" onclick="openEmpForm()">Employee Login</button>

<div class="CusForm-popup" id="CusForm">
  <form action="/customer_login.php" method="post" class="form-container">
    <h1>Login</h1>

    <label for="email"><b>Email Address</b></label>
    <input type="text" placeholder="Enter Email" name="Email_Address" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
	<p>Don't have an account? Create one <a href=Customer_signup.php>here</a></p>
    <button type="submit" class="btn">Login</button>
    <button type="button" class="btn cancel" onclick="closeCusForm()">Close</button>
  </form>
</div>

<div class="EmpForm-popup" id="EmpForm">
  <form action="/Employee_login.php" method="post" class="form-container">
    <h1>Login</h1>

    <label for="email" ><b>Email</b></label>
    <input type="text" placeholder="Enter your Email" name="Employee_id" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="Employee_password" required>

    <button type="submit" value="Submit" class="btn">Login</button>
	
    <button type="button" class="btn cancel" onclick="closeEmpForm()">Close</button>
  </form>
</div>

<script>
function openCusForm() {
  document.getElementById("CusForm").style.display = "block";
}

function openEmpForm() {
  document.getElementById("EmpForm").style.display = "block";
}

function closeCusForm() {
  document.getElementById("CusForm").style.display = "none";
}

function closeEmpForm() {
  document.getElementById("EmpForm").style.display = "none";
}
</script>

</body>
</html>


