<?php

    require_once "../config.php";
    require_once "../helpers/database.php";
    require_once "../helpers/validations.php";

    session_start();

    class Auth{

        protected $db;
        protected $validater;

        public function __construct(){
            $this->db = new Database(db_host,db_username,db_password,db_database);
            $this->validater = new Validations(db_host,db_username,db_password,db_database);
        }

        public function register(array $credentials){

            $error = $this->validater->validater($credentials['fname'], ['required']);
            if($error === true){
                $error = $this->validater->validater($credentials['lname'], ['required']);
                if($error === true){
                    $error = $this->validater->validater($credentials['email'], ['required', 'email', 'unique:users email']);
                    if($error === true){
                        $error = $this->validater->validater($credentials['password'], ['required', 'min:8', 'max:13']);
                        if($error === true){
                            $error = $this->validater->validater($credentials['avatar']['name'], ['required', 'file:["jpg","png","jpeg"]']);
                            if($error === true){
                                $credentials['unique_id'] = rand(time(), 100000000);
                                $credentials['avatar'] = base64_encode(file_get_contents($credentials['avatar']['tmp_name']));
                                $credentials['password'] = password_hash($credentials['password'], PASSWORD_DEFAULT);
                                $this->db->insert('users', $credentials);
                                return header("location: ../templates/login.php?success=you are register successfully");
                            }else{
                                return header("location: ../templates/register.php?error={$error}");
                            }
                        }else{
                            return header("location: ../templates/register.php?error={$error}");
                        }
                    }else{
                        return header("location: ../templates/register.php?error={$error}");
                    }
                }else{
                    return header("location: ../templates/register.php?error={$error}");
                }
            }else{
                return header("location: ../templates/register.php?error={$error}");
            }
        }

        public function login($email, $password){
            $error = $this->validater->validater($email, ['required', 'email']);
            if($error === true){
                $error = $this->validater->validater($password, ['required']);
                if($error === true){
                    $this->db->sql("SELECT * FROM users WHERE email='$email'");
                    $result = $this->db->getResult();
                    if(count($result) > 0){
                        if(password_verify($password, $result[0]['password'])){
                            $_SESSION['unique_id'] = $result[0]['unique_id'];
                            $_SESSION['avatar'] = $result[0]['avatar'];
                            $_SESSION['fname'] = $result[0]['fname'];
                            $_SESSION['lname'] = $result[0]['lname'];
                            $this->db->update('users', ['status'=>'Active now'], "email='$email'");
                            return header("location: ../templates/users.php");
                        }else{
                            return header("location: ../templates/login.php?error=Password didn't match");
                        }
                    }else{
                        return header("location: ../templates/login.php?error=Email don't exist");
                    }
                }else{
                    return header("location: ../templates/login.php?error={$error}");
                }
            }else{
                return header("location: ../templates/login.php?error={$error}");
            }
        }

        public function logout($unique_id){
            $this->db->update('users', ['status'=>'Inactive now'], "unique_id='$unique_id'");
            session_destroy();
            header("location: ../templates/login.php?success=You are logout now");
        }
    }

    $auth = new Auth();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['register'])){
            $credentials = [
                'fname' => $_POST['first_name'],
                'lname' => $_POST['last_name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'avatar' => $_FILES['avatar'],
                'status' => "Inactive now",
            ];

            $auth->register($credentials);
        }

        if(isset($_POST['login'])){
            $auth->login($_POST['email'],$_POST['password']);
        }

        if(isset($_POST['logout'])){
            $auth->logout($_POST['id']);
        }
    }