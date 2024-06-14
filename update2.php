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
        if (!empty($_POST)) {
            // Cette partie est similaire à create.php, mais à la place, nous mettons à jour un enregistrement et n'insérons pas
            $id = isset($_POST['id']) ? $_POST['id'] : NULL;
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
            $date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d H:i:s');
            $venue = isset($_POST['venue']) ? $_POST['venue'] : '';
            // Mise à jour de l'enregistrement dans la base de données
            $stmt = $pdo->prepare('UPDATE events SET name = ?,genre = ?, date = ?, venue = ? WHERE id = ?');
            $stmt->execute([$name, $genre, $date, $venue, $_GET['id']]);
            // Attribution d'un message de confirmation
            $msg = 'Mise à jour réussie !';
        }
        //--------------------------------------------------------------------------------------
        // Récupération des informations du event à partir de la base de données
        $stmt = $pdo->prepare('SELECT * FROM events WHERE id = ?');
        $stmt->execute([$_GET['id']]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        //--------------------------------------------------------------------------------------
        if (!$event) {
            exit('event doesn\'t exist with that ID!');
        }
    //--------------------------------------------------------------------------------------
    } else {
        exit('No ID specified!');
    }
?>
<?=template_header('Read2')?>
    <div class="event update">
        <h2>Update event #<?=$event['id']?></h2>
        <form action="update.php?id=<?=$event['id']?>" method="post">
            <label for="id">ID</label>
            <label for="name">Name</label>
            <input type="text" name="id" placeholder="1" value="<?=$event['id']?>" id="id">
            <input type="text" name="name" placeholder="John Doe" value="<?=$event['name']?>" id="name">
            <label for="genre">genre</label>
            <label for="date">date</label>
            <input type="text" name="genre" placeholder="..." value="<?=$event['genre']?>" id="genre">
            <input type="date" name="date" placeholder=".." value="<?=$event['date']?>" id="date">
            <label for="venue">venue</label>
            <input type="text" name="venue" placeholder=".."value="<?=$event['venue']?>" id="venue">
            <input type="submit" value="Update">
        </form>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php endif; ?>
    </div>
<?=template_footer()?>
