<?php
require "../server/db.php";
require "../layouts/header.php";
$errors = [];
if (isset($_POST['product_update'])) {
    $name = trim($_POST['name']);
    $product_id = $_POST['pid'];
    $category_id = $_POST['category_id'];
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $oldphoto = $_POST['oldphoto'];
    $photo = $_FILES['photo'];
    $pname = $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];
    if ($pname != "") {
        move_uploaded_file($tmp_name, "../img/$pname");
    } else {
        $pname = $oldphoto;
    }

    empty($name) ? $errors[] = "product name required" : "";
    empty($category_id) ? $errors[] = "category  required" : "";
    empty($price) ? $errors[] = "product price required" : "";
    empty($description) ? $errors[] = "product description required" : "";
    empty($pname) ? $errors[] = "product photo required" : "";
    if (count($errors) === 0) {

        $sql = "UPDATE products SET product_id=:product_id,category_id=:category_id,name=:name,description=:description,price=:price,photo=:photo WHERE product_id=:product_id";
        $s = $pdo->prepare($sql);
        $s->bindParam(":product_id", $product_id, PDO::PARAM_STR);
        $s->bindParam(":name", $name, PDO::PARAM_STR);
        $s->bindParam(":category_id", $category_id, PDO::PARAM_STR);
        $s->bindParam(":description", $description, PDO::PARAM_STR);
        $s->bindParam(":price", $price, PDO::PARAM_STR);
        $s->bindParam(":photo", $pname, PDO::PARAM_STR);
        $res = $s->execute();
        if ($res) {
            header("location:dashboard.php?#products");
        }
    }
}
