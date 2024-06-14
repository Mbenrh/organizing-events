<?php
    include 'function.php';
    $pdo = pdo_connect_mysql();
    //--------------------------------------------------------------------------------------
    $msg = '';
    //--------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------
    // Vérifiez si les données POST ne sont pas vides
    if (!empty($_POST)) {
        //--------------------------------------------------------------------------------------
        // Configurez les variables qui vont être insérées, nous devons vérifier si les variables POST existent sinon nous pouvons les vider par défaut
        $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] !='auto' ? $_POST['id'] : NULL;
        /*
        1.isset($_POST['id'])
        2.!empty($_POST['id'])
        3.$_POST['id'] !='auto' ? $_POST['id'] : NULL
        */
        //--------------------------------------------------------------------------------------
        // Vérifiez si la variable POST "nom" existe, sinon la valeur par défautest vide, fondamentalement la même pour toutes les variables
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
        $date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-dH:i:s');
        $venue = isset($_POST['venue']) ? $_POST['venue'] : '';
        //--------------------------------------------------------------------------------------
        // Insérer un nouvel enregistrement dans la table des events
        $stmt = $pdo->prepare('INSERT INTO events VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$id, $name, $genre, $date, $venue]);
        //--------------------------------------------------------------------------------------
        // Message de sortie
        $msg = 'Created Successfully!';
        //--------------------------------------------------------------------------------------
    }
?>
<!--------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------->
    <?=template_header('Create')?>
    <!--------------------------------------------------------------------------------------->
        <div class="event update">
            <h2>Create event</h2>
            <form action="create2.php" method="post">
                <label for="id">ID</label>
                <label for="name">Name</label>
                <input type="text" name="id" placeholder="26" value="auto" id="id">
                <input type="text" name="name" placeholder="Name" id="name">
                <label for="genre">genre</label>
                <label for="date">date</label>
                <input type="text" name="genre" placeholder="genre" id="genre">
                <input type="date" name="date" placeholder="date" id="date">
                <label for="venue">venue</label>
                <input type="text" name="venue" placeholder="venue" id="venue">
                <input type="submit" value="Create">
            </form>
            <?php if ($msg): ?>
                <p><?=$msg?></p>
            <?php endif; ?>
        </div>
        <!--------------------------------------------------------------------------------------->
    <?=template_footer()?>
    <!--------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------->