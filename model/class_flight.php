<?php 
require_once("inheret_functions.php");
class Flight extends Functions{

    private $plane_name;
    private $depart;
    private $distination;
    private $date_flight;
    private $price;
    private $total_places;
    private $is_active;

    function __construct($connection){
        $this->table_name = "Flight";
        $this->id_name = "id_flight";
        Functions::__construct($connection);
    }

    public function get_data(){
        return [
            "plane_name"    =>  $this->plane_name,
            "depart"        =>  $this->depart,
            "distination"   =>  $this->distination,
            "date_flight"   =>  $this->date_flight,
            "price"         =>  $this->price,
            "total_places"  =>  $this->total_places,
            "is_active"     =>  $this->is_active
        ];
    }

    public function create_new($post, $names){
        $issafe = true;

        $this->plane_name   = $this->safe_data($post, $names[0],$issafe);
        $this->depart       = $this->safe_data($post, $names[1],$issafe); 
        $this->distination  = $this->safe_data($post, $names[2],$issafe);
        $this->date_flight  = $this->safe_data($post, $names[3],$issafe);
        $this->total_places = $this->safe_data($post, $names[4],$issafe);
        $this->price        = $this->safe_data($post, $names[5],$issafe);
        $this->is_active    = $this->safe_data($post, $names[6],$issafe);

        if($issafe){
            $query = "INSERT INTO {$this->table_name} (";
            $query .= "plane_name, depart, distination, date_flight, total_places, price, is_active";
            $query .= ") VALUES (";
            $query .= "'{$this->plane_name}', '{$this->depart}', '{$this->distination}', ";
            $query .= "'{$this->date_flight}', {$this->total_places}, {$this->price}, {$this->is_active})";
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
                $this->id           = $row["id_flight"];
                $this->plane_name   = $row["plane_name"];
                $this->depart       = $row["depart"];
                $this->distination  = $row["distination"]; 
                $this->date_flight  = $row["date_flight"];
                $this->price        = $row["price"];
                $this->total_places = $row["total_places"];
                $this->is_active    = $row["is_active"];
                $this->has_row      = true;

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