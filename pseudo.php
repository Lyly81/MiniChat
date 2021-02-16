<?php
    declare(strict_types=1);

    require_once('connection.php');

    if (!empty($_POST['pseudo'])) {
        $pseudo = $_POST['pseudo'];
        setcookie('pseudo', $pseudo, time() + 365*24*3600, null, null, false, true);
    }
