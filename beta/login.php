<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // connect to MySQL db
    $db_host = "localhost";
    $db_username = "cen4010sp23g03";
    $db_password = "ASpring#2023";
    $db_name = "cen4010sp23g03";
    $db = mysqli_connect($db_host, $db_username, $db_password, $db_name);
    if (!$db) { die("No connection to MySQL database!" . mysqli_connect_error()); }

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql_cmd = "SELECT * FROM user_accounts WHERE username = '$username'";
    $result = mysqli_query($db, $sql_cmd);
    if($row = mysqli_fetch_assoc($result))
    {
        if(password_verify($password, $row["password"]))
        {
            // Password is correct, set session variable and redirect to index
            session_start();
            $_SESSION["user_id"] = $row["user_id"];
            header('Location: index.php');
            exit;
        }
        else
        {
            echo 'Incorrect password.';
        }
    }
    else
    {
        echo 'Incorrect username or password.'
    }

    mysqli_close($db);

}
?>

<form method="post">
    <h2>Log in</h2>
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    <br />
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    <br />
    <input type="submit" value="Log in">
</form>