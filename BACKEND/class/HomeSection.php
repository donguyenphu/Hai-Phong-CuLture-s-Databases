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
        $result = [];
        $queryString = "SELECT * FROM `$this->table`";

        $queryWhere = [];

        if (isset($params['search'])) {
            $searchParams = $params['search'];
            if (isset($searchParams['status']) && $searchParams < 2) {
                $value = $searchParams['status'];
                $queryWhere []= "`status` = '$value'";
            }
            if (isset($searchParams['name']) && !empty($searchParams['name'])) {
                $value = $searchParams['name'];
                $queryWhere []= "`name` LIKE '%$value%'";
            }
            if (isset($searchParams['url']) && !empty($searchParams['url'])) {
                $value = $searchParams['url'];
                $queryWhere []= "`url` LIKE '%$value%'";
            }
            if (isset($searchParams['created_at']['start']) && !empty($searchParams['created_at']['start'])) {
                $value = $searchParams['created_at']['start'];
                $queryWhere []= "`created_at` >= '$value'";
            }
            if (isset($searchParams['created_at']['end']) && !empty($searchParams['created_at']['end'])) {
                $value = $searchParams['created_at']['end'];
                $queryWhere []= "`updated_at` <= '$value'";
            }

        }

        if (!empty($queryWhere)) {
            $queryWhere = implode(' AND ', $queryWhere);
            $queryString .= ' WHERE '.$queryWhere;
        }

        $result = $this -> recordQueryResult($queryString);
        return $result;
    }
    public function getItem($id = null) {
        // null does nothing
    }

    public function updateItem($params = []) {
        // bien doi va chuandata
        // chuan bi condition
        // $this->update($data, $contdition);
    }

    public function createItem($params = []) {

    }
    
    public function deleteItem($id = null) {

    }
}
?>