<?php require_once "../partials/header.php"; ?>
   
    <main style="height: 100vh;" class="d-flex justify-content-center align-items-center">
        <div class="bg-dark rounded px-3" style="width: 400px;">
            <h3 class="text-center my-2">Register</h3>
            <?php
                if(isset($_GET['error'])){
                    echo '<div class="p-2 rounded bg-danger my-3">'.$_GET['error'].'</div>';
                }
            ?>
            <form action="../logic/auth.php" method="POST" enctype='multipart/form-data' class="my-2">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" autocomplete="off" required>
                          </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" autocomplete="off" required>
                        </div>
                    </div>
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
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Avatar</label>
                            <input type="file" class="form-control" id="avatar" name="avatar" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div>
                            <input type="submit" name="register" value="Register" class="btn btn-success w-100">
                        </div>
                    </div>
                </div>
            </form>
            <p>already have account? <a href="login.php">login</a></p>
        </div>
    </main>
    
<?php require_once "../partials/footer.php"; ?>

