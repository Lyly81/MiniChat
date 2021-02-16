<?php
    declare(strict_types=1);

    require_once('connection.php');


    if (!empty($_POST['pseudo'] AND $_POST['message'])) {
        // La requête qui insère le message :
        $requete = $db->prepare("INSERT INTO minichat(pseudo, message, dateMessage) VALUES(:pseudo, :message, NOW())");
        $requete->execute(array(
            'pseudo' => htmlspecialchars($_POST['pseudo']),
            'message' => htmlspecialchars($_POST['message'])
        ));
    }
    // Rediriger vers minichat.php :
    header('Location: minichat.php');

?>