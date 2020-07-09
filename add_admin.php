<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

require_once BASE_PATH . '/lib/Users/Users.php';
$users = new Users();

$edit = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$data_to_db = filter_input_array(INPUT_POST);

	$db = getDbInstance();
	$db->where('user_name', $data_to_db['user_name']);
	$db->get('admin_accounts');

	if ($db->count >= 1)
	{
		$_SESSION['failure'] = 'Użytkownik już istnieje';
		header('location: add_admin.php');
		exit;
	}

	$data_to_db['password'] = password_hash($data_to_db['password'], PASSWORD_DEFAULT);
	$db = getDbInstance();
	$last_id = $db->insert('admin_accounts', $data_to_db);

	if ($last_id)
	{
		$_SESSION['success'] = 'Użytkownik został dodany!';
		header('location: admin_users.php');
		exit;
	}
}
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
