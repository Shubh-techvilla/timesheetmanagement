<?php 

    $password = 'techvilla';
    $hashpwd = password_hash(($password), PASSWORD_DEFAULT);
    echo $hashpwd;
?>