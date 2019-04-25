<?php include "layout.php";
session_name("session_name");
session_start();

if (isset($_SESSION['user'])) {
    header("Location:review.php");
}
?>


    <div class="container" style="width: 600px;height: 600px;margin-top: 90px">

        <form method="post" action="main.php">

            <div class="form-group">

                <fieldset>
                    <legend>Submit an Applicant</legend>

                    <label for="name" style="margin-top: 15px">Name:</label>
                    <input type="text" id="name" class="form-control" name="name"
                           placeholder="Enter The Applicant's Name"
                           style="align-content: center;font-size: 1.1pc">

                    <label for="email" style="margin-top: 15px">Email:</label>
                    <input type="email" id="email" class="form-control" name="email" placeholder="Enter Email"
                           style="align-content: center;font-size: 1.1pc">

                    <div class="form-row">
                        <div class="form-group col-6">
                            <label for="password" style="margin-top: 15px">Password:</label>
                            <input type="password" id="password" class="form-control" name="password"
                                   placeholder="Enter Password" style="align-content: center;font-size: 1.1pc">
                        </div>

                        <div class="form-group col-6">
                            <label for="repassword" style="margin-top: 15px"> Re enter Password:</label>
                            <input type="password" id="repassword" class="form-control" name="repassword"
                                   placeholder="Re Enter Password" style="align-content: center;font-size: 1.1pc">
                        </div>
                    </div>

                    <label for="year" style="margin-top: 15px">Year:</label>
                    <input type="range" id="year" class="form-control-range" name="year" min="1" max="5" size="5"
                           onchange="f()">
                    <input type="text" readonly id="yearValue" name="yearValue" style="width: 30px"><br/>

                    <label for="gpa" style="margin-top: 15px">GPA:</label>
                    <input type="number" step="0.01" id="gpa" min="0" max="4" class="form-control" name="gpa"
                           placeholder="Enter GPA"
                           style="align-content: center;font-size: 1.1pc">

                    <div class="form-check form-check-inline" style="margin-top: 15px">
                        <label for="male" class="form-check-label"
                               style="font-size: large;margin-right: 5px">Male</label>
                        <input type="radio" id="male" value="Male" class="form-check-input" name="gender"
                               style="margin-right: 10px">
                        <label for="female" class="form-check-label"
                               style="font-size: large;margin-right: 5px">Female</label>
                        <input type="radio" id="female" value="Female" class="form-check-input" name="gender"
                               style="margin-right: 10px">
                    </div>

                    <div class="form-row" style="margin-top: 10px">
                        <div class="form-group col-6">
                            <input type="submit" class="btn btn-primary" value="Apply" id="apply" name="apply"
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
    </div>


    </body>
    </html>

<?php

if (isset($_POST['apply'])) {

    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $gpa = $_POST['gpa'];
    $year = $_POST['year'];
    $gender = $_POST['gender'];

    $applicant = ["Email" => $email, "Name" => $name, "Password" => $password, "repassword" => $repassword, "gpa" => $gpa, "gender" => $gender, "year" => $year];

    $set = true;
    foreach ($applicant as $key => $value) {

        if (!isset($value))
            $set = false;
    }

    $passSet = true;

    if ($password != $repassword)
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

        insertApplicant($name, $email, $gpa, $password, $gender, $year, $conn);
        $_SESSION['user'] = $email;
        $_SESSION['name'] = $name;
        $_SESSION['gender'] = $gender;


        header("Location:review.php");


        ?>

        <div class="alert alert-success container alert-dismissible" style="width: 600px;position: relative;top: 100px">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> Added To Database Successfully!
        </div>
        <?php
    }

    if (!$set || !$passSet) {

        ?>

        <div class="alert alert-danger container alert-dismissible" style="width: 600px;position: relative;top: 100px">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Failed!</strong> Please fill in the fields properly or check your password!

        </div>
        <?php
    }


}


?>