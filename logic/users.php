<?php

    require_once "../helpers/database.php";
    require_once "../config.php";
    if(!(session_start() == PHP_SESSION_NONE)){
        session_start();
    }

    class Users{

        protected $db;

        public function __construct(){
            $this->db = new Database(db_host, db_username, db_password, db_database);
        }

        public function all_users(){
            $this->db->select('users', "*", null, "unique_id!=".$_SESSION['unique_id']);
            $result = $this->db->getResult();
            if(count($result) > 0){
                $output = "";
                foreach($result as $data){
                    $status = "bg-secondary";
                    if($data['status'] != 'Inactive now'){
                        $status = "bg-success";
                    }
                    $output .= '<a href="../logic/chat.php?id='.$data['unique_id'].'" class="d-flex justify-content-between align-items-center my-2 text-white text-decoration-none">
                                    <div class="py-2">
                                        <img src="data:image/jpeg;base64,'.$data['avatar'].'" alt="avatar" class="rounded-circle" width="30px" height="30px">
                                        <span class="mx-2">'.$data['fname']. " ". $data['lname'].'</span>
                                    </div>
                                    <div class="py-2">
                                        <div class="'.$status.' rounded-circle p-1"></div>
                                    </div>
                                </a>';
                }
                echo $output;
            }else{
                echo "No user available";
            }
        }

    }

    $users = new Users();

    $users->all_users();
