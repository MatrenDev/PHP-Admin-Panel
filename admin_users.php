<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';


require_once BASE_PATH . '/lib/Users/Users.php';
$users = new Users();


$del_id		= filter_input(INPUT_GET, 'del_id');
$order_by	= filter_input(INPUT_GET, 'order_by');
$order_dir	= filter_input(INPUT_GET, 'order_dir');
$search_str	= filter_input(INPUT_GET, 'search_str');


$pagelimit = 15;


$page = filter_input(INPUT_GET, 'page');
if (!$page) 
{
	$page = 1;
}


if (!$order_by) 
{
	$order_by = 'id';
}
if (!$order_dir) 
{
	$order_dir = 'Desc';
}

$db = getDbInstance();
$select = array('id', 'user_name', 'admin_type');


if ($search_str) 
{
	$db->where('user_name', '%' . $search_str . '%', 'like');
}

if ($order_dir) 
{
	$db->orderBy($order_by, $order_dir);
}

$db->pageLimit = $pagelimit;


$rows = $db->arraybuilder()->paginate('admin_accounts', $page, $select);
$total_pages = $db->totalPages;
?>

<?php include BASE_PATH . '/includes/header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Administratorzy</h1>
    

            <div class="page-action-links text-right">
                <a href="add_admin.php" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Dodaj</a>
            </div>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php'; ?>

    <?php
    if (isset($del_stat) && $del_stat == 1)
    {
        echo '<div class="alert alert-info">Pomyślnie usunięto</div>';
    }
    ?>
    

    <hr>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="45%">Nazwa użytkownika</th>
                <th width="40%">Typ konta</th>
                <th width="10%">Zarządzanie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                <td><?php echo htmlspecialchars($row['admin_type']); ?></td>
                <td>
                    <a href="edit_admin.php?admin_user_id=<?php echo $row['id']; ?>&operation=edit" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id']; ?>"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
            <div class="modal fade" id="confirm-delete-<?php echo $row['id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_user.php" method="POST">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Usuń</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['id']; ?>">
                                <p>Czy na pewno chcesz to usunąć?</p>
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
    	<?php echo paginationLinks($page, $total_pages, 'admin_users.php'); ?>
    </div>
</div>
<?php include BASE_PATH . '/includes/footer.php'; ?>
