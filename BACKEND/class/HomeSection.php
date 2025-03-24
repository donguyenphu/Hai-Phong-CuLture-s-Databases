<?php
require_once 'Database.php';
require_once 'Validate.php';
require_once '../../define/homeValidate.php';
require_once '../../elements/functions.php';

class HomeSection extends Database
{

    protected $table;
    public $imageFolderName;
    public $imageFolderPath;
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
        $this->imageFolderPath = '../../assets/images/' . $this->imageFolderName . '/';
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
        $queryString .= ' ORDER BY `order`';
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
    public function patchName($id, $newValue)
    {
        $data = [
            'id' => $id,
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
            parent::updateOnlyOneId($data);
            return true;
        }
        return $errorEnd;
    }
    public function patchStatus($id, $newStatusValue)
    {
        $data = [
            'id' => $id,
            'status' => $newStatusValue
        ];
        return parent::updateOnlyOneId($data);
    }
    public function patchOrder($id, $newOrderValue)
    {
        $data = [
            'id' => $id,
            'order' => $newOrderValue
        ];
        $ruleOrder = [
            'type' => 'int',
            'min' => 1,
            'max' => 256
        ];
        $Validate = new Validate($data);
        $Validate->addRule('order', 'int', $ruleOrder);
        $Validate->run();
        $result = $Validate->getResults();
        $errorEnd = $Validate->getErrors();

        if (!count($errorEnd)) {
            parent::updateOnlyOneId($data);
            return true;
        }
        return $Validate->showErrors();
    }
    public function updateItem($id, $params = [])
    {
        // bien doi va chuandata
        // chuan bi condition
        // $this->update($data, $contdition);
        $oldData = $this->getItem($id);
        $oldImage = !empty($oldData['image']) ? $oldData['image'] : '';
        $rule = RULE_HOME_SECTION;
        $fieldsModified = $this->prepareParams($params);
        if (empty($fieldsModified['image']['name'])) unset($rule['image']);
        $validate = new Validate($fieldsModified);
        $validate->addAllRules($rule);
        $validate->run();
        $result = $validate->getResults();
        $errors = $validate->getErrors();
        if (!count($errors)) {
            $result['id'] = $id;
            $result['updated_at'] = date("Y-m-d H:i:s");
            if (!empty($result['image']['name'])) {
                $fileName = $this->uploadFile($result['image']);
                $result['image'] = $fileName;
                $this->deleteFile($oldImage);
            } else {
                $result['image'] = $oldImage;
            }
            $this->updateOnlyOneId($result);
            return true;
        }
        return $validate->showErrors();
    }
    public function createItems($params = [])
    {
        $this->insert($params, 'multi');
    }
    public function createItem($params = [])
    {
        $fieldsAdded = $this->prepareParams($params);
        $fieldsAdded['order'] = 1;
        $fieldsAdded['created_at'] = date("Y-m-d H:i:s");
        // upload ảnh -> có được tên ảnh -> set phần fieldAdded['image'] = tên ảnh
        // insert dữ liệu vào database
        // order default is 1
        $validateObj = new Validate($fieldsAdded);
        if (!empty($fieldsAdded)) {
            $rule = RULE_HOME_SECTION;
            // unset($rule['image']);
            $validateObj->addAllRules($rule);
            $validateObj->run();
            $result = $validateObj->getResults();
            $errors = $validateObj->getErrors();
            if (!count($errors)) {
                $result['image'] = $this->uploadFile($fieldsAdded['image']);
                $lastId = $this->insert($result, 'single');
                return true;
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
        $fieldsAdded = array_map(function ($value) {
            return is_array($value) ? $value : trim((string)$value);
        }, $fieldsAdded);
        return $fieldsAdded;
    }
    private function uploadFile($file)
    {
        // $file is the array $fieldAdded['image']
        if (!empty($file)) {
            $fileName = randomString(5) . "." . pathinfo($file['name'], PATHINFO_EXTENSION);
            $tmpName = $file['tmp_name'];
            $destination = $this->imageFolderPath . $fileName;
            if (move_uploaded_file($tmpName, $destination)) {
                return $fileName;
            }
        }
        return ''; // return nothing when the array is empty
    }
    private function deleteFile($file)
    {
        $oldPath = $this->imageFolderPath . $file;
        @unlink($oldPath);
    }
}
