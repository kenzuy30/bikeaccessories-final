<?php
include 'header.php';
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    ob_end_flush();
}
?>

<div class="container d-flex my-5 align-items-center justify-content-center" style="height: auto; font-size: 1rem">
    <div class="shadow p-4 bg-primary rounded-5" style="width:300px; height: auto;">
        <?php
        $userID = $_SESSION['u_id'];

        $profile = $conn->prepare("SELECT * FROM users WHERE userID=?");
        $profile->execute([$userID]);
        foreach($profile as $edit) { ?>
        <form method="post" action="backend.php">
            <div class="mb-2">
                <label for="exampleInputEmail1" class="form-label">First Name</label>
                <input type="hidden" class="form-control" id="exampleInputEmail1" name="userID" value="<?=$_SESSION['u_id']?>">
                <input type="text" class="form-control" id="exampleInputEmail1" name="f_name" value="<?=$edit['userFirstName']?>">
            </div>
            <div class="mb-2">
                <label for="exampleInputEmail2" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="exampleInputEmail2" name="l_name" value="<?=$edit['userLastName']?>">
            </div>
            <div class="mb-2">
                <label for="exampleInputEmail3" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail3" aria-describedby="emailHelp" name="email" value="<?=$edit['userEmail']?>">
            </div>
            <div class="mb-2">
                <label for="exampleInputPassword4" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword4" name="p1">
            </div>
            <div class="mb-2">
                <label for="exampleInputPassword5" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="exampleInputPassword5" name="p2">
            </div>
            <div class="mb-2 form-check card-body text-end">
                <a href="login.php" class="mx-3 text-warning">Sign In?</a>
            </div>
            <div class="mb-2 form-check card-body text-center">
                <button type="submit" class="btn btn-info" name="profile">Edit</button>
            </div>
        </form>
        <?php } ?>
    </div>
</div>

</div>
</body>

</html>