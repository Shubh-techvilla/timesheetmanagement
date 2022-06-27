<?php
require_once('function/function.php');
// check_session(); 

$pdo = getPDOObject();

if (isset($_REQUEST['del_id'])) {
    $delId = $_REQUEST['del_id'];
    // echo $delId; die();
    $delQuery = "DELETE FROM candidate WHERE can_id=?";
    $stmt = $pdo->prepare($delQuery);
    $stmt->execute([$delId]);
    if ($stmt) {
        $msg = '<div class="alert alert-danger">Record deleted successfully!!!</div>';
        header('location:list-employee.php');
    }
}




?>
<!doctype html>
<html lang="en">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->


<?php require_once('includes/header_css.php'); ?>

<head>
    <title>List-employee</title>

<body>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        <?php require_once('includes/header.php'); ?>
        <div class="app-main">
            <?php require_once('includes/sidebar.php'); ?>

            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">List-employee

                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="main-card mb-3 card">
                                        <div class="card-body">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>id</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $query = "SELECT can_id,fname,lname,email,phone FROM `candidate` WHERE astatus='1' AND deleted='0'";

                                                    $stmt = $pdo->prepare($query);
                                                    $stmt->execute();

                                                    $cntRows = $stmt->rowCount();
                                                    $cnt = 1;

                                                    if ($cntRows) {
                                                        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    ?>
                                                            <tr>
                                                                <td><?= $cnt++; ?></td>
                                                                <td><?= $data['fname'] . " " . $data['lname']; ?></td>
                                                                <td><?= $data['email']; ?></td>
                                                                <td><?= $data['phone']; ?></td>

                                                                <td>
                                                                    <i data-toggle="modal" data-target="#exampleModal" class="fa fa-eye"></i>&nbsp;/&nbsp;
                                                                    <a href="?del_id=<?= $data['can_id'] ?>"><i class="fa fa-trash"></i></a>&nbsp;/&nbsp;
                                                                    <a href="edit-employee.php?canID=<?= $data['can_id'] ?>"><i class="fa fa-edit"></i></a>
                                                                </td>
                                                            </tr>

                                                    <?php

                                                        }
                                                    } else {
                                                        echo '<h4>No record found </h4>';
                                                    }
                                                    ?>
                                            </table>

                                        </div>
                                    </div>
                                    <?php require_once('includes/footer.php'); ?>
                                </div>
                            </div>

                            <div class="app-drawer-overlay d-none animated fadeIn"></div>
                            <script type="text/javascript" src="assets/scripts/main.cba69814a806ecc7945a.js"></script>
</body>

</html>