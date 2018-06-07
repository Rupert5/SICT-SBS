<?php
abstract class dbAccess{
    public static function test($value,$ajax=false){
        $test = dbHandler::dql('SELECT DATABASE() DB',null,$ajax)['DB'];
        if ("$test" === "$value") {
            return true;
        }
        return false;
    }
    public static function get_data($relation,$id_field,$id,$ajax=false){
        return dbHandler::dql("SELECT * FROM $relation WHERE $id_field = :id", array(':id'=>$id),$ajax);
    }
    public static function recordExisits($relation, $field, $value,$ajax=false) {
        $sql = "SELECT COUNT($field) RECORDS FROM $relation WHERE $field = :value";
        $params = array(':value'=>$value);
        return dbHandler::DQL($sql,$params,$ajax)['RECORDS'];
    }
    public static function deleteRecord($relation, $id, $value,$ajax=false) {
        $sql = "DELETE FROM $relation WHERE $id = :value";
        $params = array(':value'=>$value);
        return dbHandler::Execute($sql,$params,$ajax);
    }
    public static function clearField($relation, array $fields, $default, $key, $value,$ajax=false) {
         $length = count($fields);
            $x = 0;
            $subjects = "";
            foreach ($fields as $field) {
                $x++;
                if ($x < $length) {
                    $subjects .= "$field = :empty" . ' , ';
                } else {
                    $subjects .= "$field = :empty";
                }
            }
            $sql = "UPDATE $relation SET $subjects WHERE $key = :value";
            $params = array(':value'=>$value,':empty'=>$default);
            return dbHandler::Execute($sql,$params,$ajax);
    }
    public static function getEnumDropDown($relation, $enum,$ajax=false) {
        $sql = "SHOW COLUMNS FROM $relation WHERE FIELD = :enum";
        $params = array(':enum' => $enum);
        $record = dbHandler::DQL($sql, $params,$ajax);
        $type = substr($record["Type"], 6, (strlen($record["Type"]) - 8));
        return explode("','", $type);
    }

}