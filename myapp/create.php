<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
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
    
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO back_log VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $requestedBy, $toolName, $type, $description, $priority, $tester, $dateFilled, $dateClosed, $fixConfirmed, $imageName, $status]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?=template_header('Create')?>

<div class="content update">
    <h2>Create Backlog Entry</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="requestedBy">Requested By</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
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

        <input type="submit" value="Submit" href="index.php">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>