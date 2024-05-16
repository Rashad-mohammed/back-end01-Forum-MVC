<?php
$topic = $result["data"]["topic"];
?>

    <a href="index.php?ctrl=Forum&action=detailTopicById&id=<?= $topic->getId() ?>">
        <h3><?= $topic->getTitle() ?></h3>
    </a>
    <P><?= $topic->getContent() ?></P>
    <p><?= $topic->getcreationdate() ?></p>
    <a href="index.php?ctrl=Forum&action=detailsTopicByUser&id=<?= $topic->getUser()->getId() ?>">
        <p>Ecrit par : <?= $topic->getUser()->getPseudo() ?></p>
    </a>


<?php
    if (App\Session::isAdmin()) {
        echo '<a href="index.php?ctrl=forum&action=deleteTopic&id=' . $topic->getId() . '">';
        echo 'Delete topic</a>';
    }
?>