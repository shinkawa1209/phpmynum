<?php
    session_start();

      //ログ
      $admin_name = $_SESSION['admin_name'];
      $fp = fopen('log.txt', 'a');
      fwrite($fp, date('Y-m-d H:i:s').": $admin_name was log out.\n");
      fclose($fp);

    $_SESSION['admin_login'] = false;
    unset($_SESSION['admin_name']);

    header('location:login.php');
