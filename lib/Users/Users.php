<?php
class Users
{

    public function __construct()
    {
        if ($_SESSION['admin_type'] !== 'super')
        {
            header('HTTP/1.1 401 Unauthorized', true, 401);
            exit('401 Unauthorized');
        }
    }


    public function __destruct()
    {
    }
    

    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'ID',
            'user_name' => 'Username',
            'admin_type' => 'Admin Type'
        ];

        return $ordering;
    }
}
?>
