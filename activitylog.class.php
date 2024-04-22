<?php
require 'session.php';
class AccessLog{
    function sanitize_value($value){
    if(!is_numeric($value) && empty($value)){
        if(is_object($value) && is_array($value)){
            $value = json_encode($value);
        }
        else {
            $value = addslashes(htmlspecialchars($value));
        }
    }
    return $value;
    }
    public function log($data = []){
        if(empty($data)){
            throw new ErrorException("Log data is empty");
            exit;
        }
        $params_values = [];
        $params_format = [];
        $query_values = [];
        foreach($data as $k => $v){
            $v = $this->sanitize_value($v);
            if(!empty($v)){
                if(is_numeric($v)){
                    $fmt[] = 'd';
                }
                else {
                    $fmt[] = 's';
                }
                $query_values[] = "`{$k}`";
                $params_values[] = $v;
                $params_format[] = $fmt;
            }
        }
        if(empty($query_values)){
            throw new ErrorException("Log data error");
            exit;
        }
        $sql = "INSERT INTO `activity_log` (".implode(", ", $query_values).") VALUES (".(implode(", ", str_split(str_repeat("?", count($query_values))))).")";
            $stmt = $this->db->prepare($sql);
            $fmts = implode("", $params_format);
            $stmt->bind_param($fmts, ...$params_values);
            $executed = $stmt->execute();
            if(!$executed){
                $resp = [
                    "status" => "success"
                ];
            }
            else {
                $resp = [
                    "status" => "error",
                    "sql" => $sql,
                    "queries" => $query_values,
                    "formats" => $fmts,
                    "values" => $params_values,
                ];
            }
            return $resp;
    }
    public function setAction($userID="", $activity = ""){
        $data = [];
        extract($_SERVER);
        $data['url'] = (empty($HTTPS) ? 'http' : 'https') . "://{$HTTP_HOST}{$REQUEST_URI}";
        $data[userID] = $userID;
        $data[activity] = addslashes(htmlspecialchars($activity));
        return $this -> log($data);
    }
    public function getLogs(){
        $query = $this->db->query("SELECT * FROM `activity_log` ORDER BY `id` DESC");
        $result = $query ->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
    function __destruct(){
        if ($this->db){
            $this->db->close();
        }
    }
}
?>