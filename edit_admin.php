<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

require_once BASE_PATH . '/lib/Users/Users.php';
$users = new Users();

$admin_user_id = filter_input(INPUT_GET, 'admin_user_id');
$operation = filter_input(INPUT_GET, 'operation', FILTER_SANITIZE_STRING);
($operation == 'edit') ? $edit = true : $edit = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$data_to_db = filter_input_array(INPUT_POST);

	$db = getDbInstance();
	$db->where('user_name', $data_to_db['user_name']);
	$db->where('id', $admin_user_id, '!=');
	$row = $db->getOne('admin_accounts');

	if (!empty($row['user_name']))
	{
		$_SESSION['failure'] = 'Użytkownik już istnieje';
		$query_string = http_build_query(array(
			'admin_user_id' => $admin_user_id,
			'operation' => $operation,
		));
		header('location: edit_admin.php?'.$query_string );
		exit;
	}

	$admin_user_id = filter_input(INPUT_GET, 'admin_user_id', FILTER_VALIDATE_INT);
	$data_to_db['password'] = password_hash($data_to_db['password'], PASSWORD_DEFAULT);
	$db = getDbInstance();
	$db->where('id', $admin_user_id);
	$stat = $db->update('admin_accounts', $data_to_db);

	if ($stat)
	{
		$_SESSION['success'] = 'Administor został zaktualizowany';
	} else {
		$_SESSION['failure'] = 'Błąd podczas aktualizowania Administratora: ' . $db->getLastError();
	}

	header('location: admin_users.php');
	exit;
}

$db = getDbInstance();
$db->where('id', $admin_user_id);

$admin_account = $db->getOne("admin_accounts");

?>
<?php include BASE_PATH . '/includes/header.php'; ?>
<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="page-header"><?php echo (!$edit) ? 'Dodaj' : 'Edytuj'; ?> Użytkownika</h2>
		</div>
	</div>
	<?php include BASE_PATH . '/includes/flash_messages.php'; ?>
	<form class="well form-horizontal" action="" method="post" id="contact_form" enctype="multipart/form-data">
		<?php include BASE_PATH . '/forms/admin_users_form.php'; ?>
	</form>
</div>
<?php include BASE_PATH . '/includes/footer.php'; ?>
