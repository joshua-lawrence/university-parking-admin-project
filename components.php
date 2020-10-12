<?php

class Components {
    static function renderNav() {
        ob_start();
        ?>
        <nav class="navbar navbar-light bg-light">
            <div class="container">
                <a href="index.php"><span class="navbar-brand mb-0 h1"><span style="color: red;
                font-size: 24px; font-weight: 800;">U</span> Parking System</span></a>
                <div class="navbar mr-auto">
                    <a class="nav-item nav-link" href="vehicles.php">Vehicles</a>
                    <a class="nav-item nav-link" href="violations.php">Violations</a>
                </div>
                <div class="navbar ml-auto">
                    <a href="login.php" style="padding-right: 20px;">Sign In</a>
                    <a href="settings.php"><img style="width: 50px;" src="https://nolashaolin.com/wp-content/uploads/2018/07/placeholder-face-big.png"></a>
                </div>
            </div>
        </nav>
        <?php
        echo ob_get_clean();
    }
}