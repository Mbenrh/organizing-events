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
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-dH:i:s');
        //--------------------------------------------------------------------------------------
        // Insérer un nouvel enregistrement dans la table des contacts
        $stmt = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$id, $name, $email, $phone, $title, $created]);
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
        <div class="content update">
            <h2>Create Contact</h2>
            <form action="create.php" method="post">
                <label for="id">ID</label>
                <label for="name">Name</label>
                <input type="text" name="id" placeholder="26" value="auto" id="id">
                <input type="text" name="name" placeholder="Name" id="name">
                <label for="email">Email</label>
                <label for="phone">Phone</label>
                <input type="text" name="email" placeholder="Email" id="email">
                <input type="text" name="phone" placeholder="Phone" id="phone">
                <label for="title">Title</label>
                <label for="created">Created</label>
                <input type="text" name="title" placeholder="Title" id="title">
                <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" id="created">
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