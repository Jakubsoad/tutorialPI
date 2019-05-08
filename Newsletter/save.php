<?php
session_start();


if (isset($_POST['email']))
{
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (empty($email))
    {
        header("Location: index.php");
        $_SESSION['givenEmail']=$_POST['email'];
        $_SESSION['wrongEmail'] = "Wrong E-mail adress";
    }
    else
    {
        require_once 'database.php';

        $query = $db->prepare('INSERT INTO users VALUES (NULL, :email)');
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
    }
}
else
{
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Thank you!</title>
</head>
<body>
<h1>Thank you <?php echo $email?>!</h1>




</body>

</html>