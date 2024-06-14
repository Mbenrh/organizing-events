<?php
    include 'function.php';
    //--------------------------------------------------------------------------------------
    $pdo = pdo_connect_mysql();
    //--------------------------------------------------------------------------------------
    $msg = '';
    //--------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------
    // Vérifier que l'ID de event existe
    if (isset($_GET['id'])) {
        //--------------------------------------------------------------------------------------
        // Sélectionnez l'enregistrement qui va être supprimé
        $stmt = $pdo->prepare('SELECT * FROM events WHERE id = ?');
        $stmt->execute([$_GET['id']]);
        //--------------------------------------------------------------------------------------
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        /*$stmt->fetch(PDO::FETCH_ASSOC): Cette ligne exécute la méthode fetch() sur l'objet de requête préparée $stmt. 
        La méthode fetch() récupère la prochaine ligne de résultat du jeu de résultats associé à la requête. 
        L'argument PDO::FETCH_ASSOC spécifie le mode de récupération des données, dans ce cas,
        sous forme de tableau associatif où les noms de colonnes sont utilisés comme clés*/
        //--------------------------------------------------------------------------------------
        if (!$event) {
            exit('Event doesn\'t exist with that ID!');
        }
        //--------------------------------------------------------------------------------------
        // Assurez-vous que l'utilisateur confirme avant la suppression
        if (isset($_GET['confirm'])) {
            if ($_GET['confirm'] == 'yes') {
                //--------------------------------------------------------------------------------------
                // L'utilisateur a cliqué sur le bouton "Oui", supprimer l'enregistrement
                $stmt = $pdo->prepare('DELETE FROM events WHERE id = ?');
                //--------------------------------------------------------------------------------------
                $stmt->execute([$_GET['id']]);
                //--------------------------------------------------------------------------------------
                $msg = 'You have deleted the event!';
            }else{
                // L'utilisateur a cliqué sur le bouton "Non", le redirige vers la page de lecture
                //--------------------------------------------------------------------------------------
                header('Location: read2.php');
                exit;
                //--------------------------------------------------------------------------------------
            }
        }
        //--------------------------------------------------------------------------------------
    }else{
        exit('No ID specified!');
    }
?>
<!--------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------->
    <?=template_header('Delete')?>
    <!--------------------------------------------------------------------------------------->
    <div class="event delete">
        <h2>Delete event #<?=$event['id']?></h2>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php else: ?>
            <p>Are you sure you want to delete event #<?=$event['id']?>?</p>
        <div class="yesno">
            <a href="delete2.php?id=<?=$event['id']?>&confirm=yes">Yes</a>
            <a href="delete2.php?id=<?=$event['id']?>&confirm=no">No</a>
        </div>
        <!--------------------------------------------------------------------------------------->
        <?php endif; ?>
    </div>
    <!--------------------------------------------------------------------------------------->
    <?=template_footer()?>
    <!--------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------->