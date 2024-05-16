<?php
$users = $result["data"]['users'];
?>

<!-- ------------------------AFFICHER   LES   listes   user      pour USER--------------------------------- -->
<div class="liste-des-users">
    <h2>Liste des utilisateurs</h2>
    <?php
     echo '<table>';
     echo '<tr><th>ID user</th><th>Pseudo user</th><th>Email user</th></tr>';
    foreach ($users as $user) {
        // Vérifie si l'utilisateur a le rôle d'utilisateur
        if ($user) {
            echo '<tr><td>' . $user->getId() . '</td><td>' . $user->getPseudo() . '</td><td>' . $user->getEmail() . '</td></tr>';
        }
    }
    echo '</table>';
    ?>
</div>

<style>
    
table {
    text-align:center;
    border-collapse: collapse;
    width: 40%;
    margin-left: 600px;
}

th,
td {
    text-align: center;
    padding: 8px;
}

th{
    background-color:rgb(139, 195, 245);
    
}
tr:nth-child(odd) {
    background-color: #f2f2f2;
}
</style>