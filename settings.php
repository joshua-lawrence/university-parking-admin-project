<?php 
    require_once("components.php");
    require_once("entities.php");

    session_start();

    if(!isset($_SESSION['username'])) {
        header('Location: login.php');
    }

    $user = User::getUser($_SESSION['username']);
    $user_id = $user["driver_id"];

    if (isset($_REQUEST["imgupload"])) {
        Image::uploadImage($user_id, $_FILES["myfile"]);
    }
    if (isset($_REQUEST["save"])) {
        User::updateUser($user_id, $_REQUEST["first_name"], $_REQUEST["last_name"], $_REQUEST["card"], $_REQUEST["ccv"], $_REQUEST["exp"]);
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

     <style>
        .picbutton {
            background: none;
            color: inherit;
            border: none !important;
            padding: 0;
            font: inherit;
            cursor: pointer;
            outline: none !important;
        }

        .picbutton:active img {
            border: 1px solid grey;
            border-radius: 50%;
        }

     </style>
    </head>
<body style="background-color: #f8f9fa;">
 
<div class="container-fluid">
    <?php Components::renderNav($user); ?>
    <div class="container" style="margin-top: 30px;">
        <div class="row">
            <div class="col-sm-12" style="background-color: white; padding: 70px; box-shadow: 1px 1px 20px #eee">
            <?php if (isset($_REQUEST["save"])) echo('<div class="alert alert-success" role="alert">Profile saved successfully!<button type="button" class="close" data-dismiss="alert">x</button></div>'); ?>
                    
                <div class="row">
                    <div class="col-sm-5 text-center">
                        <form action="settings.php?imgupload=1" method="POST" enctype="multipart/form-data">
                            <input type="file" accept="image/jpeg, image/png" name="myfile" id="imgupload" style="display:none" onchange="form.submit()"/> 
                            <button type="button" class="picbutton" onClick="$('#imgupload').trigger('click');"><img style="width: 300px; height: 300px; border-radius: 50%" src="<?php echo Image::getImage($user_id); ?>"></button>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <form action="settings.php" style="padding: 10px;">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?php echo $user['first_name']; ?>" required autofocus>
                            <label style="padding-top: 20px;">Last Name</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?php echo $user['last_name']; ?>" required autofocus>
                            <h4 style="padding-top: 60px;">Payment Information</h4>
                            <label style="padding-top: 20px;">Card Number</label>
                            <input type="number" name="card" class="form-control" placeholder="Card Number" value="<?php echo $user['card']; ?>" required autofocus>
                            <label style="padding-top: 20px;">CCV Code</label>
                            <input type="number" name="ccv" class="form-control" placeholder="CCV Code" value="<?php echo $user['ccv']; ?>" required autofocus>
                            <label style="padding-top: 20px;">Exp Date</label>
                            <input type="date" name="exp" class="form-control" placeholder="Exp Date" value="<?php echo $user['exp']; ?>" required autofocus>
                            <button class="btn btn-primary btn-block" type="submit" style="margin-top: 30px;">Save Changes</button>
                            <input type="hidden" name="save" />
                        </form>
                       </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>