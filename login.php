<?php

include "layout.php";
include "model.php";
session_name("session_name");
session_start();

if (!isset($_SESSION['page']))
    $_SESSION['page'] = "review.php";
?>


    <div class="container" style="margin-top: 100px;width: 600px;height: 600px">
        <form action="login.php" method="post" enctype="application/x-www-form-urlencoded">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                       placeholder="Enter email" name="email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.
                </small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"
                       name="password">
            </div>
            <button type="submit" class="btn btn-primary" name="login">Login</button>
        </form>
    </div>

<?php


if (isset($_POST['login']) && !isset($_SESSION['user'])) {


    $conn = getConnection();

    $res = login($_POST['email'], md5($_POST['password']), $conn);

    $email = "";
    if ($row = $res->fetch()) {
        $email = $row['email'];

        $_SESSION['user'] = $email;
        $_SESSION['name'] = $row['name'];
        $_SESSION['gender'] = $row['gender'];


    } else { ?>
        <div class="alert alert-danger container" style="width: 600px;position: relative;top: -280px">
            <strong>Error!</strong> Login Failed! Please Try Again
        </div> <?php
    }
}

if (isset($_SESSION['page']) && isset($_SESSION['user'])) {

    header("Location:" . $_SESSION['page']);
}
