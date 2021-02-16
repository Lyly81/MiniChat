<?php
    declare(strict_types=1);

    /**
     * Connection à la base de données.
     */
    require_once('connection.php');

/**
 * LA PAGINATION
 * 
 * C'est la séparation en plusieurs pages d'une liste de données.
 */

    /**
     * Requête pour voir le nombre total de messages dans la base de données.
     */
    $query = $db->query(
        "SELECT COUNT(*) AS nbMessage
        FROM minichat");
    $data = $query->fetch();

    /**
     * Mettre le nombre de messages de la base de données dans une variable.
     */
    $nbMessage = $data['nbMessage'];

    /**
     * La limite du nombre de messages que l'on veut voir par page.
     */
    $perPage = 5;

    /**
     * Le numero de page.
     * La fonction ceil() arrondi au nombre supérieur, et retourne l'entier supérieur du nombre.
     */
    $nbPage = ceil($nbMessage / $perPage);

    /**
     * Pour savoir sur quelle page on se trouve.
     * Avec isset, on vérifie si une variable est considérée définie, ceci signifie qu'elle est déclarée et est différente de NULL. 
     * Avec !empty, on vérifie que la variable n'est pas vide.
     * Avec ctype_digit, on vérifie si tous les caractères de la chaîne text sont des chiffres. Retourne TRUE si tous les caractères du texte sont des chiffres décimaux, FALSE sinon. 
     * $current pour page courante.
     */
    if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbPage ) {
        // $cPage = $page;
        if ($_GET['page'] > $nbPage) {
            $current = $nbPage;
        }else{
            $current = $_GET['page'];
        }
    }
    else {
        $current = 1;// $cPage = 1;
    }

    /**
     * On calcule le numéro du premier élément de la page à récupérer.
     */
    $firstOfPage = ($current-1) * $perPage;

/**
 * Partie "requête".
 */
    /**
     * On prépare la requête à son exécution.
     * Construire la requête, en remplaçant les valeurs par des marqueurs nominatifs. On place un marqueur là ou la valeur devrait se trouver, sans oublier les deux points ":".
     */
    $query = $db->prepare(
        "SELECT pseudo, message, DATE_FORMAT(dateMessage, \"%d/%m/%Y à %H:%i:%s\") AS dateMessage_fr
        FROM minichat 
        ORDER BY ID DESC
        LIMIT :perPage
        OFFSET :firstOfPage"
    );
    /**
     * On lie une valeur à la requête, soit remplacer de manière sûre un marqueur par sa valeur, nécessaire pour que la requête fonctionne.
     */
    $query->bindValue(
        'perPage',              // Le marqueur est nommé "perPage".
        $perPage,               // Il doit prendre la valeur de la variable $perPage.
        PDO::PARAM_INT          // Cette valeur est de type entier.
    );
    $query->bindValue(
        'firstOfPage',          // Le marqueur est nommé "firstOfPage".
        $firstOfPage,           // Il doit prendre la valeur de la variable $firstOfPage.
        PDO::PARAM_INT          // Cette valeur est de type entier.
    );
    /**
     * Maintenant qu'on a lié la valeur à la requête, on peut l'exécuter.
     */
    $query->execute();

/**
 * Partie "boucle".
 */
    /**
     * La boucle pour afficher les messages par page.
     */
    while ($element = $query->fetch()) {
        echo '<p><strong>' . htmlspecialchars($element['pseudo']) . '</strong>' . ' le ' . '<em>' . htmlspecialchars($element['dateMessage_fr']) . '</em><br />' .
        nl2br(htmlspecialchars($element['message'])) . '</p>';
    }

/**
 * Partie "liens".
 */
    /**
     * Si on est sur la première page, on n'a pas besoin d'afficher de lien vers la précédente. On va donc l'afficher que si on est sur une autre page que la première.
     */
    if ($current > 1) :
        ?>
        <a href="?page=<?= $current - 1; ?>">Page précédente</a>
        -
    <?php endif;

   /**
    * On effectue une boucle autant de fois que l'on a de pages.
    */ 
    for ($i = 1; $i <= $nbPage; $i++) :
        ?>
        <a href="?page=<?= $i; ?>"><?= $i; ?></a>
    <?php endfor;

    /**
     * Avec le nombre total de pages, on peut aussi masquer le lien vers la page suivante quand on est sur la dernière.
     */
    if ($current < $nbPage) :
        ?>
        -
        <a href="?page=<?= $current + 1; ?>">Page suivante</a>
    <?php endif;
    

/**
 * Ferme le curseur, permettant à la requête d'être de nouveau exécutée.
 */
    $query->closeCursor();
    ?>
