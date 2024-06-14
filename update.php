<?php
    include 'function.php';
    //--------------------------------------------------------------------------------------
    $pdo = pdo_connect_mysql();
    //--------------------------------------------------------------------------------------
    $msg = '';
    //--------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------
    // Vérifier que l'ID de contact existe
    if (isset($_GET['id'])) {
        //--------------------------------------------------------------------------------------
        if (!empty($_POST)) {
            // Cette partie est similaire à create.php, mais à la place, nous mettons à jour un enregistrement et n'insérons pas
            $id = isset($_POST['id']) ? $_POST['id'] : NULL;
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
            // Mise à jour de l'enregistrement dans la base de données
            $stmt = $pdo->prepare('UPDATE contacts SET name = ?, email = ?, phone = ?, title = ?, created = ? WHERE id = ?');
            $stmt->execute([$name, $email, $phone, $title, $created, $_GET['id']]);
            // Attribution d'un message de confirmation
            $msg = 'Mise à jour réussie !';
        }
        //--------------------------------------------------------------------------------------
        // Récupération des informations du contact à partir de la base de données
        $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
        $stmt->execute([$_GET['id']]);
        $contact = $stmt->fetch(PDO::FETCH_ASSOC);
        //--------------------------------------------------------------------------------------
        if (!$contact) {
            exit('Contact doesn\'t exist with that ID!');
        }
    //--------------------------------------------------------------------------------------
    } else {
        exit('No ID specified!');
    }
?>

<?=template_header('Read')?>
    <div class="content update">
        <h2>Update Contact #<?=$contact['id']?></h2>
        <form action="update.php?id=<?=$contact['id']?>" method="post">
            <label for="id">ID</label>
            <label for="name">Name</label>
            <input type="text" name="id" placeholder="1" value="<?=$contact['id']?>" id="id">
            <input type="text" name="name" placeholder="John Doe" value="<?=$contact['name']?>" id="name">
            <label for="email">Email</label>
            <label for="phone">Phone</label>
            <input type="text" name="email" placeholder="johndoe@example.com" value="<?=$contact['email']?>" id="email">
            <input type="text" name="phone" placeholder="2025550143" value="<?=$contact['phone']?>" id="phone">
            <label for="title">Title</label>
            <label for="created">Created</label>
            <input type="text" name="title" placeholder="Employee"value="<?=$contact['title']?>" id="title">
            <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i', strtotime($contact['created']))?>" id="created">
            <input type="submit" value="Update">
        </form>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php endif; ?>
    </div>
<?=template_footer()?>
