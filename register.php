<?php
require "./server/db.php";
require "./layouts/header.php";
require "./layouts/navbar.php";
$errors = [];
$date = new DateTime('now');
$now = $date->format('Y-m-d H:i:s');
// require "./layouts/carousel.php";
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // echo "ok"; 
    if (isset($_POST['register'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = password_hash($password, PASSWORD_BCRYPT);
        $phone = $_POST['phone'];
        $photo = $_FILES['photo'];
        $pname = $_FILES['photo']['name'];
        $tmp_name = $_FILES['photo']['tmp_name'];
        move_uploaded_file($tmp_name, "img/$pname");
        $address = $_POST['address'];
        empty($name) ? $errors[] = "name required" : "";
        empty($email) ? $errors[] = "email required" : "";
        empty($password) ? $errors[] = "password required" : "";
        empty($phone) ? $errors[] = "phone required" : "";
        empty($pname) ? $errors[] = "photo required" : "";
        empty($address) ? $errors[] = "address required" : "";
        $email_check_qry = "SELECT * FROM users WHERE email = :email";
        $s = $pdo->prepare($email_check_qry);
        $s->bindParam(":email", $email, PDO::PARAM_STR);
        $s->execute();
        $res = $s->fetch();
        // print_r($res);
        // die();
        if (isset($res)) {
            if ($email === $res['email']) {
                $errors[] = "email already exist";
            } else {
                $sql = "INSERT INTO users (name,email,password,phone,photo,address,created_date,updated_date) VALUES (:name,:email,:password,:phone,:photo,:address,:created_date,:updated_date)";
                $statement = $pdo->prepare($sql);
                $statement->bindParam(":name", $name, PDO::PARAM_STR);
                $statement->bindParam(":email", $email, PDO::PARAM_STR);
                $statement->bindParam(":password", $password, PDO::PARAM_STR);
                $statement->bindParam(":phone", $phone, PDO::PARAM_STR);
                $statement->bindParam(":photo", $pname, PDO::PARAM_STR);
                $statement->bindParam(":address", $address, PDO::PARAM_STR);
                $statement->bindParam(":created_date", $now, PDO::PARAM_STR);
                $statement->bindParam(":updated_date", $now, PDO::PARAM_STR);
                $res =  $statement->execute();
                if ($res) {
                    header("location:login.php");
                } else {
                    $errors[] = "Insert Error Found";
                }
            }
        }
        // print_r($res['email']);
        // die();
    }
}
?>
<div class="p-5">
    <form action="register.php" class="w-50 m-auto shadow p-5" enctype="multipart/form-data" method="post">
        <?php include "./error.php" ?>
        <h2 class="text-center mb-4">Register Here</h2>
        <div class="mb-3">
            <label for="">Name</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="mb-3">
            <label for="">Email</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="mb-3">
            <label for="">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="mb-3">
            <label for="">Phone</label>
            <input type="tel" name="phone" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>
        <div class="mb-3">
            <label for="">Address</label>
            <textarea name="address" class="form-control"></textarea>
        </div>
        <input type="submit" class="btn btn-primary" value="submit" name="register">
    </form>
</div>
<?php
require "./layouts/footer.php";
?>