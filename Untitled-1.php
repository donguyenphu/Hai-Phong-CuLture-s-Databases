$query = "SELECT * FROM `home_section`"

$arrWhereCondition = [];
if (isset($params['name']) && !empty($params['name'])) {
    $name = $params['name'];
    $arrWhereCondition[] = "`name` LIKE '%$name%'";
}

if (isset($params['url']) && !empty($params['name'])) {
    $url = $params['url'];
    $arrWhereCondition[] = "`url` LIKE '%$url%'";
}

if (!empty($arrWhereCondition)) {
    $queryWhere = implode(' AND ', $arrWhereCondition);
    $query .= "WHERE " . $queryWhere;
}