<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM back_log WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $back_log = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$back_log) {
        exit('Backlog entry doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM back_log WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the backlog entry!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: index.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Delete')?>

<div class="content delete">
    <h2>Delete Backlog Entry #<?=$back_log['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
    <p>Are you sure you want to delete the following backlog entry #<?=$back_log['id']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$back_log['id']?>&confirm=yes">Yes</a>
        <a href="delete.php?id=<?=$back_log['id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>