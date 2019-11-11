<?php
function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}

function quiryemployeesql()
{
$dbhostname = "localhost";
$dbusername = "looksie";
$dbpassword = "OwOletmesee";
$db = "banksys";
$Employee_No = htmlspecialchars($_POST["Employee_id"]);

$dbconnect=mysqli_connect($dbhostname,$dbusername,$dbpassword,$db);

if ($dbconnect->connect_error) {
  die("Database connection failed: " . $dbconnect->connect_error);
}

$query = mysqli_query($dbconnect, "SELECT * FROM login where Employee_No = " . $Employee_No)
   or die (mysqli_error($dbconnect));

$password = md5(htmlspecialchars($_POST["Employee_password"]));

	while($row = mysqli_fetch_array($query))
{
    if($row['Hash'] === $password)
	{Redirect('http://www.google.ie', false);
	}
	else
	{Redirect('http://www.yahoo.ie',false);
	}
}
}

function quirycustomersql()
{
$dbhostname = "localhost";
$dbusername = "looksie";
$dbpassword = "OwOletmesee";
$db = "banksys";
$Customer_id = htmlspecialchars($_POST["Customer_id"]);

$dbconnect=mysqli_connect($dbhostname,$dbusername,$dbpassword,$db);

if ($dbconnect->connect_error) {
  die("Database connection failed: " . $dbconnect->connect_error);
}

$query = mysqli_query($dbconnect, "SELECT * FROM Customer_login where email = " . $Customer_id)
   or die (mysqli_error($dbconnect));

$password = md5(htmlspecialchars($_POST["Employee_password"]));

	while($row = mysqli_fetch_array($query))
{
    if($row['Hash'] === $password)
	{Redirect('http://www.google.ie', false);
	}
	else
	{Redirect('http://www.yahoo.ie',false);
	}
}
}
?>