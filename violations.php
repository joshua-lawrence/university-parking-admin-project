<?php 
    require_once("./components.php");
    require_once("./entities.php");
    
    session_start();

    if(!isset($_SESSION['username'])) {
        header('Location: login.php');
    }

    $user = User::getUser($_SESSION['username']);
    $user_id = $user["driver_id"];

    $drivers = User::getAllUsers();

    if (isset($_REQUEST["deleteviolation"]) && ($user['type'] == 1)) {
        Violation::deleteViolation($_REQUEST["deleteviolation"]);
    }

    if (isset($_REQUEST["saveviolation"])) {
        Violation::saveViolation($_REQUEST["driver"], $_REQUEST["license_plate"], $_REQUEST['amount']);
    }

    if(isset($_REQUEST['payviolation'])) {
        $pay = Violation::getViolation($_REQUEST['payviolation']);
    }

    if(isset($_REQUEST['paid'])) {
        $pay = Violation::payViolation($_REQUEST['paid']);
    }
    
    if($user['type'] == 1) {
        $violations = Violation::getAllViolations();
    }
    else {
        $violations = Violation::getUsersViolations($user_id);
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>U of U Parking System - <?php echo ucfirst(basename(__FILE__, '.php')); ?></title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    </head>
    <style>
        .card {
            font-size: 16px;
            position: relative;
            display: inline-block;
            vertical-align: middle;
            width: 425px;
            height: 270px;
            text-align: left;
            padding: 30px;
            margin-bottom: 50px;
            color: #fff;
            border-radius: 20px;
            box-sizing: border-box;
            background: grey;
        }

        .cardnumber {
            font-size: 30px;
            padding: 90px 0 15px;
            text-align: center;
        }

        .cardexp {
            font-size: 14px;
            padding-bottom: 20px;
            text-align: center;
        }

        .cardname {
            text-align: left;
        }
    </style>
    <body style="background-color: #f8f9fa;">

    <?php
    if(isset($_REQUEST['payviolation'])) {
        ob_start();
        ?>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pay Violation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card--front">
                        <div class="cardnumber"><?php echo $user['card'] ?></div>
                        <div class="cardexp"><?php echo $user['exp'] ?></div>
                        <div class="cardname"><?php echo $user['first_name'] . ' ' . $user['last_name'] ?></div>   
                    </div>
                    <br>
                    <h5>Total: <?php echo sprintf('$%01.2f', $pay['amount']); ?></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a type="button" href="violations.php?paid=<?php echo $pay['violation_id']; ?>" class="btn btn-success">Pay</a>
                </div>
                </div>
            </div>
            </div>
        <?php
        echo ob_get_clean();
    }
?>
 
 
<div class="container-fluid">
    <?php Components::renderNav($user); ?>
    <div class="container" style="margin-top: 30px;">
            <div class="row">
                <div class="col-sm-12" style="background-color: white; padding: 70px; box-shadow: 1px 1px 20px #eee">
                <?php if (isset($_REQUEST["saveviolation"])) echo('<div class="alert alert-success" role="alert">violation saved successfully!<button type="button" class="close" data-dismiss="alert">x</button></div>'); ?>
                <?php if(isset($_REQUEST["editviolation"]) || isset($_REQUEST["addviolation"])) {
                    ob_start();
                    ?>
                        <form action="violations.php">
                            <div class="form-group">
                                <label for="formGroupExampleInput">Driver</label>
                                <select name="driver" class="form-control">
                                <?php
                                    foreach($drivers as $driver) {
                                        echo("<option value='" . $driver['driver_id'] . "'>" . $driver['first_name'] . " " . $driver['last_name'] . "</option>");
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput">License Plate</label>
                                <input type="text" class="form-control" name="license_plate" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput">Amount</label>
                                <input type="number" min="1" step="any" class="form-control" name="amount" value="" required>
                            </div>
                            <input type="hidden" name="saveviolation" value="1">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="vehicles.php"><button type="button" class="btn btn-secondary">Cancel</button></a>
                        </form>
                    <?php
                    echo ob_get_clean();
                }
                else {
                    ob_start();

                    if($user['type'] == 1) {
                        echo '<h3>All Violations</h3>';
                        echo '<a href="violations.php?addviolation"><button class="btn btn-primary" style="float: right; margin-bottom: 10px;">Add a Violation</button></a>';
                    }
                    else {
                        echo '<h3>My Violations</h3>';
                    }

                ?>
                    <table class="table table-hover" style="margin-top: 30px;">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Amount Due</th>
                                <th scope="col">License Plate</th>
                                <?php
                                    if($user['type'] == 1) {
                                        echo('<th scope="col">Amount Due</th>');
                                        echo('<th scope="col">Driver</th>');
                                    }
                                ?>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($violations as $violation) {
                            ob_start();
                            ?>
                            <tr>
                                <td><?php echo $violation['date']; ?></td>
                                <td><?php echo $violation['amount']; ?></td>
                                <td><?php echo $violation['license_plate']; ?></td>
                                <?php
                                    if($user['type'] == 0) {
                                        if($violation['paid'] == 0) {
                                            echo('<td><a href="violations.php?payviolation=' . $violation['violation_id'] . '"><button class="btn btn-success" style="float: right;">Pay</button></a></td>');
                                        }
                                        else {
                                            echo('<td><span>Paid</span></td>');
                                        }
                                    }
                                    else {
                                        if($violation['paid'] == 0) {
                                            echo('<td>' . $violation['amount'] . '</td>');
                                        }
                                        else {
                                            echo('<td><span>Paid</span></td>');
                                        }
                                        echo('<td>' . $violation['first_name'] . ' ' . $violation['last_name'] . '</td>');
                                        echo('<td><a href="violations.php?deleteviolation="' . $violation['violation_id'] . '"><button class="btn btn-danger" data-id="' . $violation['violation_id'] . '" style="float: right;">Delete</button></a></td>');

                                    }
                                ?>
                            </tr>
                            <?php
                            
                        }
                        ?> 
                        </tbody>
                    </table>
                    <?php 
                    echo ob_get_clean();
                }
                    ?>
                </div>
            </div>
        </div>
</div>
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<?php
    if(isset($_REQUEST['payviolation'])) {
        ob_start();
        ?>
<script type="text/javascript">
    $(window).on('load',function(){
        $('#exampleModal').modal('show');
    });
</script>
<?php 
    echo ob_get_clean();
}
?>
</body>
</html>