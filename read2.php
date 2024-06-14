<?php
include 'function.php';
//--------------------------------------------------------------------------------------
$pdo = pdo_connect_mysql();
//--------------------------------------------------------------------------------------
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
/*
1.isset($_GET['page']): Cette fonction vérifie si le paramètre page est présent dans l'URL.
2.&&: C'est l'opérateur logique ET. Il permet de combiner les deux conditions.
3.is_numeric($_GET['page']): Cette fonction vérifie si la valeur du paramètre page est numérique.
4.?: C'est l'opérateur ternaire qui permet d'effectuer un test conditionnel.
5.(int)$_GET['page']: Si le paramètre page est présent et numérique, 
cette partie convertit sa valeur en un entier.
6.: 1;: Si le paramètre page n'estpas présent ou s'il n'est pas numérique, 
cette partie définit $page à 1 par défaut.*/
//--------------------------------------------------------------------------------------
$records_per_page = 5;
//--------------------------------------------------------------------------------------
$stmt = $pdo->prepare('SELECT * FROM events ORDER BY id LIMIT:current_page, :record_per_page');
$stmt = $pdo->prepare('SELECT * FROM events ORDER BY id LIMIT :offset, :limit');
$stmt->bindValue(':offset', ($page-1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':limit', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
/*
1.$stmt = $pdo->prepare('SELECT * FROM events ORDER BY id LIMIT :offset, :limit');: Cette ligne prépare une requête SQL pour sélectionner tous les enregistrements de 
la table events, en les ordonnant par l'identifiant (id), puis en limitant les résultats pour n'afficher qu'une partie des enregistrements. Les valeurs de :offset et :limit seront fournies plus tard.
2.$stmt->bindValue(':offset', ($page-1) * $records_per_page, PDO::PARAM_INT);: Cette ligne lie la valeur de l'offset (:offset) dans la requête préparée. 
L'offset est calculé en fonction de la page actuelle et du nombre de résultats par page. PDO::PARAM_INT indique que la valeur liée est un entier.
3.$stmt->bindValue(':limit', $records_per_page, PDO::PARAM_INT);: Cette ligne lie la valeur de la limite (:limit) dans la requête préparée au nombre de résultats par page. 
Cela indique combien de résultats doivent être récupérés à partir de l'emplacement de départ spécifié par l'offset. PDO::PARAM_INT indique que la valeur liée est un entier.
4.$stmt->execute();: Cette ligne exécute la requête préparée avec les valeurs liées. Cela récupère les résultats de la base de données en fonction de l'offset et de la limite spécifiés,
fournissant ainsi une pagination pour la liste de résultats.
*/
//--------------------------------------------------------------------------------------
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Obtenez le nombre total de events, afin que nous puissions déterminer s'il devrait y avoir un bouton suivant et précédent
$num_events = $pdo->query('SELECT COUNT(*) FROM events')->fetchColumn();
?>
<!--------------------------------------------------------------------------------------->
<?=template_header('Read2')?>
<!--------------------------------------------------------------------------------------->
<div class="event read">
    <h2>les evenements</h2>
    <a href="create2.php" class="create-event">Create event</a>
    <!--------------------------------------------------------------------------------------->
    <table>
        <thead>
            <tr>
                <td>#</td>
                <td>Name</td>
                <td>Genre</td>
                <td>Date</td>
                <td>Venue</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <!--------------------------------------------------------------------------------------->
            <?php foreach ($events as $event): ?>
            <!--------------------------------------------------------------------------------------->
            <tr>
                <td><?=$event['id']?></td>
                <td><?=$event['name']?></td>
                <td><?=$event['genre']?></td>
                <td><?=$event['date']?></td>
                <td><?=$event['venue']?></td>
                <td class="actions">
                    <a href="update2.php?id=<?=$event['id']?>"class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete2.php?id=<?=$event['id']?>"class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <!--------------------------------------------------------------------------------------->
            <?php endforeach; ?>
            <!--------------------------------------------------------------------------------------->
        </tbody>
    </table>
    <!--------------------------------------------------------------------------------------->
    <div class="pagination">
        <?php if ($page > 1): ?>
                    <a href="read2.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"><</i></a>
        <?php endif; ?>
        <?php if ($page*$records_per_page < $num_events): ?>
                    <a href="read2.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm">></i></a>
        <?php endif; ?>
    </div>
</div>
<!--------------------------------------------------------------------------------------->
<?=template_footer()?>