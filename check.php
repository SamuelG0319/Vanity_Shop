<?php
$connect = mysqli_connect("localhost", "root", "", "vanity_db");

if (isset($_POST['user_name'])) {
    $query = "SELECT * FROM user WHERE user = '".$_POST['user_name']."'";
    $result = mysqli_query($connect, $query);
    echo mysqli_num_rows($result);
}
?>
