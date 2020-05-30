<?php 
require_once("inheret_functions.php");
class User extends Functions{
    private $first_name;
    private $last_name;
    private $birthday;
    private $nationality;
    private $passport;
    private $id_card;
    private $email;
    private $phone;
    private $password_user;
    private $role;

    function __construct($connection){
        $this->table_name = "Users";
        $this->id_name = "id_user";
        Functions::__construct($connection);
    }

    public function get_data(){
        return [
            "first_name"    =>  $this->first_name,
            "last_name"     =>  $this->last_name,
            "birthday"      =>  $this->birthday,
            "nationality"   =>  $this->nationality,
            "passport"      =>  $this->passport,
            "id_card"       =>  $this->id_card,
            "email"         =>  $this->email,
            "phone"         =>  $this->phone,
            "role"          =>  $this->role
        ];
    }

    public function create_new($post, $names=[]){
        $issafe = true;
        $this->first_name    = $this->safe_data($post, $names[0],$issafe);
        $this->last_name     = $this->safe_data($post, $names[1],$issafe);
        $this->birthday      = $this->safe_data($post, $names[2],$issafe); 
        $this->nationality   = $this->safe_data($post, $names[3],$issafe);
        $this->passport      = $this->safe_data($post, $names[4],$issafe);
        $this->id_card       = $this->safe_data($post, $names[5],$issafe);
        $this->email         = $this->safe_data($post, $names[6],$issafe);
        $this->phone         = $this->safe_data($post, $names[7],$issafe);
        $this->password_user = $this->safe_data($post, $names[8],$issafe);
        $this->role          = "user";

        if($issafe){
            $query = "INSERT INTO {$this->table_name} (";
            $query .= "first_name, last_name, id_card, passport, nationality, birthday, email, password_user, phone, role";
            $query .= ") VALUES (";
            $query .= "'{$this->first_name}', '{$this->last_name}', '{$this->id_card}', ";
            $query .= "'{$this->passport}', '{$this->nationality}', '{$this->birthday}',"; 
            $query .= "'{$this->email}', '{$this->password_user}', '{$this->phone}', '{$this->role}') ";

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
                $this->id            = $row["id_user"];
                $this->first_name    = $row["first_name"];
                $this->last_name     = $row["last_name"];
                $this->birthday      = date("d-m-Y", strtotime($row["birthday"]));
                $this->nationality   = $row["nationality"];
                $this->passport      = $row["passport"];
                $this->id_card       = $row["id_card"];
                $this->email         = $row["email"];
                $this->phone         = $row["phone"];
                $this->password_user = $row["password_user"];
                $this->role          = $row["role"];
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

    public function login($post,$names=[]){
        $issafe = true;
        $email          = $this->safe_data($post,$names[0],$issafe);
        $password_user  = $this->safe_data($post,$names[1],$issafe);
        if($issafe){
            $query = "SELECT * FROM {$this->table_name} ";
            $query .= "WHERE email = '{$email}' AND password_user = '{$password_user}' LIMIT 1";
            $result = mysqli_query($this->mysqli, $query);

            if($result){
                if($result->num_rows == 1){
                    $row = mysqli_fetch_assoc($result);
                    $this->id            = $row["id_user"];
                    $this->first_name    = $row["first_name"];
                    $this->last_name     = $row["last_name"];
                    $this->birthday      = $row["birthday"]; 
                    $this->nationality   = $row["nationality"];
                    $this->passport      = $row["passport"];
                    $this->id_card       = $row["id_card"];
                    $this->email         = $row["email"];
                    $this->phone         = $row["phone"];
                    $this->password_user = $row["password_user"];
                    $this->role          = $row["role"];
                    $this->has_row       = true;
                    mysqli_free_result($result);
                    return true;
                }else{
                    return false;
                }
            }else{
                die("Error in : " . $query . "<br>" . mysqli_error($this->mysqli));
            }
        }
    }
}
?>