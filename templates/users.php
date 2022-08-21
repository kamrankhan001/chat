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
                    <img src="<?php echo 'data:image/jpeg;base64,'.$_SESSION['avatar'] ?>" alt="avatar" class="rounded-circle" width="30px" height="30px">
                    <span class="mx-2"><?php echo $_SESSION['lname']. " ". $_SESSION['fname'] ?></span>
                </div>
                <div class="py-2">
                    <form action="../logic/auth.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $_SESSION['unique_id'] ?>">
                        <button type="submit" name="logout" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </div>
            <hr>
            <div id="all-users">
                
            </div>
        </div>
    </main>
    
<?php require_once "../partials/footer.php"; ?>
<script src="../assets/js/users.js"></script>

