<?php
require_once "dbConnect.php";

$conn = @new mysqli($host, $dbUser, $dbPwd, $dbName);

if ($conn->connect_errno!=0)
{
    echo "Error: ".$conn->connect_errno;
}
else {

    $login = $_POST['login'];
    $pwd = $_POST['pwd'];

    $sql = "SELECT * FROM users WHERE user='$login' AND password='$pwd'";
    if ($result = @$conn->query($sql))
    {

    }

    $conn->close();

}
if (!isset($login))
    header("Location: ../index.php");

