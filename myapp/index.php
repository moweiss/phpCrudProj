<?php
include 'functions.php';

// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 10;

// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM back_log ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$back_log = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_back_log = $pdo->query('SELECT COUNT(*) FROM back_log')->fetchColumn();
?>



<?=template_header('Read')?>

<div class="content read">
	<h2>Backlog Tracker</h2>
	<input type="text" id="search" placeholder="Search"> <div class="select">
       <select name="search_categories" id="search_categories">
          <option value="10" selected="selected">Show 10 entries</option>
          <option value="25">Show 25 entries</option>
          <option value="50">Show 50 entries</option>
          <option value="100">Show 100 entries</option>
       </select>
     </div>
     <?php 
		$records_per_page = $_POST['search_categories']; // this $value variable contains the value of selected value.
	 ?>
	<a href="create.php" class="button">Add New</a>
     
	<table>
        <thead>
            <tr>
            	<td>Action</td>
                <td>ID</td>
                <td>Requested By</td>
                <td>Tool Name</td>
                <td>Type</td>
                <td>Description</td>
                <td>Priority</td>
                <td>Tester</td>
                <td>Date Filled</td>
                <td>Date Closed</td>
                <td>Fix Confirmed</td>
                <td>Image Name</td>
                <td>Status</td>              
            </tr>
        </thead>
        <tbody>
            <?php foreach ($back_log as $backlog): ?>
            <tr>
				<td class="actions">
                    <a href="update.php?id=<?=$backlog['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$backlog['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>                
                <td><?=$backlog['id']?></td>
                <td><?=$backlog['requestor_id']?></td>
                <td><?=$backlog['tool_name']?></td>
                <td><?=$backlog['type']?></td>
                <td><?=$backlog['description']?></td>
                <td><?=$backlog['priority']?></td>
                <td><?=$backlog['tester']?></td>
                <td><?=$backlog['date_filed']?></td>
                <td><?=$backlog['date_closed']?></td>
                <td><?=$backlog['fix_confirm']?></td>
                <td><?=$backlog['image_name']?></td>
                <td><?=$backlog['status']?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="index.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_back_log): ?>
		<a href="index.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>