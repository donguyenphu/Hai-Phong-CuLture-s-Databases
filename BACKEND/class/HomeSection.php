<?php
require_once 'Database.php';
class HomeSection extends Database {
    // protected $table = 'home_section';

    public function __construct($initServer)
    {
        parent::__construct($initServer);
        $this->table = 'home_section';

    }

    public function getItems($params = []) {
        $queryString = "SELECT * FROM `$this->table`";

        // 
    }

    public function updateItem() {
        // bien doi va chuandata
        // chuan bi condition
        // $this->update($data, $contdition);
    }
}
?>