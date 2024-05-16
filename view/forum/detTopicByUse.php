<?php
$topics = $result["data"]['topics'];
$user = $result["data"]['user'];
?>
<h2><?= $user->getPseudo() ?> a écrit ces topics :</h2>
<section class="liste-topics">
    <?php foreach ($topics as $topic) : ?>
        <div>
            <h3><?= $topic->getTitle() ?></h3>
            <p><?= $topic->getContent() ?></p>
            <p><?= $topic->getCreationdate() ?></p>
            <p>-------------------------------</p>
        </div>
    <?php endforeach; ?>

</section>
