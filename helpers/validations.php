<?Php 

    require_once('database.php');

    class Validations{

        protected $db_host;
        protected $db_username;
        protected $db_password;
        protected $db_database;

        public function __construct($db_host, $db_username, $db_password, $db_database){
            $this->db_host = $db_host;
            $this->db_username = $db_username;
            $this->db_password = $db_password;
            $this->db_database = $db_database;
        }

        public function required($value){
            if(empty($value)){
                return "All field is required";
            }else {
                return true;
            }
        }

        public function email_validator($email) {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return "{$email}: not a valid email";
            }
            else {
                return true;
            }
        }

        public function username_validator($username){
            if(!preg_match('/^[a-z]\w{2,23}[^_]$/i', $username)) {
                return "It must start with a letter. greater than 4 and not less than 25\nIt can only contain letters, numbers, and the underscore character\nand it can not end with an underscore";
            }else {
                return true;
            }
        }

        public function number_validator($number){
            if(!is_numeric($number)){
                return "only number is allowed";
            }else {
                return true;
            }
        }

        public function min($value, $min){
            if(strlen($value) < $min){
                return "Password must be more then {$min}";
            }else {
                return true;
            }
        }

        public function max($value, $max){
            if(strlen($value) > $max){
                return "Password must be less than {$max}";
            }else {
                return true;
            }
        }

        public function password_confirm($password, $confirm_password){
            if(!($password === $confirm_password)){
                return "password confirmation not match";
            }else {

                return true;
            }
        }

        public function url_validator($url){
            $pattern = "/^((https|http|ftp)\:\/\/)?([a-z0-9A-Z]+\.[a-z0-9A-Z]+\.[a-z0-9A-Z]+\.[a-zA-Z]{2,4}|[a-z0-9A-Z]+\.[a-z0-9A-Z]+\.[a-zA-Z]{2,4}|[a-z0-9A-Z]+\.[a-zA-Z]{2,4})$/i";
            if(!preg_match($pattern, $url)){
                return "url is invalid";
            }else{
                return true;
            }
        }

        public function file($file, array $allowed){
            $extension = array_slice(explode('.', $file),-1);
            if(!in_array($extension[0], $allowed)){
                $extensions = '';
                for($i=0; $i<count($allowed); $i++){
                    $extensions .= $allowed[$i]." ";
                }
                return "Only these type of files allowed {$extensions}";
            }else {
                return true;
            }
        }

        public function unique($column, $table, $value){
            $db = new Database($this->db_host, $this->db_username, $this->db_password, $this->db_database);
            $db->sql("SELECT {$column} FROM {$table}");
            $result = $db->getResult();
            $exist = false;
            if(empty($result)){
                $exist = true;
            }
            foreach ($result as $email) {
                if($email['email'] == $value){
                    $exist = false;
                    break;
                }else{
                    $exist = true;
                }
            }
            if(!$exist){
                return "The {$value} already exist";
            }else {
                return true;
            }
        }

        public function validater($value, array $validations){

            $check_validater = $this->is_validation_exist($validations);
            $ok = false;
            if($check_validater[0] === true){

                foreach ($validations as $validater) {
                    $validater = explode(':',$validater);
                    if($validater[0] == 'required'){
                        $required = $this->required($value);
                        if($required === true){continue;} else{return $required;}
                    }

                    if($validater[0] == 'email'){
                        $email = $this->email_validator($value);
                        if($email === true){continue;} else{return $email;}
                    }
                    
                    if($validater[0] == 'username'){
                        $username = $this->username_validator($value);
                        if($username === true){continue;} else{return $username;}
                    }

                    if($validater[0] == 'number'){
                        $number = $this->number_validator($value);
                        if($number === true){continue;} else{return $number;}
                    }

                    if($validater[0] == 'url'){
                        $url = $this->url_validator($value);
                        if($url === true){continue;} else{return $url;}
                    }

                    if($validater[0] == 'unique'){
                        $unique_arr = explode(" ",$check_validater[1][$validater[0]]);
                        $unique = $this->unique($unique_arr[1], $unique_arr[0],$value);
                        if($unique === true){continue;} else{return $unique;}
                    }

                    if($validater[0] == 'min'){
                        $min = $this->min($value,$check_validater[1][$validater[0]]);
                        if($min === true){continue;} else{return $min;}
                    }

                    if($validater[0] == 'max'){
                        $max = $this->max($value,$check_validater[1][$validater[0]]);
                        if($max === true){continue;} else{return $max;}
                    }

                    if($validater[0] == 'password'){
                        $password = $this->password_confirm($value,$check_validater[1][$validater[0]]);
                        if($password === true){continue;} else{return $password;}
                    }    

                    if($validater[0] == 'file'){
                        $allow = array();
                        foreach(explode(",",trim($check_validater[1][$validater[0]], "[]")) as $extension){
                            $new = trim($extension, '"');
                            array_push($allow, $new);
                        }
                        $file = $this->file($value,$allow);
                        if($file === true){continue;} else{return $file;}
                    }     

                }
                if(!$ok){
                    return true;
                }

            }else {
                return $check_validater;
            }
            
        }

        public function is_validation_exist(array $validater){

            $complex = array();
            $validations = ['required','email','unique', 'file', 'url', 'password', 'max' ,'min', 'number', 'username'];

            foreach ($validater as $value) {
                $value_arr = explode(':', $value);
                
                if (array_key_exists(1, $value_arr)) {
                    $complex[$value_arr[0]] = $value_arr[1];
                }

                if(in_array($value_arr[0], $validations)){
                    continue;
                }else {
                    return $value." is not valid validater";
                }
            }

            return [true, $complex];
        }
    }
