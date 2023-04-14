<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // connect to MySQL db
    $db_host = "localhost";
    $db_username = "cen4010sp23g03";
    $db_password = "ASpring#2023";
    $db_name = "cen4010sp23g03";
    $db = mysqli_connect($db_host, $db_username, $db_password, $db_name);
    if (!$db) { die("No connection to MySQL database!" . mysqli_connect_error()); }

    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql_cmd = "INSERT INTO user_accounts (username, password) VALUES ('$username', '$password')";
    $result = mysqli_query($db, $sql_cmd);

    if (!$result)
    {
        echo 'Error creating account: ' . mysqli_error($db);
    }
    else
    {
        echo 'Account created successfully!';
    }

    mysqli_close($db);
    
}

?>

<form method="post">
    <h2>Create Account</h2>
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    <br />
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    <br />
    <input type="submit" value="Create Account">
</form>