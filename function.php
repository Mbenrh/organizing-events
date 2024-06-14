<?php
//--------------------------------------------------------------------------------------
function pdo_connect_mysql(){
    $DATABASE_HOST='localhost';
    $DATABASE_USER='root';
    $DATABASE_PASS='';
    $DATABASE_NAME='phpcrud';
    try{
        return new PDO('mysql:host='.$DATABASE_HOST .';dbname='.$DATABASE_NAME.';charset=utf8',$DATABASE_USER,$DATABASE_PASS);
    }
    catch(PDOException $exception){
        exit('Échec de la connexion à la base de données!');
    }
}
//--------------------------------------------------------------------------------------
function template_header($title){
    echo <<<EOT
    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8">
    <title>$title</title>
    <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <nav class="navtop">
        <div>
            <h1>Musiclya</h1>
            <a href="index.php"><i class="fas fa-home"></i>Home</a>
            <a href="read.php"><i class="fas fa-address-book"></i>contact</a>
            <a href="read2.php"><i class="fas fa-address-book"></i>event</a>
        </div>
    </nav>
    EOT;
}
//--------------------------------------------------------------------------------------
function template_footer() {
    echo <<<EOT
    </body>
    </html>
    EOT;
}
?>