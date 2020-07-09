<?php
class Items
{

    public function __construct()
    {
    }


    public function __destruct()
    {
    }
    

    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'ID',
            'nazwa' => 'Nazwa',
            'historia' => 'Historia',
            'pomieszczenie' => 'pomieszczenie',
            'wydanie' => 'Wydanie',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at'
        ];

        return $ordering;
    }
}
?>
