<?php
use App\Session;

$categories = $result["data"]["categories"];
$topics = $result["data"]["topics"];
?>
<section class="sec-list-topic-cat">
    <div class="div-list-topic-cat">
        <h1><?= $categories->getNameCategory() ?></h1>

        <?php
        if (isset($topics)) {
            foreach ($topics as $topic) {
        ?>
                <div class="div-list-topicCat">
                    <a href="index.php?ctrl=Forum&action=detailsTopicByUser&id=<?= $topic->getUser()->getId() ?>">
                        <p><?= $topic->getUser()->getPseudo() ?></p>
                    </a>

                    <p><?= $topic->getTitle() ?></p>
                    <p><?= $topic->getContent() ?></p>
                    <p><?= $topic->getCreationdate() ?></p>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <div class="div-form-add">
    <details>
        <summary>
            <a href="#">Ajouter un topic</a>
        </summary>

        <div class="add-topic">
            <?php
            // Vérifier si l'utilisateur est connecté
            if (Session::getUser()) {
                ?>
                <h3>Ajouter un nouveau sujet</h3>
                <form action="index.php?ctrl=Forum&action=addTopic&id=<?= $categories->getId() ?>" method="post">
                    <label for="title">Title:</label>
                    <input type="text" name="title" placeholder="titre du sujet" required><br><br>
                    <label for="content">Content :</label><br>
                    <textarea name="content" id="text" cols="100" rows="10" placeholder="What do you want to write about ..."></textarea> <br>
                    <input type="hidden" name="token" value="<?= Session::Token() ?>">
                    <button type="submit">Ajouter</button>
                </form>
                <?php
            } else {
                // Afficher un message si l'utilisateur n'est pas connecté
                echo '<p>Vous devez être connecté pour ajouter un sujet. <a href="./view/security/login.php">Connectez-vous</a></p>';
            }
            ?>
        </div>
    </details>
</div>

</section>


  

<style>
.add-topic{
    text-align: center;
    align-items: center;
    width: 600px;
}
.add-topic form{
    width: ;
    padding:30px;
    border-radius: 15px;
    text-align: center;
    background: radial-gradient(rgb(139, 195, 245), #1294b8);
    position: relative;
    left: 32%;
}
.add-topic label{}
.add-topic input{
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
}
.add-topic button{
    width: 50%;
    padding: 10px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
    background: #1294b8;
    color: white;
    cursor: pointer;
}
.add-topic textarea{
    width:100%;
    border-radius: 5px;
}
.sec-list-topic-cat{
display: flex;
/* justify-content:space-evenly; */
gap:50px;
}
.div-list-topic-cat{
    flex-direction: column;
    gap:20px
}
.div-list-topicCat{
    width: 400px;
    background-color: #dcdcdc;
    border-radius: 10px;
    padding: 30px;
    margin-bottom:10px;
}
summary a{
    font-size:25px;
    text-decoration: none;
    font-weight: bold;
}
summary a:hover{

}

.div-form-add{
    margin:150px 0 0 250px;
}
</style>


