<?php

use Core\Auth\DbAuth;

/**
 * The Big Hub
 * @authors Matth Schmit (@MatthSchmit), Tim Chapelle (@timchapelle)
 * https://github.com/thebighub
 *
 * Template (gabarit) par défaut du site
 */
$app = App::getInstance();
if (isset($_SESSION["auth"])) {
    $currentUser = $app->getTable('Utilisateur')->find($_SESSION["auth"]);
}

?>
<!DOCTYPE html>
<!--

VideOO - Site collaboratif (avec api allocine en prime)

-->
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $app->titre ?></title>
    </head>
    <body><?php
        include (ROOT . '/app/Vues/trame/head.php');

        if (isset($currentUser) && $currentUser->admin) {
            include (ROOT . '/app/Vues/admin/trame/topbar.php');
        } else if (!empty($_SESSION["auth"])) {
            include (ROOT . '/app/Vues/membres/trame/topbar.php');
        } else {
            include (ROOT . '/app/Vues/trame/topbar.php');
        }
        ?>
        <div class="container-fluid">
            <div class="section">
                <div class="row">
                        <?php
                        if (isset($currentUser) && $currentUser->admin) {
                            echo '<div class=col-sm-3>';
                            include (ROOT . '/app/Vues/admin/trame/sidebar.php');
                            echo '</div>';
                        } else if (!empty($_SESSION["auth"])) {
                            echo '<div class=col-sm-3>';
                            include (ROOT . '/app/Vues/membres/trame/sidebar.php');
                            echo '</div>';
                        }
                        ?>
                    
                    <div class="col-sm-9">
                        <?= $contenu ?>
                    </div>
                </div>
            </div>
        </div>
<?php include(ROOT . '/app/Vues/trame/footer.php'); ?>
        
    </body>
</html>

