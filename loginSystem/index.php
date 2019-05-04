<?php
session_start();

if (isset($_SESSION['login']) && $_SESSION['login']==true )
{
    header("Location: loginSite.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Login System</title>
</head>
<body>
<form action="login.php" method="post">
Login: <br>
    <input type="text" name="login" placeholder="Login"> <br>
Password: <br>
    <input type="password" name="pwd" placeholder="Password">
    <br><br>
        <input type="submit" name="login-submit">
</form>
<?php
if (isset($_SESSION['error']))
    echo $_SESSION['error'];
?>

</body>

</html>