<?php
require_once 'Database.php';
require_once 'Validate.php';
require_once '../../define/homeValidate.php';
require_once '../../elements/functions.php';

class HomeSection extends Database
{

    protected $table;
    public $imageFolderName;
    public $totalItemsPerPage;
    public $pageRange;
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
        $this->totalItemsPerPage = 4;
        $this->pageRange = 4;
        $this->imageFolderName = 'home-section';
    }
    public function totalItems($query = null)
    {
        $query = "SELECT COUNT(`id`) AS totalItems FROM `$this->table`";
        return parent::recordSingleRowResult($query)['totalItems'];
    }
    public function createFilterQuery($queryString, $params = [])
    {
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
        return $queryString;
    }
    public function totalItem($params = [])
    {
        $queryString = "SELECT COUNT('id') AS totalItem FROM `$this->table`";

        $queryString = $this->createFilterQuery($queryString, $params);

        return parent::recordSingleRowResult($queryString)['totalItem'];
    }
    public function getItems($params = [])
    {
        $queryString = "SELECT * FROM `$this->table`";

        $queryString = $this->createFilterQuery($queryString, $params);

        $startElement = ($params['page'] - 1) * $this->totalItemsPerPage;
        $queryString .= ' LIMIT ' . $startElement . ', ' . $this->totalItemsPerPage;

        $items = $this->recordQueryResult($queryString);
        return $items;
    }
    public function getItem($id = null)
    {
        // null does nothing
        $getQuery = 'SELECT * FROM ' . $this->table . ' WHERE `id` = ' . $id;
        $arrayResult = parent::recordSingleRowResult($getQuery);
        return $arrayResult;
    }
    public function patchName($id, $newValue) {
        $data = [
            'name' => $newValue
        ];
        $Validate = new Validate($data);
        $options = array(
            'type' => 'string',
            'min' => 1,
            'max' => 100
        );
        $Validate->addRule('name', 'string', $options);
        $Validate->run();
        $errorEnd = $Validate->getErrors();
        if (!count($errorEnd)) {
            parent::updateOnlyOneId($_GET);
            return true;
        }
        return $errorEnd;
    }
    public function updateItem($id, $params = [])
    {
        // bien doi va chuandata
        // chuan bi condition
        // $this->update($data, $contdition);
        $oldImage = !empty(($this->getItem($id))['image']) ?? '';
        $rule = RULE_HOME_SECTION;
        unset($rule['image']);
        $fieldsModified = $this->prepareParams($params);
        $Validate = new Validate($params);
        $Validate->addAllRules($rule);
        $Validate->run();
        $resultEnd = $Validate->getResults();
        $errorEnd = $Validate->getErrors();

        if (!count($errorEnd)) {

            $fieldsModified['id'] = $id;
            $fieldsModified['updated_at'] = date("Y-m-d H:i:s");
            $tmp_file_name = $fieldsModified['tmp_name'] ?? '';
            $image_name = isset($fieldsModified['image']) ? randomString(5) . "." . pathinfo($fieldsModified['image'], PATHINFO_EXTENSION) : '';
            unset($fieldsModified['tmp_name']);
            $this->updateOnlyOneId($fieldsModified);

            if ($oldImage !== '') {
                $oldPath = "../../assets/images/home-section/" . $oldImage;
                @unlink($oldPath);
            }

            if ($image_name !== '') {
                $realPath = "../../assets/images/home-section/" . $image_name;
                @move_uploaded_file($tmp_file_name, $realPath);
            }
            return true;
        }

        return $Validate->showErrors();
    }
    public function createItems($params = [])
    {
        $this->insert($params, 'multi');
    }
    public function createItem($params = [])
    {
        $fieldsAdded = $this->prepareParams($params);
        $fieldsAdded['created_at'] = date("Y-m-d H:i:s");

        if (!empty($fieldsAdded)) {
            $rule = RULE_HOME_SECTION;
            $tmp_file_name = $fieldsAdded['tmp_name'] ?? '';
            unset($fieldsAdded['tmp_name']);
            unset($rule['order']);
            unset($rule['image']);
            $validateObj = new Validate($fieldsAdded);
            $validateObj->addAllRules($rule);
            $validateObj->run();
            $result = $validateObj->getResults();
            $errors = $validateObj->getErrors();
            if (empty($errors)) {
                $lastId = $this->insert($fieldsAdded, 'single');
                if ($tmp_file_name !== '') {
                    $imageName = randomString(5) . "." . pathinfo($fieldsAdded['image'], PATHINFO_EXTENSION);
                    if (move_uploaded_file($tmp_file_name, '../../assets/images/home-section/' . $imageName)) {
                        Header("Location: index.php");
                        exit();
                    }
                }
            }
        }
        return [
            'errors' => $validateObj->showErrors()
        ];
    }
    public function deleteItem($id)
    {
        $delQuery = "DELETE FROM " . "`" . parent::getTable() . "`" . " WHERE `id` = " . "'" . $id . "'";
        $getQuery = "SELECT * FROM " . "`" . parent::getTable() . "`" . " WHERE `id` = " . "'" . $id . "'";
        $arrayID = (parent::recordSingleRowResult($getQuery));
        $arr = parent::query($delQuery);
        $imageName = $arrayID['image'] ?? '';
        if ($imageName !== '') {
            @unlink('../../assets/images/home-section/' . $imageName);
        }
        return true;
    }
    public function search() {}
    private function prepareParams($params = [])
    {
        $fieldsAdded = array_intersect_key($params, array_flip($this->fields));
        $fieldsAdded['status'] = (isset($params['status']) && $params['status'] == "on") ? 1 : 0;
        $temporaryVar = '';
        if (isset($fieldsAdded['image']['name']) && !empty($fieldsAdded['image']['name'])) {
            $temporaryVar = $fieldsAdded['image']['name'];
            $tmp_file_name = $fieldsAdded['image']['tmp_name'];
        }
        unset($fieldsAdded['image']);
        if ($temporaryVar) {
            $fieldsAdded['image'] = randomString(5) . "." . pathinfo($temporaryVar, PATHINFO_EXTENSION);
            $fieldsAdded['tmp_name'] = $tmp_file_name;
        }
        $fieldsAdded = array_map(function ($value) {
            return is_array($value) ? $value : trim((string)$value);
        }, $fieldsAdded);
        return $fieldsAdded;
    }
}
