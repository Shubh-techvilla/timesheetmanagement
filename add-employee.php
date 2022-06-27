<?php
require_once('function/function.php');
check_session();
$pdo = getPDOObject();
$valid_ext = array("jpg", "jpeg", "png", "gif");
$validSize = 2 * 1024 * 1024;

// $counData = $_POST[$val['name']];
// $counData = implode(",", $_POST[$val['id']]);
// print_r( $counData);
// die();




if (isset($_POST['addEmp'])) {
    extract($_POST);
   
    // echo '<pre>';
    // print_r($_POST);
    // echo '<br>';
    // die();




    $highest_qual_str = implode(",", $_POST['highest_qual']);
    // echo $highest_qual_str; 
    // die();

    $skill_str = implode(",", $_POST['skills']);
    // echo $skill_str;
    // die();

    //For Image 

    if (isset($_FILES['image']['name'])) {
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $target_path = "timesheet/assets/images" .$fileName;
        if (!in_array($fileExt, $valid_ext)) {
            die("Invalid file");
        }
        if ($fileSize > $validSize) {
            die("file size is greater");
        } else {
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                die("Error in file upload");
            }
        }
    }


    $sql = "INSERT INTO candidate (
        fname,
        lname,
        email,
        phone,
        password,
        country,
        state,
        city,
        zip,
        address,
        landmark,
        position,
        dob,
        doj,
        highest_qual,
        skills,
        image,
        gender) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $fname,
        $lname,
        $email,
        $phone,
        $password,
        $country,
        $state,
        $city,
        $zip,
        $address,
        $landmark,
        $position,
        $dob,
        $doj,
        $highest_qual_str,
        $skill_str,
        $fileName,
        $gender
    ]);

    if ($stmt) {


        header('location:list-employee.php');
    } else {
        $msg = "Something went wrong";
    }
    die();
}


?>
<!doctype html>
<html lang="en">

<?php require_once('includes/header_css.php'); ?>

<head>
    <title>Add-employee</title>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        <?php require_once('includes/header.php'); ?>
        <div class="app-main">
            <?php require_once('includes/sidebar.php'); ?>

            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">Add-employee

                                <div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="main-card mb-3 card">
                                        <div class="card-body">
                                            <form action="" method="POST">
                                                <div class="row form-group">
                                                    <div class="col">
                                                        <label for="fname" class="form-label">First Name:</label>
                                                        <input type="text" name="fname" id="fname" class="form-control" placeholder="Enter the first name">
                                                    </div>
                                                    <div class="col">
                                                        <label for="lname" class="form-label">Last Name:</label>
                                                        <input type="text" name="lname" class="form-control" placeholder="Enter the last name">
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col">
                                                        <label for="email" class="form-label">Email:</label>
                                                        <input type="email" name="email" class="form-control" placeholder="Enter the email">
                                                    </div>
                                                    <div class="col">
                                                        <label for="phone" class="form-label">Phone:</label>
                                                        <input type="text" name="phone" pattern="\d{10}" minlength="10" maxlength="10" class="form-control" placeholder="Enter the phone no.">
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col">
                                                        <label for="password" class="form-label">Password:</label>
                                                        <input type="password" name="password" class="form-control" placeholder="Enter the password">
                                                    </div>
                                                    <div class="col">
                                                        <label for="country" class="form-label">Country:</label>
                                                        <select name="country" name="country" id="country" class="form-control">
                                                            <option value="">Select Country</option>
                                                            <?php
                                                            $contSql = $pdo->prepare("SELECT * FROM `countries`");
                                                            $contSql->execute();
                                                            $counData = $contSql->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($counData as $val) {
                                                                echo '<option value="' . $val['id'] . '">' . $val['name'] . '</option>';
                                                            }

                                                            ?>
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="row form-group">
                                                    <div class="col">
                                                        <label for="state" class="form-label">State:</label>
                                                        <select name="state" name="state" id="states" class="form-control">

                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <label for="city" class="form-label">City:</label>
                                                        <select name="city" name="city" id="city" class="form-control">

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col">
                                                        <label for="text" class="form-label">Zip code:</label>
                                                        <input type="text" name="zip" class="form-control"  pattern="\d{6}" maxlength="6" minlength="6" placeholder="Enter the pin code">
                                                    </div>
                                                    <div class="col">
                                                        <label for="address" class="form-label">Address:</label>
                                                        <input type="text" name="address" class="form-control" placeholder="Address here....">
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col">
                                                        <label for="landmark" class="form-label">Landmark:</label>
                                                        <input type="text" name="landmark" class="form-control" placeholder="landmark here...">
                                                    </div>
                                                    <div class="col">
                                                        <label for="position" class="form-label">Position:</label>&nbsp;&nbsp;
                                                        <select name="position" class="form-control">
                                                            <option value="">--Please Select--</option>
                                                            <option value="fresher">Fresher</option>
                                                            <option value="junior developer">Junior Developer</option>
                                                            <option value="senior developer">Senior Developer</option>
                                                            <option value="team leader">Team Leader</option>
                                                            <option value="manager">Manager</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col">
                                                        <label for="dob" class="form-label">DOB:</label>
                                                        <input type="date" name="dob" class="form-control" min="1990-01-01" max="2022-06-15" placeholder="date-of-birth here...">
                                                    </div>
                                                    <div class="col form-group">
                                                        <label for="doj" class="form-label">DOJ:</label>
                                                        <input type="date" name="doj" class="form-control" min="2022-06-10" placeholder="joining date here...">
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col">
                                                        <label for="highest_qual" name="highest_qual" class="form-label">Highest qualification:</label><br>

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="highest_qual[]" id="inlineCheckbox1" value="b.tech">
                                                            <label class="form-check-label" for="inlineCheckbox1">B.Tech</label>
                                                        </div>


                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="highest_qual[]" id="inlineCheckbox2" value="bca">
                                                            <label class="form-check-label" for="inlineCheckbox2">BCA</label>
                                                        </div>

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="highest_qual[]" id="inlineCheckbox3" value="ba">
                                                            <label class="form-check-label" for="inlineCheckbox3">BA</label>
                                                        </div>

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="highest_qual[]" id="inlineCheckbox4" value="mba">
                                                            <label class="form-check-label" for="inlineCheckbox4">MBA</label>
                                                        </div>

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="highest_qual[]" id="inlineCheckbox5" value="b.com">
                                                            <label class="form-check-label" for="inlineCheckbox5">B.Com</label>
                                                        </div>
                                                    </div>
                                                    <div class="col form-group">
                                                        <label for="skills" name="skills" class="form-label">skills:</label><br>

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="skills[]" id="inlineCheckbox6" value="c++">
                                                            <label class="form-check-label" for="inlineCheckbox6">C++</label>
                                                        </div>

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="skills[]" id="inlineCheckbox7" value="java">
                                                            <label class="form-check-label" for="inlineCheckbox7">JAVA</label>
                                                        </div>

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="skills[]" id="inlineCheckbox8" value="reactjs">
                                                            <label class="form-check-label" for="inlineCheckbox8">REACTJS</label>
                                                        </div>

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="skills[]" id="inlineCheckbox9" value="php">
                                                            <label class="form-check-label" for="inlineCheckbox9">PHP</label>
                                                        </div>

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" name="skills[]" id="inlineCheckbox10" value="js">
                                                            <label class="form-check-label" for="inlineCheckbox10">JS</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row form-group">
                                                    <div class="col">
                                                        <label for="image" class="form-label">Image:</label>
                                                        <input type="file" name="image">
                                                    </div>
                                                    <div class="col">
                                                        <label for="gender">Gender:</label><br>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" name="gender" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="M">
                                                            <label class="form-check-label" for="inlineRadio1">Male</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" name="gender" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="F">
                                                            <label class="form-check-label" for="inlineRadio2">Female</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3 text-center">
                                                    <div class="col">
                                                        <button type="submit" name="addEmp" class="btn btn-primary rounded-pill btn-lg px-5">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <?php require_once('includes/footer.php'); ?>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="assets/scripts/main.cba69814a806ecc7945a.js"></script>

</body>

</html>
<script src="assets/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        /** Get State on Country Change  */
        $("#country").change(function() {
            cid = $(this).val();
            if (cid) {
                $.ajax({
                    method: 'post',
                    url: 'http://localhost/timesheet/ajax/ajax.php',
                    data: {
                        'action': 'getState',
                        'countID': cid
                    },
                    success: function(resp) {
                        // alert(resp);
                        $("#states").html(resp);
                    }
                });

            } else {
                alert("Please select country");
            }
        });

        /** Get City on State Change  */

        $("#states").change(function() {
            sid = $(this).val();
            if (sid) {
                $.ajax({
                    method: 'post',
                    // async:false,
                    url: 'http://localhost/timesheet/ajax/ajax.php',
                    data: {
                        'action': 'getCity',
                        'stateID': sid
                    },
                    success: function(resp) {
                        // alert(resp);
                        $("#city").html(resp);
                    }
                });

            } else {
                alert("Please select state");
            }
        });
    });
</script>