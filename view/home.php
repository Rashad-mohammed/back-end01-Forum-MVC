<h1>BIENVENUE SUR LE FORUM</h1>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit ut nemo quia voluptas numquam, itaque ipsa soluta ratione eum temporibus aliquid, facere rerum in laborum debitis labore aliquam ullam cumque.</p>
<?php
use App\Session;
    $topics = $result["data"]['topics'];
    $categories = $result["data"]['categories'];
    
?>
<!-- ------------------------AFFICHER   LES   CATEGORIES   DE TOPICS--------------------------------- -->
<h2>Liste des catégories de topics :</h2>

<section class="liste-categoris">
    <?php
        foreach ($categories as $category) {
            echo '<div class="categoris">';
            echo '<a href="index.php?ctrl=Forum&action=detailCategory&id=' . $category->getId() . '">' . $category->getNameCategory() . '</a><br>';
            echo '</div>';
        }
    ?>
</section>

<p>Veillez cliquez sur la category pour voir ses topics  et ajouter topic</p>

<hr>
<!-- ////////////////////////////////////////////////////////////////////////////
////////////////////////        AFFICHER   LES   TOPICS    ////////////////// -->
<h2>Les listes de topics</h2>
<section class="liste-topics">
    <?php
    
    if (isset($topics)) {
        foreach ($topics as $topic) {

            // var_dump($topic);
            ?>
            <div>
                <a href="index.php?ctrl=Forum&action=detailTopicById&id=<?= $topic->getId() ?>">
                    <h3><?= $topic->getTitle() ?></h3>
                </a>
                <p><?= $topic->getContent() ?></p>
                <p><?= $topic->getCreationdate() ?></p>
                
                <a href="index.php?ctrl=Forum&action=detailsTopicByUser&id=<?= $topic->getUser()->getId() ?>">
                    <p>Ecrit par : <?= $topic->getUser()->getPseudo() ?></p>
                </a>
               
                <br>
                <?php
                    //lien pour supprimer le topic
                    if (App\Session::isAdmin() ||  (App\Session::getUser() && App\Session::getUser()->getId() === $topic->getUser()->getId())) {
                        echo '<a href="index.php?ctrl=forum&action=deleteTopic&id=' . $topic->getId() . '">';
                        echo 'Delete topic</a><br><br>';
                    }
                    //le lien pour fermer le topic
                    if (App\Session::isAdmin() || (App\Session::getUser() && App\Session::getUser()->getId() === $topic->getUser()->getId())) {
                        
                        if($topic->getLockTopic()){?>
                            <a href='index.php?ctrl=forum&action=lockTopic&id=<?= $topic->getId()?>'>
                                <i class='fa-solid fa-lock'></i>
                            </a>
                            <?php
                        }
                        else{
                            echo "<a href='index.php?ctrl=forum&action=lockTopic&id=" . $topic->getId() . "'>";
                            echo "<i class='fa-solid fa-lock-open'></i>";
                            echo "</a>";
                        }
                    }
                            // Vérifie si l'utilisateur actuel est un administrateur OU s'il est un utilisateur ET que le topic est ouvert
                        if ((App\Session::isAdmin() || App\Session::getUser()) && !$topic->getLockTopic()) {
                            // Affiche le formulaire pour ajouter un message
                            echo"<section class='addComment'>";
                            echo "<form action='index.php?ctrl=forum&action=addMessage&id=" . $topic->getId() . "' method='post' enctype='multipart/form-data'>";
                            echo"<textarea name='text' id='text' cols='100' rows='10' placeholder='You can write a message here  ...'>";
                            echo"</textarea>";
                            echo"<input type='hidden' name='token' value='<?=session::Token()?>'>";
                            echo"<input type='submit' value='Add message'>";
                            echo"</form>";
                            echo"</section>";
                        }
        
                ?>
                <p>-------------------------------</p>
                <p>Veillez cliquez sur pseudo de user pour voir ses topics   <br>  Et sur title de topic pour voir  les details</p>
            </div>
    
            <?php
        }
    } else {
        echo '<h3>Il n\'y a aucun topic pour cette section.</h3>';
    }
   
    
    ?>

</section>
<hr>
<!-- ----------------------------------------------------------------------------------------- -->
<style>
.addComment textarea{
    width: 400px;
    height: 40px;
}
</style>