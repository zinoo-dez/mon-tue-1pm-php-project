<?php
session_start();
require "./server/db.php";
require "./layouts/header.php";
require "./layouts/navbar.php";
$errors = [];
$date = new DateTime('now');
$now = $date->format('Y-m-d H:i:s');
// require "./layouts/carousel.php";
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // echo "ok"; 
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        empty($email) ? $errors[] = "email required" : "";
        empty($password) ? $errors[] = "password required" : "";

        $email_check_qry = "SELECT * FROM users WHERE email = :email";
        $s = $pdo->prepare($email_check_qry);
        $s->bindParam(":email", $email, PDO::PARAM_STR);
        $s->execute();
        $res = $s->fetch();
        // print_r($res['password']);
        // die();
        if ($email === "admin@admin.com" && $password === "admin") {
            $_SESSION['name'] = "Admin";
            $_SESSION['admin'] = true;
            header("location:admin/dashboard.php");
        } else {
            if ($res) {
                if (password_verify($password, $res['password'])) {
                    $_SESSION['name'] = $res['name'];
                    header("location:index.php?message=welcome");
                } else {
                    $errors[] = "password do not match";
                }
            } else {
                $errors[] = "email not found";
            }
        }
    }
}
?>
<div class="p-5">

    <form action="login.php" method="post" class="w-50 m-auto shadow p-5">
        <?php include "error.php" ?>
        <h2 class="text-center mb-4">Login Here</h2>
        <div class="mb-3">
            <label for="">Email</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="mb-3">
            <label for="">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <input type="submit" class="btn btn-primary" value="submit" name="login">
    </form>
</div>
<?php
require "./layouts/footer.php";
?>