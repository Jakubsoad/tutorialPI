<?php
session_start();

require_once 'database.php';

$email = $_POST['email'];

if (!empty($email))
{
    $conn = $db->prepare("DELETE FROM users WHERE email=:email");
    $conn->bindValue(':email', $email, PDO::PARAM_STR);
    $conn->execute();

    $_SESSION['cancelledEmail']="Your e-mail address is erase from our database!";
}
else
{
    echo "siemanko";
    //header("Location: index.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Newsletter</title>
</head>
<body>
<h1>Your email is erase from our database!</h1>
<a href="index.php">Main site</a>
</body>

</html>
