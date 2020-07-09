<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';


require_once BASE_PATH . '/lib/Items/Items.php';
$items = new Items();


$order_by	= filter_input(INPUT_GET, 'order_by');
$order_dir	= filter_input(INPUT_GET, 'order_dir');
$search_str	= filter_input(INPUT_GET, 'search_str');

$pagelimit = 15;

$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

if (!$order_by) {
	$order_by = 'id';
}
if (!$order_dir) {
	$order_dir = 'Desc';
}

$db = getDbInstance();
$select = array('id', 'nazwa', 'historia', 'pomieszczenie', 'wydanie', 'created_at', 'updated_at');


if ($search_str) {
	$db->where('nazwa', '%' . $search_str . '%', 'like');
	$db->orwhere('historia', '%' . $search_str . '%', 'like');
}
if ($order_dir) {
	$db->orderBy($order_by, $order_dir);
}


$db->pageLimit = $pagelimit;


$rows = $db->arraybuilder()->paginate('items', $page, $select);
$total_pages = $db->totalPages;
?>
<?php include BASE_PATH . '/includes/header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Sprzęt</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <a href="add_item.php?operation=create" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Dodaj nowe</a>
            </div>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php'; ?>

    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Szukaj</label>
            <input type="text" class="form-control" id="input_search" name="search_str" value="<?php echo htmlspecialchars($search_str, ENT_QUOTES, 'UTF-8'); ?>">
            <label for="input_order">Kolejność</label>
            <select name="order_by" class="form-control">
                <?php
foreach ($items->setOrderingValues() as $opt_value => $opt_name):
	($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
	echo ' <option value="' . $opt_value . '" ' . $selected . '>' . $opt_name . '</option>';
endforeach;
?>
            </select>
            <select name="order_dir" class="form-control" id="input_order">
                <option value="Asc" <?php
if ($order_dir == 'Asc') {
	echo 'selected';
}
?> >Asc</option>
                <option value="Desc" <?php
if ($order_dir == 'Desc') {
	echo 'selected';
}
?>>Desc</option>
            </select>
            <input type="submit" value="Wykonaj" class="btn btn-primary">
        </form>
    </div>
    <hr>

    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="50%">Historia sprzętu</th>
                <th width="11%">Nazwa</th>
                <th width="11%">Data wydania</th>
                <th width="10%">Pomieszczenie</th>
		<th width="13%">Zarządzanie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
				<td><?php echo htmlspecialchars($row['historia']); ?></td>
				<td><?php echo htmlspecialchars($row['nazwa']); ?></td>
                <td><?php echo htmlspecialchars($row['wydanie']); ?></td>
				<td><?php echo htmlspecialchars($row['pomieszczenie']); ?></td>
		
                <td>
                    <a href="edit_item.php?item_id=<?php echo $row['id']; ?>&operation=edit" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id']; ?>"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
            <div class="modal fade" id="confirm-delete-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_item.php" method="POST">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Potwierdź</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['id']; ?>">
                                <p>Czy jesteś pewien, że chcesz to usunąć?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default pull-left">Tak</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Nie</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-center">
    	<?php echo paginationLinks($page, $total_pages, 'items.php'); ?>
    </div>
</div>
<?php include BASE_PATH . '/includes/footer.php'; ?>
