<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Login Site</title>
</head>
<body>

You are logged in!
<?php
echo "Hello ".$_SESSION['user']."!";
?>
<br><br>
<p><a href="logout.php">Logout</a></p>
</body>

</html>