<?php 
 abstract class Functions{
    protected $mysqli;
    protected $has_row = false;

    protected $id = null;
    protected $table_name = null;
    protected $id_name = null;

    function __construct(){
        $this->mysqli = new mysqli("localhost", "root", "", "flightManagmentP2", "3306");
        if ($this->mysqli->connect_errno) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }
    }

    function __destruct(){
        $this->mysqli->close();
    }

    public function is_has_row(){
        return $this->has_row;
    }

    public function get_id(){
        return $this->id;
    }

    protected function safe_data($post,$name,&$issafe){
        if(isset($post[$name]) && trim($post[$name]) !== ""){
            return $this->mysqli->real_escape_string(trim($post[$name]));
        }else{
            $issafe = false;
            return null;
        }
    }

    public function update_row($assoc){
        $query = "UPDATE {$this->table_name} SET ";
        foreach($assoc as $key => $val){
            $query .= "{$key} = ";
            $query .= (gettype($val) == "string") ? "'{$val}'" : "{$val},";
        }
        $query = rtrim($query, ","); //remove the last , from the query
        $query .= " WHERE {$this->id_name} = {$this->id}";
        $result = $this->mysqli->query($query);
        if($result){
            if($result->affected_rows == 1){
                return true;
            }
        }else{
            die("Error in : " . $query . "<br>" . $this->mysqli->error);
        }
        return false;
    }

    public function delete_row(){
        if($this->has_row){
            $query = "DELETE from {$this->table_name} WHERE {$this->id_name} = {$this->id}";
            $result = $this->mysqli->query($query);
            if($result){
                if($result->affected_rows == 1){
                    $this->has_row = false;
                    return true;
                }else{
                    return false;
                }
            }else{
                die("Error in : " . $query . "<br>" . $this->mysqli->error);
            }
        }
        return false;
    }
 }
?>