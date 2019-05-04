<?php
require_once "dbConnect.php";
session_start();

if ((!isset($_POST['login']))||(!isset($_POST['pwd'])))
{
    header("Location: index.php");
    exit();
}

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
        $users = $result->num_rows;
        if ($users==1)
        {
            $_SESSION['login']=true;
            $row=$result->fetch_assoc();
            $_SESSION['id']=$row['id'];
            $_SESSION['user']=$row['user'];
            unset($_SESSION['error']);
            $result->close();
            header("Location: loginSite.php");

        }
        else
        {
            $_SESSION['error']='<span style="color:red">Wrong login or password!</span>';
            header("Location: index.php");
        }
    }

    $conn->close();

}


