<?php

session_start();

include "../config/koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$data = mysqli_query($conn,"SELECT * FROM users WHERE username='$username'");

if(mysqli_num_rows($data)==1){

    $user = mysqli_fetch_assoc($data);

    if($password == $user['password']){

        $_SESSION['login']=true;
        $_SESSION['username']=$user['username'];

        header("Location: ../home.php");

    }else{

        echo "<script>
        alert('Username atau Password salah');
        window.location='login.php';
        </script>";

    }

}else{

    echo "<script>
    alert('Username Tidak Ditemukan');
    window.location='login.php';
    </script>";

}