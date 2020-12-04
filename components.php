<?php

require_once("entities.php");

class Components {
    static function renderNav($user) {
        ob_start();
        ?>
        <nav class="navbar navbar-light bg-light">
            <div class="container">
                <a href="index.php">
                <span class="navbar-brand mb-0 h1">
                    <span style="color: red; font-size: 24px; font-weight: 800;">U</span> 
                    Parking System
                    <?php
                        if($user['type'] == 1) {
                            echo 'Admin';
                        }
                    ?>
                </span>
                </a>
                <div class="navbar mr-auto">
                    <a class="nav-item nav-link" href="vehicles.php">Vehicles</a>
                    <a class="nav-item nav-link" href="violations.php">Violations</a>
                    <a class="nav-item nav-link" href="parkinglot.php">Parking Lot</a>
                    <?php
                        if($user['type'] == 1) {
                            echo '<a class="nav-item nav-link" href="users.php">Users</a>';
                        }
                    ?>
                </div>
                <div class="navbar ml-auto">
                    <button id="dropdownMenuButton" data-toggle="dropdown" type="button" class="dropdown-toggle" style="border: none; background: transparent">
                    <img style="width: 50px; height: 50px; border-radius: 50%" src="<?php echo Image::getImage($user["driver_id"]); ?>">
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="settings.php">View Profile</a>
                        <a class="dropdown-item" href="login.php?signout">Sign Out</a>
                    </div>
                </div>
            </div>
        </nav>
        <?php
        echo ob_get_clean();
    }

}