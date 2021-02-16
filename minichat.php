<?php

declare(strict_types=1);
require_once('connection.php');
require_once('pseudo.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>TP - Mini-Chat</title>
</head>

<body>
    <div id="page">
        <header>
            <h1>Mon premier mini-chat</h1>

            <nav>
                <ul class="flex">
                    <li><a href="#">Acceuil</a></li>
                    <li><a href="#">Mini-Chat</a></li>
                    <li><a href="#">Le Blog</a></li>
                    <li><a href="#">L'espace membre</a></li>
                </ul>
            </nav>
        </header>

        <div class="flex">

            <section class="blog">


            </section>

            <section class="minichat">
                <form action="minichat_post.php" method="POST">
                    <label for="pseudo">Pseudo : </label>
                    <input id="pseudo" type="text" name="pseudo" value="<?php if (!empty($_COOKIE['pseudo'])) {
                                                                            echo htmlspecialchars($_COOKIE['pseudo']);
                                                                        } ?>"><br>
                    <label for="message">Message : </label>
                    <textarea name="message" id="message" cols="22" rows="10"></textarea>
                    <input type="submit" value="Envoyer">
                </form>

                <div class="message">
                    <?php require_once('pagination.php'); ?>
                </div>
            </section>
        </div>
        <footer>

        </footer>
    </div>
</body>

</html>