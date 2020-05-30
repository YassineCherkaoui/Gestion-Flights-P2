<?php 
require_once("inheret_functions.php");
class Reservation extends Functions{

    private $id_flight;
    private $id_user;
    private $date_resevation;

    function __construct($connection){
        $this->table_name = "Reservation";
        $this->id_name = "id_resevation";
        Functions::__construct($connection);
    }

    public function get_data(){
        return [
            "id_flight"         =>  $this->id_flight,
            "id_user"           =>  $this->id_user,
            "date_resevation"   =>  $this->date_resevation
        ];
    }

    public function create_new($post, $names){
        $issafe = true;

        $this->id_flight  = $this->safe_data($post, $names[0],$issafe);
        $this->id_user    = $this->safe_data($post, $names[1],$issafe); 

        if($issafe){
            $query = "INSERT INTO {$this->table_name} (";
            $query .= "id_flight, id_user";
            $query .= ") VALUES (";
            $query .= "{$this->id_flight}, {$this->id_user})";

            $result = mysqli_query($this->mysqli, $query);
            if($result){
                if(mysqli_affected_rows($this->mysqli) == 1){
                    $this->id =  mysqli_insert_id($this->mysqli);
                    $this->has_row = true;
                    return true;
                }
            }else{
                die("Error in : " . $query . "<br>" . mysqli_error($this->mysqli));
            }
        }else{
            return false;
        }
    }

    public function create_from_id($id){
        $query = "SELECT * FROM {$this->table_name} WHERE {$this->id_name} = {$id}";
        $result = mysqli_query($this->mysqli, $query);
        if($result){
            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);
                $this->id               = $row["id_resevation"];
                $this->id_flight        = $row["id_flight"];
                $this->id_user          = $row["id_user"];
                $this->date_resevation  = $row["date_resevation"]; 
                $this->has_row          = true;

                mysqli_free_result($result);
                return $this;
            }else{
                return false;
            }
        }else{
            die("Error in : " . $query . "<br>" . mysqli_error($this->mysqli));
        }
    }
}
?>