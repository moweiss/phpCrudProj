<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $requestedBy = isset($_POST['requestor_id']) ? $_POST['requestor_id'] : '';
        $toolName = isset($_POST['tool_name']) ? $_POST['tool_name'] : '';
        $type = isset($_POST['type']) ? $_POST['type'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $priority = isset($_POST['priority']) ? $_POST['priority'] : '';
        $tester = isset($_POST['tester']) ? $_POST['tester'] : '';
        $dateFilled = isset($_POST['date_filed']) ? $_POST['date_filed'] : date('Y-m-d H:i:s');
        $dateClosed = isset($_POST['date_closed']) ? $_POST['date_closed'] : date('Y-m-d H:i:s');
        $fixConfirmed = isset($_POST['fix_confirm']) ? $_POST['fix_confirm'] : '';
        $imageName = isset($_POST['image_name']) ? $_POST['image_name'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE back_log SET id = ?, requestor_id = ?, tool_name = ?, type = ?, description = ?, priority = ?, tester = ?, date_filed = ?, date_closed = ?, fix_confirm = ?, image_name = ?, status = ? WHERE id = ?');
        $stmt->execute([$id, $requestedBy, $toolName, $type, $description, $priority, $tester, $dateFilled, $dateClosed, $fixConfirmed, $imageName, $status, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM back_log WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $back_log = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$back_log) {
        exit('Backlog entry doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
    <h2>Update Backlog Entry #<?=$back_log['id']?></h2>
    <form action="update.php?id=<?=$back_log['id']?>" method="post">
        <label for="id">ID</label>
        <label for="requestedBy">Requested By</label>
        <input type="text" name="id" id="id">
        <input type="text" name="requestedBy" placeholder="John Doe" id="requestedBy">

        <label for="toolName">Tool Name</label>
        <label for="type">Type</label>
        <input type="text" name="toolName"  id="toolName">
        <input type="text" name="type"  id="type">

        <label for="description">Description</label>
        <label for="priority">Priority</label>
        <input type="text" name="description" id="description">
        <input type="text" name="priority" id="priority">

        <label for="tester">Tester</label>
        <label for="dateFilled">Date Filled</label>
        <input type="text" name="tester" id="tester">
        <input type="datetime-local" name="dateFilled" value="<?=date('Y-m-d\TH:i')?>" id="dateFilled">

        <label for="dateClosed">Date Closed</label>
        <label for="fixConfirmed">Fix Confirmed</label>
        <input type="datetime-local" name="dateClosed" value="<?=date('Y-m-d\TH:i')?>" id="dateClosed">
        <input type="text" name="fixConfirmed" id="fixConfirmed">

        <label for="imageName">Image Name</label>
        <label for="status">Status</label>
        <input type="text" name="imageName" id="imageName">
        <input type="text" name="status" id="status">

        <input type="submit" value="Submit">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>