<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<?php
function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function insertcustomersql($email,$name,$hash,$ip)
{
$dbhostname = "localhost";
$dbusername = "putsie";
$dbpassword = "XoXsowybutthisgoeshere";
$db = "Banksys";

// Create connection
$conn = new mysqli($dbhostname, $dbusername, $dbpassword, $db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO customer_login (email,salt,hash) VALUES ('$email','$ip','$hash');";
$sql2 =  "INSERT INTO customer (first_name,email) VALUES ('$name','$email');";

if(($conn->query($sql) === TRUE) && ($conn->query($sql2) === TRUE)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
}
function validEmail($email){
    // First, we check that there's one @ symbol, and that the lengths are right
    if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        return "Please enter a valid email";
    }
    // Split it into sections to make life easier
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) {
        if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
            return "Please enter a valid email";
        }
    }
    if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2) {
            return "Please enter a valid email"; // Not enough parts to domain
        }
        for ($i = 0; $i < sizeof($domain_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                return "Please enter a valid email";
            }
        }			
    }

    return true;
}

function validName($name)
{
if (preg_match('/[A-Za-z_-]/', $name)) {
  return true;
}
else
{
	return "Please enter your first name";
}
}
function validPsw($psw,$errorpsw)
{
if(!empty($psw) && $psw != "" )
{
    if (strlen($psw) < '8')
	{
        $errorpsw .= "Your Password Must Contain At Least 8 Digits !"."<br>";
    }
    elseif(!preg_match("#[0-9]+#",$psw)) {
        $errorpsw .= "Your Password Must Contain At Least 1 Number !"."<br>";
    }
    elseif(!preg_match("#[A-Z]+#",$psw)) {
        $errorpsw .= "Your Password Must Contain At Least 1 Capital Letter !"."<br>";
    }
    elseif(!preg_match("#[a-z]+#",$psw)) {
        $errorpsw .= "Your Password Must Contain At Least 1 Lowercase Letter !"."<br>";
    }
    elseif(!preg_match('/[^a-zA-Z\d]/',$psw)) {
        $errorpsw .= "Your Password Must Contain At Least 1 Special Character !"."<br>";
    }
	return $errorpsw;
}
else
{
    return "Please Enter your password"."<br>";
}
}

function validpswrepeat($psw,$passRepeat)
{
if ($psw === $passRepeat)
{
  return true;
}
else
{
	return "Passwords must match";
}
}

$erroremail = "";
$errorname = "";
$errorpsw = "";
$errorpswrepeat = "";

if(isset($_POST["submit"]))
{
$email = $_POST["email"];
$name = $_POST["first_name"];
$psw =$_POST["psw"];
$passRepeat =  $_POST["psw-repeat"];

$erroremail = validEmail($email);
$errorname = validName($name);
$errorpsw = validPsw($psw,$errorpsw);
$errorpswrepeat = validpswrepeat($psw,$passRepeat);

if($erroremail === true)
{
	$erroremail="";
	if($errorname === true)
	{
		$errorname = "";
		if($errorpsw == "")
		{
			if($errorpswrepeat === true)
			{
				$errorpswrepeat="";
				$ip = getUserIpAddr();
				$cat = $ip.$psw;
				$hash = hash('sha256', $cat);
				insertcustomersql($email,$name,$hash,$ip);
			}
		}
	}

}
elseif($errorname === true)
	{
		$errorname = "";
		if($errorpsw == "")
		{
			if($errorpswrepeat === true)
			{
				$errorpswrepeat = "";
			}
		}
	}
if($errorpswrepeat === true)
			{
				$errorpswrepeat = "";
			}
			
}
?>
<div>
  <form class="modal-content" method="POST" action="Customer_signup.php">
    <div class="container">
      <h1>Sign Up</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>
      <label for="email"><b>Email</b></label>
      <input type="text" value="<?php if(isset($_POST["submit"])){echo $email;}?>" placeholder="Enter Email" name="email" required>
	  <?php echo "<span class='error';>".$erroremail."</span>";?>
	  <br>
	  <br>
	  <label for="first_name"><b>First name</b></label>
      <input type="text"  value="<?php if(isset($_POST["submit"])){echo $name;}?>" placeholder="Enter first name" name="first_name" required>
      <?php echo "<span class='error';>".$errorname."</span>";?>
	  <br>
	  <br>
      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>
	   <?php echo "<span class='error';>".$errorpsw."</span>";?>
	  <br>
	  <br>
      <label for="psw-repeat"><b>Repeat Password</b></label>
      <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
      <?php echo "<span class='error';>".$errorpswrepeat."</span>";?>
	  <br>
	  <br>
      <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

        <button type="button" onclick="location.href = 'index.php';" class="cancelbtn">Cancel</button>
        <button type="submit" name="submit" class="signupbtn">Sign Up</button>
    </div>
  </form>
</div>
</body>
</html>
