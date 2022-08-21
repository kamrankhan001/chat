<?php 
  require_once "../partials/header.php"; 
  if(!(session_start() == PHP_SESSION_NONE)){
    session_start();
  }
  if(!isset($_SESSION['unique_id'])){
    header("location: ../templates/login.php?error=Please login first");
  }
?>
   
<main style="height: 100vh;" class="d-flex justify-content-center align-items-center">
  <div class="bg-dark rounded px-3" style="width: 400px;">
      <div class="d-flex justify-content-between my-2">
          <div class="py-2">
              <img src="<?php echo 'data:image/jpeg;base64,'.$_SESSION['reciever_avatar'] ?>" alt="avatar" class="rounded-circle" width="30px" height="30px">
              <span class="mx-2"><?php echo $_SESSION['name'] ?></span>
          </div>
          <div class="py-2">
              <a href="users.php" class="btn btn-dark btn-sm">
                <i class="fa-solid fa-left-long"></i>
              </a>
          </div>
      </div>
      <div class="overflow-auto py-1 my-2 chat" style="height:350px;" id="user-chat">

      </div>
      <div>
        <form action="../logic/chat.php" method="POST" class="my-2" id="text-area">
          <div class="row">
            <div class="col-2">
              <button class="btn btn-secondary btn-sm" name="message" type="submit">
                <i class="fa-solid fa-paper-plane"></i>
              </button>
            </div>
            <div class="col-10">
              <input type="hidden" name="sender" value="<?php echo $_SESSION['unique_id']; ?>">
              <input type="hidden" name="reciever" value="<?php echo $_SESSION['reciever_id']; ?>">
              <input type="text" class="form-control" name="text" autocomplete="off">
            </div>
          </div>
        </form>
      </div>
  </div>
</main>   

<?php require_once "../partials/footer.php"; ?>
<script src="../assets/js/chat.js"></script>

