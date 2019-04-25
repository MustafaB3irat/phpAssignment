<?php

session_name("session_name");
session_start();

if (!isset($_SESSION['page']))
    $_SESSION['page'] = "review.php";

include "layout.php";
include "model.php";

if (!isset($_SESSION['user'])) {
    header("Location:login.php");

}
if (isset($_SESSION['user'])) {

    $conn = getConnection();


    $res = getByEmail($_SESSION['user'], $conn);
    ?>
    <div class="container" style="margin-top: 100px;width: 600px;height: 600px">

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" style="font-size: 1.3pc">Name</th>
                <th scope="col" style="font-size: 1.3pc">GPA</th>
                <th scope="col" style="font-size: 1.3pc">Year</th>
                <th scope="col" style="font-size: 1.3pc">Gender</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                while ($row = $res->fetch()) {

                    echo "<td style=\"font-size: 1.2pc\">" . $row['name'] . "</td>";
                    echo "<td style=\"font-size: 1.2pc\">" . $row['gpa'] . "</td>";
                    echo "<td style=\"font-size: 1.2pc\">" . $row['year'] . "</td>";

                    $gender = "Male";
                    if ($row['gender'] == 'F')
                        $gender = "Female";

                    echo "<td>" . $gender . "</td>";

                }
                ?>
            </tr>

            </tbody>
        </table>
        <a class="btn btn-primary" href="update.php">Edit</a>
    </div>
<?php } ?>

</body>
</html>