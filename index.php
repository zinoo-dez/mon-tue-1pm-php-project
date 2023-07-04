<?php
// print_r($_SERVER);
// die();
session_start();
$auth = isset($_SESSION['name']);
require "server/db.php";
require "./layouts/header.php";
require "./layouts/navbar.php";
require "./layouts/carousel.php";
// get product query
if (isset($_POST['submit'])) {
    $keyword = $_POST['search'];
    $sql = "SELECT * FROM products WHERE name LIKE :keyword;";
    $s = $pdo->prepare($sql);
    $s->bindParam(":keyword", $keyword, PDO::PARAM_STR);
    $s->execute();
    $res = $s->fetchAll(PDO::FETCH_ASSOC);
} else {

    $sql = "SELECT * FROM products";
    $s = $pdo->prepare($sql);
    $s->execute();
    $res = $s->fetchAll(PDO::FETCH_ASSOC);
}
// print_r($res);
// die();

?>
<div class="p-5 text-center">
    <h2>Products List</h2>
    <div class="row">
        <?php foreach ($res as $key => $value) : ?>
            <div class="col-sm-12 col-md-4 col-lg-3">
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                        <img src="./img/<?= $value['photo'] ?>" style="height:220px; object-fit:cover;" class="img-fluid" />
                        <a href="#!">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </a>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= $value['name'] ?></h5>

                        <a href="product-details.php?id=<?= $value['product_id'] ?>" class="btn btn-primary">Details</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

    </div>

</div>
<?php
require "./layouts/footer.php";
?>