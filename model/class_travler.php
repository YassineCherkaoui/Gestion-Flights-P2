<?php 
require_once("inheret_functions.php");
class Travler extends Functions{

    private $id_user;
    private $id_flight;
    private $id_resevation;
    private $first_name;
    private $last_name;
    private $passport;

    function __construct($connection){
        $this->table_name = "Travler";
        $this->id_name = "id_travler";
        Functions::__construct($connection);
    }

    public function get_data(){
        return [
            "id_user"        =>  $this->id_user,
            "id_flight"      =>  $this->id_flight,
            "id_resevation"  =>  $this->id_resevation,
            "first_name"     =>  $this->first_name,
            "last_name"      =>  $this->last_name,
            "passport"       =>  $this->passport
        ];
    }

    public function create_new($post, $names){
        $issafe = true;

        $this->id_user         = $this->safe_data($post, $names[0],$issafe);
        $this->id_flight       = $this->safe_data($post, $names[1],$issafe);
        $this->id_resevation   = $this->safe_data($post, $names[2],$issafe);
        $this->first_name      = $this->safe_data($post, $names[3],$issafe); 
        $this->last_name       = $this->safe_data($post, $names[4],$issafe); 
        $this->passport        = $this->safe_data($post, $names[5],$issafe); 

        if($issafe){
            $query = "INSERT INTO {$this->table_name} (";
            $query .= "id_user, id_flight, id_resevation, first_name, last_name, passport";
            $query .= ") VALUES (";
            $query .= "{$this->id_user}, {$this->id_flight}, {$this->id_resevation}, '{$this->first_name}', '{$this->last_name}', '{$this->passport}')";

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
                $this->id            = $row["id_travler"];
                $this->id_user       = $row["id_user"];
                $this->id_flight     = $row["id_flight"];
                $this->id_resevation = $row["id_resevation"];
                $this->first_name    = $row["first_name"];
                $this->last_name     = $row["last_name"];
                $this->passport      = $row["passport"];
                $this->has_row       = true;

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