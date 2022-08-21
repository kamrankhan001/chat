<?php

    require_once "../helpers/database.php";
    require_once "../config.php";
    if(!(session_start() == PHP_SESSION_NONE)){
        session_start();
    }

    class Chat{

        protected $db;

        public function __construct(){
            $this->db = new Database(db_host, db_username, db_password, db_database);
        }

        public function page($id){
            $this->db->select('users', "*", null, "unique_id=".$id);
            $result = $this->db->getResult();
            if(count($result) == 1){
                $_SESSION['name'] = $result[0]['fname'] . " ". $result[0]['lname'];
                $_SESSION['reciever_avatar'] = $result[0]['avatar'];
                $_SESSION['reciever_id'] = $result[0]['unique_id'];
                return header("location: ../templates/chat.php");
            }else{
                echo "not found";
            }
        }

        public function save_chat($sender, $reciever, $message){
            $data = [
                'incoming_msg_id' => $reciever,
                'outgoing_msg_id' => $sender,
                'msg' => $message,
            ];
            $this->db->insert('messages', $data);
            echo true;
        }

        public function user_chat($sender, $reciever){
            $this->db->sql("SELECT * FROM messages WHERE (outgoing_msg_id = {$sender} AND incoming_msg_id = {$reciever}) OR (outgoing_msg_id = {$reciever} AND incoming_msg_id = {$sender}) ORDER BY msg_id");
            $result = $this->db->getResult();
            $output = "";
            foreach ($result as $value) {
                $output .= '<div class="clearfix">';
                if($value['outgoing_msg_id'] === $sender){
                        $output .= '<div class="p-2 float-start my-1" style="width: 200px; background-color:#262624;">
                                        <p>'.$value['msg'].'</p>
                                    </div>';
                    }else{
                        $output .= ' <div class="p-2 float-end my-1" style="width: 200px; background-color:#383838;">
                                        <p>'.$value['msg'].'</p>
                                    </div>';
                    }
                $output .= '</div>';
            }
            echo $output;
        }
    }

    $chat = new Chat();

    if(isset($_GET['id'])){

        $chat->page($_GET['id']);
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET'){

        $chat->user_chat($_GET['sender'], $_GET['reciever']);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['message'])){
            $chat->save_chat($_POST['sender'], $_POST['reciever'], $_POST['text']);
            $chat->user_chat($_POST['sender'], $_POST['reciever']);
        }
    }