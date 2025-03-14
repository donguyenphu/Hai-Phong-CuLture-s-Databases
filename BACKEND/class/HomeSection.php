<?php
require_once 'Database.php';
require_once 'Validate.php';
require_once '../../define/homeValidate.php';

class HomeSection extends Database
{

    protected $table;

    protected $fields = [
        'name',
        'image',
        'url',
        'status',
        'order',
        'created_at',
        'updated_at'
    ];

    public function __construct($initServer)
    {
        parent::__construct($initServer);
        $this->table = 'home_section';
    }
    public function totalItems($query = null) 
    {
        $query = "SELECT COUNT(`id`) AS totalItems FROM `$this->table`";
        parent::recordQueryResult($query); // override
    }
    public function totalItemsArray() 
    {
        $query = "SELECT * FROM `$this->table`";
        return parent::recordQueryResult($query); // override
    }
    public function getItems($params = [])
    {
        $result = [];
        $queryString = "SELECT * FROM `$this->table`";

        $queryWhere = [];

        if (isset($params['search'])) {
            $searchParams = $params['search'];
            if (isset($searchParams['status']) && $searchParams < 2) {
                $value = $searchParams['status'];
                $queryWhere[] = "`status` = '$value'";
            }
            if (isset($searchParams['name']) && !empty($searchParams['name'])) {
                $value = $searchParams['name'];
                $queryWhere[] = "`name` LIKE '%$value%'";
            }
            if (isset($searchParams['url']) && !empty($searchParams['url'])) {
                $value = $searchParams['url'];
                $queryWhere[] = "`url` LIKE '%$value%'";
            }
            if (isset($searchParams['created_at']['start']) && !empty($searchParams['created_at']['start'])) {
                $value = $searchParams['created_at']['start'];
                $queryWhere[] = "`created_at` >= '$value'";
            }
            if (isset($searchParams['created_at']['end']) && !empty($searchParams['created_at']['end'])) {
                $value = $searchParams['created_at']['end'];
                $queryWhere[] = "`updated_at` <= '$value'";
            }
        }

        if (!empty($queryWhere)) {
            $queryWhere = implode(' AND ', $queryWhere);
            $queryString .= ' WHERE ' . $queryWhere;
        }

        $result = $this->recordQueryResult($queryString);
        return $result;
    }
    public function getItem($id = null)
    {
        // null does nothing
    }

    public function updateItem($params = [])
    {
        // bien doi va chuandata
        // chuan bi condition
        // $this->update($data, $contdition);
    }
    public function createItems($params = [])
    {
        $this->insert($params);
    }

    public function createItem($params = [])
    {
        // AVOID EXCESS ELEMENTS
        // -> FILTER
        $fieldsAdded = $this->prepareParams($params);

        if (!empty($fieldsAdded)) {
            $validateObj = new Validate($fieldsAdded);
            $rule = RULE_HOME_SECTION;
            unset($rule['order']);
            unset($rule['image']);
            $validateObj->addAllRules($rule);
            $lastId = $validateObj->run();
            $result = $validateObj->returnResults();
            $errors = $validateObj->returnErrors();
            if (empty($errors)) {
                $this->insert($fieldsAdded, 'single');
                return [
                    'status' => true,
                    'lastID' => $lastId
                ];
            }
        }
        return [
            'status' => false,
            'errors' => $validateObj -> showErrors()
        ];
    }

    public function deleteItem($id = null) {}

    public function search() {}
    
    private function prepareParams($params = [])
    {
        $fieldsAdded = array_intersect_key($params, array_flip($this->fields));
        $fieldsAdded['status'] = (isset($params['status']) && $params['status'] == "on") ? 1 : 0;
        $fieldsAdded['created_at'] = date("Y-m-d H:i:s");
        $tmp = '';
        if (isset($fieldsAdded['image']['name']) && !empty($fieldsAdded['image']['name'])) {
            $tmp = $fieldsAdded['image']['name'];
        }
        unset($fieldsAdded['image']);
        if ($tmp) {
            $fieldsAdded['image'] = $tmp;
        }
        $fieldsAdded = array_map(function ($value) {
            return is_array($value) ? $value : trim((string)$value);
        }, $fieldsAdded);
        return $fieldsAdded;
    }
}
