<?php
session_start();
require_once 'database.php';


if (!isset($_SESSION['loggedID'])) {

    if (isset($_POST['login'])) {
        $login = filter_input(INPUT_POST, 'login');
        $pwd = filter_input(INPUT_POST, 'pwd');

        $userQuery = $db->prepare('SELECT id, pwd FROM admin WHERE name=:name');
        $userQuery->bindValue(':name', $login, PDO::PARAM_STR);
        $userQuery->execute();

        $user = $userQuery->fetch();

        if ($user && password_verify($pwd, $user['pwd'])) {
            $_SESSION['loggedID'] = $user['id'];
            unset($_SESSION['badAttempt']);
        } else {
            $_SESSION['badAttempt'] = true;
            header("Location: admin.php");
            exit();
        }

    } else {
        header("Location: admin.php");
        exit();
    }
}

$usersQuery = $db->query('SELECT * FROM users');
$users = $usersQuery->fetchAll();


?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Admin Panel</title>
</head>
<body>
<h1>Admin panel</h1>

<main>
    <article>
        <table>
            <thead>
            <tr><th colspan="2"><?=$usersQuery->rowCount()?> Records</th></tr>
            <tr><th>ID</th><th>E-mail</th></tr>
            </thead>
            <tbody>
            <?php
            foreach ($users as $user)
            {
                echo "<tr><td>{$user['id']}</td><td>{$user['email']}</td></tr>";
            }
            ?>
            </tbody>

        </table>
<p><a href="logout.php">Logout</a> </p>

    </article>
</main>


</body>

</html>