<?php
// print_r($_SERVER);
// die();
session_start();
$auth = isset($_SESSION['name']);
// require "server/db.php";
require "./layouts/header.php";
require "./layouts/navbar.php";
require "./layouts/carousel.php";
// $now = new DateTime('now');
// $now = $now->format('Y-m-d H:i:s');


// IN PDO
// $placeholder = str_repeat('?,');
// $sql = "SELECT * FROM users WHERE user_id in (?,?) ";
// $statement = $pdo->prepare($sql);
// $statement->execute([3, 5]);
// $res = $statement->fetchAll(PDO::FETCH_ASSOC);
// echo "<pre>";
// print_r($res);
// echo "</pre>";


// Insert PDO
// $sql = "INSERT INTO users (name,email,password,phone,photo,address,created_date,updated_date) VALUES (:name,:email,:password,:phone,:photo,:address,:created_date,:updated_date)";
// $sql = "INSERT INTO users (name,email,password,phone,photo,address,created_date,updated_date) VALUES (?,?,?,?,?,?,?,?)";
// $name = "bobo233";
// $email = "bobo233@gmail.com";
// $password = "bobo233";
// $phone = "0934567";
// $photo = "bobo233.png";
// $address = "ygn";
// $statement = $pdo->prepare($sql);
// $statement->bindParam(':name', $name, PDO::PARAM_STR);
// $statement->bindParam(':email', $email, PDO::PARAM_STR);
// $statement->bindParam(':password', $password, PDO::PARAM_STR);
// $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
// $statement->bindParam(':photo', $photo, PDO::PARAM_STR);
// $statement->bindParam(':address', $address, PDO::PARAM_STR);
// $statement->bindParam(':created_date', $now, PDO::PARAM_STR);
// $statement->bindParam(':updated_date', $now, PDO::PARAM_STR);
// $statement->execute();
// $statement->bindValue(':name', 'popo');
// $statement->bindValue(':email', 'popo@gmail.com');
// $statement->bindValue(':password', 'popo');
// $statement->bindValue(':phone', '0945678');
// $statement->bindValue(':photo', 'popo.png');
// $statement->bindValue(':address', 'latha');
// $statement->bindValue(':created_date', $now);
// $statement->bindValue(':updated_date', $now);
// $statement->execute();

// $statement->execute([
//     ":name" => "bbbb",
//     ":email" => "bbbb@gmail.com",
//     ":password" => "bbbb",
//     ":phone" => "09345678",
//     ":photo" => "bbbb.png",
//     ":address" => "latha",
//     ":created_date" => $now,
//     ":updated_date" => $now,
// ]);

// $statement->execute(['aaaa', 'aaaa@gmail.com', '2345678', '09345678', 'aa.jpg', 'ygn', $now, $now]);
// die();
// require
// require_once
// include
// include_once
?>
<div class="p-5 text-center">
    <?php if (isset($_GET['message'])) {
        echo $_GET['message'];
    } ?>
    <h1>Home Page welcome
        <?php
        if ($auth) {
            echo $_SESSION['name'];
        } else {
            echo "Guest";
        } ?>
    </h1>

    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat modi vitae aspernatur quidem esse! Cum culpa
        soluta libero, optio voluptates veritatis atque rerum a commodi consequuntur, minus tempora aliquam ipsa.
    </p>
</div>
<?php
require "./layouts/footer.php";
?>