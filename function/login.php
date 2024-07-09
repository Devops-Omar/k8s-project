<?php
include('db/dbconn.php');

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prevent SQL injection by using prepared statements (recommended)
    $query = "SELECT * FROM customer WHERE email=? AND password=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the query returned any rows
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Start session and set session variables
        session_start();
        $_SESSION['id'] = $row['customerid'];
        header("location: home.php");
        exit(); // Make sure to exit after redirection
    } else {
        echo "<script>alert('Invalid Email or Password')</script>";
        header("location: home.php");
        exit();
    }
}
?>
