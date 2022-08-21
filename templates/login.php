<?php require_once "../partials/header.php"; ?>
   
    <main style="height: 100vh;" class="d-flex justify-content-center align-items-center">
        <div class="bg-dark rounded px-3" style="width: 400px;">
            <h3 class="text-center my-2">Login</h3>
            <?php
                if(isset($_GET['error'])){
                    echo '<div class="p-2 rounded bg-danger my-3">'.$_GET['error'].'</div>';
                }
            ?>
            <?php
                if(isset($_GET['success'])){
                    echo '<div class="p-2 rounded bg-success my-3">'.$_GET['success'].'</div>';
                }
            ?>
            <form action="../logic/auth.php" method="POST" class="my-2">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div>
                            <input type="submit" name="login" value="Login" class="btn btn-success w-100">
                        </div>
                    </div>
                </div>
            </form>
            <p>don't have account? <a href="register.php">register</a></p>
        </div>
    </main>
    
<?php require_once "../partials/footer.php"; ?>

