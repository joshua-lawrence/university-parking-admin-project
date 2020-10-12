<?php 
    require_once("components.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
     <title>U of U Parking System - <?php echo ucfirst(basename(__FILE__, '.php')); ?></title>
    </head>
<body style="background-color: #f8f9fa;">
 
<div class="container-fluid">
    <?php Components::renderNav(); ?>
    <div class="container" style="margin-top: 30px;">
        <div class="row">
            <div class="col-sm-12" style="background-color: white; padding: 70px; box-shadow: 1px 1px 20px #eee">
                <div class="row">
                    <div class="col-sm-5 text-center">
                        <img style="width: 80%;" src="https://nolashaolin.com/wp-content/uploads/2018/07/placeholder-face-big.png">
                    </div>
                    <div class="col-sm-6">
                        <form class="form-signin" style="padding: 10px;">
                            <label>Name</label>
                            <input type="text" id="name" class="form-control" placeholder="Name" required autofocus>
                            <label style="padding-top: 20px;">Email Address</label>
                            <input type="email" id="email" class="form-control" placeholder="Email Address" required>
                            <h4 style="padding-top: 60px;">Payment Information</h4>
                            <label style="padding-top: 20px;">Card Number</label>
                            <input type="number" id="cardnumber" class="form-control" placeholder="Card Number" required autofocus>
                            <label style="padding-top: 20px;">CCV Code</label>
                            <input type="number" id="ccv" class="form-control" placeholder="CCV Code" required autofocus>
                            <label style="padding-top: 20px;">Exp Date</label>
                            <input type="date" id="ccv" class="form-control" placeholder="Exp Date" required autofocus>
                            <button class="btn btn-primary btn-block" type="submit" style="margin-top: 30px;">Save Changes</button>
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