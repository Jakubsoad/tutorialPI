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

    $login=htmlentities($login, ENT_QUOTES, "UTF-8");

    $sql = "";
    if ($result = @$conn->query(sprintf("SELECT * FROM users WHERE user='%s' AND password='%s'",
        mysqli_real_escape_string($conn, $login))))
    {
        $users = $result->num_rows;
        if ($users==1)
        {
            $row=$result->fetch_assoc();
            if (password_verify($pwd, $row['password']))
            {
                $_SESSION['login'] = true;
                $_SESSION['id'] = $row['id'];
                $_SESSION['user'] = $row['user'];
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
        else
        {
            $_SESSION['error']='<span style="color:red">Wrong login or password!</span>';
            header("Location: index.php");
        }
    }

    $conn->close();

}


