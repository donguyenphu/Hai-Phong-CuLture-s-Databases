<?php
    class Database {

        protected $connect;
        protected $databaseName;
        protected $table;
        protected $resultQuery;

        // init & connect database
        public function __construct($initServer)
        {
            $link = mysqli_connect($initServer['server'], $initServer['username'], $initServer['password']);
            if (!$link) {
                die('Number of fail connect: '.mysqli_connect_errno());
            } 
            else {
                $this -> connect = $link;
                $this -> databaseName = $initServer['database'];
                $this -> table = $initServer['table'];
                $this -> setDatabase($initServer['database']);
                // SET FONT & CHARACTER FONT
                $this -> query("SET NAMES 'utf8'");
                $this -> query("SET CHARACTER SET 'utf8'");
            }
        }
        // set connect
        public function setConnect($connect) 
        {
            $this -> connect = $connect;
        }
        // set database
        public function setDatabase($databaseName = null) 
        {
            if ($databaseName != null) {
                $this -> databaseName = $databaseName;
            }
            mysqli_select_db($this -> connect, $this -> databaseName);
        }
        // set table
        public function setTable($table) 
        {
            $this -> table = $table;
        }
        // insert one row
        public function insert($data, $type = 'single') 
        {
            if ($type == 'single') {
                $resQuery = $this -> createInsertRow($data);
                $stringQuery = "INSERT INTO `".$this -> table."` (".$resQuery['cols'].") VALUES (".$resQuery['vals'].")";
                $this -> query($stringQuery);
            }
            else {
                foreach ($data as $key => $value) {
                    $resQuery = $this -> createInsertRow($value);
                    $stringQuery = "INSERT INTO `".$this -> table."` (".$resQuery['cols'].") VALUES (".$resQuery['vals'].")";
                    $this -> query($stringQuery);
                }
            }
            // return mysqli_insert_id($this -> connect); or
            return $this -> lastID();

        }
        public function createInsertRow($data) 
        {
            if (!empty($data)) {
                $newQr = [];
                $cols = '';
                $vals = '';
                foreach ($data as $key => $value) {
                    $cols .= ", `$key`";
                    $vals .= ", '$value'";
                }
                $newQr['cols'] = substr($cols, 2);
                $newQr['vals'] = substr($vals, 2);
                return $newQr;
                // include cols and vals
            }
        }
        public function lastID() 
        {
            return mysqli_insert_id($this -> connect);
        }
        public function query($stringQuery) 
        {
            $this -> resultQuery = mysqli_query($this -> connect, $stringQuery);  
            return $this -> resultQuery;
        }
        // UPDATE
        public function update($data, $condition) 
        {
            $newAssign = $this -> createAssignUpdate($data);
            $newCondition = $this -> createConditionUpdate($condition);
            $stringToQuery = "UPDATE `".$this -> table."` SET".$newAssign."WHERE ".$newCondition."";
            $result = mysqli_query($this -> connect, $stringToQuery);
            return "UPDATE `group` SET".$newAssign."WHERE ".$newCondition."";
        }
        public function createAssignUpdate($data) 
        {
            $outputQuery = "";
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    $outputQuery .= " , "."`$key` = "."'$value' ";
                }
            }
            return substr($outputQuery, 2);
        }
        public function createConditionUpdate($condition) 
        {
            // the $condition consists of
            // an array of arrays (column, new_value, relate_next_value)
            $resultConditionString = '';
            if (!empty($condition)) {
                foreach($condition as $value) {
                    $merge[] = "`".$value[0]."` = '".$value[1]."'";
                    if (count($value) > 2) $merge[] = $value[2];
                }
                $resultConditionString = implode(" ",$merge);
            }
            return $resultConditionString;
        }
        // affected rows
        public function affectedRows() 
        {
            return mysqli_affected_rows($this -> connect);
        }
        // delete
        public function delete($condition) 
        {
            $newQr = $this -> createConditionDelete($condition);
            $queryDelete = "DELETE FROM `".$this -> table."` WHERE `id` IN ($newQr)";
            $result = mysqli_query($this -> connect, $queryDelete);
            if ($result) {
                echo mysqli_affected_rows($this -> connect);
            }
            else {
                echo 'FAIL'.'</br>';
            }
        }
        // CREATE CONDITION DELETE
        public function createConditionDelete($IDS) 
        {
            $storageIds = '';
            if (!empty($IDS)) {
                foreach($IDS as $value) {
                    $storageIds .= "'".$value."', ";
                }
                $storageIds .="'0'";
            }
            return $storageIds;
        }
        // RECORD QUERY RESULT
        public function recordQueryResult($queryResult = null) 
        {
            $recordList = [];
            $queryString = ($queryResult == null ? $this -> resultQuery : $this -> query($queryResult));
            if (mysqli_num_rows($queryString) > 0) {
                while ($row = mysqli_fetch_assoc($queryString)) {
                    $recordList[] = $row;
                }
                mysqli_free_result($queryString);
            }
            return $recordList;
        }
        // RECORD ONLY SINGLE ROW
        public function recordSingleRowResult($queryResult = null) 
        {
            $recordRow = [];

            $queryString = ($queryResult == null ? $this -> resultQuery : $this -> query($queryResult));
            if (mysqli_num_rows($queryString) > 0) {
                $recordRow = mysqli_fetch_assoc($queryString);
                // FETCH ASSOC ONLY ONE TIME -> first ROW
                mysqli_free_result($queryString);
            }
            return $recordRow;
        }
        public function getConnect() 
        {
            return $this -> connect;
        }
        public function getDatabase() 
        {
            return $this -> databaseName;
        }
        public function getTable() 
        {
            return $this -> table;
        }
        public function getQueryResult() 
        {
            return $this -> resultQuery;
        }
        // close connect
        public function __destruct()
        {
            mysqli_close($this -> connect);
        }
    }
?>