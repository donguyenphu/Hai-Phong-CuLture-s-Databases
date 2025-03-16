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

    protected $jsonIDSfilePath;

    public function __construct($initServer)
    {
        parent::__construct($initServer);
        $this->table = 'home_section';
        $this->jsonIDSfilePath = '../../assets/json/home-section-ids.json';
    }
    public function prepareJsonArray()
    {
        $jsonContent = file_get_contents($this->jsonIDSfilePath);
        $jsonArray = json_decode($jsonContent, true);
        return $jsonArray;
    }
    public function convertBackJsonArray($array)
    {
        $jsonConvertBackContent = json_encode($array, JSON_PRETTY_PRINT);
        if (file_put_contents($this->jsonIDSfilePath, $jsonConvertBackContent)) {
            return true;
        }
        return false;
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

    public function updateItem($params = [], $id)
    {
        // bien doi va chuandata
        // chuan bi condition
        // $this->update($data, $contdition);
        $rule = RULE_HOME_SECTION;
        unset($rule['image']);
        $fieldsModified = $this->prepareParams($params);
        $Validate = new Validate($params);
        $Validate->addAllRules($rule);
        $Validate->run();
        $resultEnd = $Validate->returnResults();
        $errorEnd = $Validate->returnErrors();

        if (!count($errorEnd)) {
            $params['id'] = $id;
            $params['updated_at'] = date("Y-m-d H:i:s");
            $this->updateOnlyOneId($params);
            return true;
        }
        return $errorEnd;
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
        $fieldsAdded['created_at'] = date("Y-m-d H:i:s");

        if (!empty($fieldsAdded)) {
            $validateObj = new Validate($fieldsAdded);
            $rule = RULE_HOME_SECTION;
            unset($rule['order']);
            unset($rule['image']);
            $validateObj->addAllRules($rule);
            $validateObj->run();
            $result = $validateObj->returnResults();
            $errors = $validateObj->returnErrors();
            if (empty($errors)) {
                $lastId = $this->insert($fieldsAdded, 'single');
                return [
                    'status' => true,
                    'lastID' => $lastId
                ];
            }
        }
        return [
            'status' => false,
            'errors' => $validateObj->showErrors()
        ];
    }

    public function deleteItem($id = null) {}

    public function search() {}

    private function prepareParams($params = [])
    {
        $fieldsAdded = array_intersect_key($params, array_flip($this->fields));
        $fieldsAdded['status'] = (isset($params['status']) && $params['status'] == "on") ? 1 : 0;
        $temporaryVar = '';
        if (isset($fieldsAdded['image']['name']) && !empty($fieldsAdded['image']['name'])) {
            $temporaryVar = $fieldsAdded['image']['name'];
        }
        unset($fieldsAdded['image']);
        if ($temporaryVar) {
            $fieldsAdded['image'] = $temporaryVar;
        }
        $fieldsAdded = array_map(function ($value) {
            return is_array($value) ? $value : trim((string)$value);
        }, $fieldsAdded);
        return $fieldsAdded;
    }
}
