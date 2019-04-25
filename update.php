<?php

session_name("session_name");
session_start();

if (!isset($_SESSION['page']))
    $_SESSION['page'] = "update.php";

include "layout.php";
include "model.php";

if (!isset($_SESSION['user'])) {
    header("Location:login.php");

}
if (isset($_SESSION['user'])) {

    $conn = getConnection();


    $res = getByEmail($_SESSION['user'], $conn);

    if ($row = $res->fetch()) {
        $info = array("name" => $row['name'], "email" => $row['email'], "gpa" => $row['gpa'], "password" => $row['password'], "gender" => $row['gender'], "year" => $row['year']);

        $gender = "Male";
        if ($info['gender'] == 'F')
            $gender = "Female";

    }
    ?>
    <div class="container" style="margin-top: 100px;width: 600px;height: 600px">


    <form method="post" action="update.php">

        <div class="form-group">

            <fieldset>
                <legend>Submit an Applicant</legend>

                <label for="name" style="margin-top: 15px">Name:</label>
                <input type="text" id="name" class="form-control" name="name"
                       placeholder="Enter The Applicant's Name" value="<?= $info['name'] ?>"
                       style="align-content: center;font-size: 1.1pc">

                <input type="hidden" name="oldEmail" value="<?= $info['email'] ?>">
                <input type="hidden" name="oldPasswordValue" value="<?= $info['password'] ?>">

                <label for="email" style="margin-top: 15px">Email:</label>
                <input type="email" id="email" class="form-control" name="email" placeholder="Enter Email"
                       style="align-content: center;font-size: 1.1pc" value="<?= $info['email'] ?>">

                <label for="oldPassword" style="margin-top: 15px">Old Password:</label>
                <input type="password" id="oldPassword" class="form-control" name="oldPassword"
                       placeholder="Old Password"
                       style="align-content: center;font-size: 1.1pc">

                <div class="form-row">
                    <div class="form-group col-6">
                        <label for="password" style="margin-top: 15px">new Password:</label>
                        <input type="password" id="password" class="form-control" name="password"
                               placeholder="Enter Password" style="align-content: center;font-size: 1.1pc"
                        >
                    </div>

                    <div class="form-group col-6">
                        <label for="repassword" style="margin-top: 15px"> Re enter Password:</label>
                        <input type="password" id="repassword" class="form-control" name="repassword"
                               placeholder="Re Enter Password" style="align-content: center;font-size: 1.1pc"
                        >
                    </div>
                </div>

                <label for="year" style="margin-top: 15px">Year:</label>
                <input type="range" id="year" class="form-control-range" name="year" min="1" max="5" size="5"
                       onchange="f()" value="<?= $info['year'] ?>">
                <input type="text" readonly id="yearValue" name="yearValue" style="width: 30px"
                       value="<?= $info['year'] ?>"><br/>

                <label for="gpa" style="margin-top: 15px">GPA:</label>
                <input type="text" id="gpa" class="form-control" name="gpa" placeholder="Enter GPA"
                       style="align-content: center;font-size: 1.1pc" value="<?= $info['gpa'] ?>">

                <div class="form-check form-check-inline" style="margin-top: 15px">
                    <label for="male" class="form-check-label"
                           style="font-size: large;margin-right: 5px">Male</label>
                    <input type="radio" id="male" value="Male" class="form-check-input" name="gender"
                           style="margin-right: 10px">
                    <label for="female" class="form-check-label"
                           style="font-size: large;margin-right: 5px">Female</label>
                    <input type="radio" id="female" value="Female" class="form-check-input" name="gender"
                           style="margin-right: 10px">

                    <?php

                    if ($gender == "Male") {
                        ?>
                        <script type="text/javascript">
                            document.getElementById("male").checked = true;
                        </script>
                    <?php
                    }else if ($gender == "Female"){

                    ?>
                        <script type="text/javascript">
                            document.getElementById("female").checked = true;
                        </script>
                        <?php
                    }

                    ?>

                </div>

                <div class="form-row" style="margin-top: 10px">
                    <div class="form-group col-6">
                        <input type="submit" class="btn btn-primary" value="Update" id="apply" name="apply"
                               style="width: 100%">
                    </div>
                    <div class="form-group col-6">
                        <input type="reset" value="Clear" class="btn btn-primary" style="width: 100%">
                    </div>

                </div>
                <small>&copy;Mustafa B3irat 2019</small>
            </fieldset>

        </div>


        <script>

            function f() {
                if (document.getElementById("yearValue").value != document.getElementById("year").value)
                    document.getElementById("yearValue").value = document.getElementById("year").value
            }

        </script>

    </form>
    <?php
} ?>
    </div>
    </body>
    </html>


<?php

if (isset($_POST['apply'])) {

    $email = $_POST['email'];
    $name = $_POST['name'];
    $oldPassword = $_POST['oldPassword'];
    $oldPasswordValue = $_POST['oldPasswordValue'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $gpa = $_POST['gpa'];
    $year = $_POST['year'];
    $gender = $_POST['gender'];
    $oldEmail = $_POST['oldEmail'];

    $applicant = ["Email" => $email, "Name" => $name, "Password" => $password, "repassword" => $repassword, "gpa" => $gpa, "gender" => $gender, "year" => $year];

    $set = true;
    foreach ($applicant as $key => $value) {

        if (!isset($value))
            $set = false;
    }

    $passSet = true;

    if ($password != $repassword || ($oldPasswordValue != md5($oldPassword)))
        $passSet = false;


    if ($passSet)
        $password = md5($password);


    include_once 'model.php';

    if ($set and $passSet) {

        $conn = getConnection();

        if ($gender == "Male")
            $gender = 'M';
        else
            $gender = 'F';

        updateApplicant($email, $name, $gpa, $password, $year, $gender, $conn, $oldEmail);
        $_SESSION['user'] = $email;
        $_SESSION['name'] = $name;
        $_SESSION['gender'] = $gender;

        ?>

        <div class="alert alert-success container alert-dismissible" style="width: 600px;position: relative;top: 100px">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> Updated Successfully!
        </div><?php
    }

    if (!$set || !$passSet) {

        ?>

        <div class="alert alert-danger container alert-dismissible" style="width: 600px; position: relative;top: 100px">
            <strong>Failed!</strong> Please fill in the fields properly or check your password!
        </div><?php
    }


}


?>