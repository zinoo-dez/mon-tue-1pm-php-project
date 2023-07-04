<?php
require "../server/db.php";
require "../layouts/header.php";
$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE product_id=:id";
$s = $pdo->prepare($sql);
$s->bindParam(":id", $id, PDO::PARAM_INT);
$s->execute();
$p = $s->fetch();
// print_r($res['name']);
// die();

?>
<div class="w-50 mt-5 m-auto shadow p-5">
    <h3 class="text-center mb-3">Update Product</h3>
    <form action="product-update.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <input type="hidden" name="pid" value="<?php echo $p['product_id'] ?>">
            <select name="category_id" class="form-control">
                <option value="" disabled selected>Select Category Name</option>
                <?php
                $sql = "SELECT * FROM categories";
                $s = $pdo->prepare($sql);
                $s->execute();
                $res = $s->fetchAll(PDO::FETCH_ASSOC);
                foreach ($res as $key => $value) { ?>
                    <?php if ($value['category_id'] === $p['category_id']) : ?>
                        <option selected value="<?= $value['category_id'] ?>" class="form-control">
                            <?= $value['name'] ?></option>
                    <?php else : ?>
                    <?php endif ?>
                    <option value="<?= $value['category_id'] ?>" class="form-control">
                        <?= $value['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <input type="text" value="<?= $p['name'] ?? "" ?>" required placeholder="Product Name..." name="name" class="form-control">
        </div>
        <div class="mb-3">
            <textarea required name="description" value="" placeholder=" description ...." class="form-control">
                <?= $p['description'] ?? "" ?>
            </textarea>
        </div>
        <div class="mb-3">
            <input type="number" value="<?= $p['price'] ?? "" ?>" required placeholder="Product Price..." name="price" class="form-control">
        </div>
        <div class="mb-3">
        </div>
        <input hidden name="oldphoto" value="<?php echo $p['photo'] ?>"></input>
        <img src="../img/<?= $p['photo'] ?>" width="60" alt="photo">
        <div class="mb-3">
            <label for="photo">Photo</label><br>
            <input type="file" name="photo" accept="image/*" id="photo" class="form-control">
        </div>

        <input type="submit" class="btn btn-primary" name="product_update">
    </form>
</div>