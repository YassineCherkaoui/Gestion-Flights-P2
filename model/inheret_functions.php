<?php 
 abstract class Functions{
    protected $mysqli;
    protected $has_row = false;

    protected $id = null;
    protected $table_name = null;
    protected $id_name = null;

    function __construct($mysqli){
        $this->mysqli = $mysqli;
    }

    public function is_has_row(){
        return $this->has_row;
    }

    public function get_id(){
        return $this->id;
    }

    protected function safe_data($post,$name,&$issafe){
        if(isset($post[$name]) && trim($post[$name]) !== ""){
            return mysqli_real_escape_string($this->mysqli,trim($post[$name]));
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
        $result = mysqli_query($this->mysqli,$query);
        if($result){
            if(mysqli_affected_rows($this->mysqli) == 1){
                return true;
            }
        }else{
            die("Error in : " . $query . "<br>" . mysqli_error($this->mysqli));
        }
        return false;
    }
 }
?>