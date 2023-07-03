<?php
require "../server/db.php";
require "../layouts/header.php";
// require "../layouts/navbar.php";
$errors = [];
$sql = "SELECT * FROM users";
$statement = $pdo->prepare($sql);
$statement->execute();
$allusers = $statement->fetchAll(PDO::FETCH_ASSOC);
// print_r($allusers);
// die();
// create category
if (isset($_POST['cat_submit'])) {
    $name = $_POST['name'];
    empty($name) ? $errors[] = "name required" : "";
    if (count($errors) === 0) {
        $name_check = "SELECT * FROM categories WHERE name = :name";
        $s = $pdo->prepare($name_check);
        $s->bindParam(":name", $name, PDO::PARAM_STR);
        $s->execute();
        $res = $s->fetch();
        // print_r($res);
        // die();
        if (isset($res)) {
            if ($name === $res['name']) {
                $errors[] = "category name already exist";
            } else {
                $sql = "INSERT INTO categories (name) VALUES (:name)";
                $statement = $pdo->prepare($sql);
                $statement->bindParam(":name", $name, PDO::PARAM_STR);

                $res =  $statement->execute();
                if ($res) {
                    header("location:dashboard.php");
                } else {
                    $errors[] = "Insert Error Found";
                }
            }
        }
    }
}
$category_sql = "INSERT INTO categories () VALUES ()";
// caterory insert end
// create product start
if (isset($_POST['product_submit'])) {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $photo = $_FILES['photo'];
    $pname = time() . $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];
    move_uploaded_file($tmp_name, "../img/$pname");
    empty($name) ? $errors[] = "product name required" : "";
    empty($category_id) ? $errors[] = "category  required" : "";
    empty($price) ? $errors[] = "product price required" : "";
    empty($description) ? $errors[] = "product description required" : "";
    empty($pname) ? $errors[] = "product photo required" : "";
    if (count($errors) === 0) {
        $sql = "INSERT INTO products (name,category_id,description,price,photo) VALUES (:name,:category_id,:description,:price,:photo)";
        $s = $pdo->prepare($sql);
        $s->bindParam(":name", $name, PDO::PARAM_STR);
        $s->bindParam(":category_id", $category_id, PDO::PARAM_STR);
        $s->bindParam(":description", $description, PDO::PARAM_STR);
        $s->bindParam(":price", $price, PDO::PARAM_STR);
        $s->bindParam(":photo", $pname, PDO::PARAM_STR);
        $res = $s->execute();
        if ($res) {
            header("location:dashboard.php");
        }
    }
}
// create product end
// del function

?>
<div class="row m-0">
    <div class="col-3  text-center py-3">
        <h3 class="my-3">Admin Dashboard</h3>
        <!-- <hr> -->
        <ul>
            <li class="p-2"><a href="#users">Users</a></li>
            <li class="p-2"><a href="#categories">Categories</a></li>
            <li class="p-2"><a href="#products">Products</a></li>
            <li class="p-2"><a href="">Services</a></li>
            <li class="p-2"><a href="">Roles</a></li>
        </ul>
    </div>
    <div class="col-9">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light py-3">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                    data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Left links -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Projects</a>
                        </li>
                    </ul>
                    <!-- Left links -->
                </div>
                <!-- Collapsible wrapper -->

                <!-- Right elements -->
                <div class="d-flex align-items-center">
                    <!-- Icon -->
                    <a class="text-reset me-3" href="#">
                        <i class="fas fa-shopping-cart"></i>
                    </a>

                    <!-- Notifications -->
                    <div class="dropdown">
                        <a class="text-reset me-3 dropdown-toggle hidden-arrow" href="#" id="navbarDropdownMenuLink"
                            role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="badge rounded-pill badge-notification bg-danger">1</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li>
                                <a class="dropdown-item" href="#">Some news</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Another news</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </li>
                        </ul>
                    </div>
                    <!-- Avatar -->
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#"
                            id="navbarDropdownMenuAvatar" role="button" data-mdb-toggle="dropdown"
                            aria-expanded="false">
                            <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle"
                                height="25" alt="Black and White Portrait of a Man" loading="lazy" />
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                            <li>
                                <a class="dropdown-item" href="#">My profile</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Settings</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Right elements -->
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
        <!-- main -->
        <main>
            <?php include "../error.php" ?>
            <!-- users section -->
            <section id="users" class="p-4">
                <h3>All Users</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-hover responsive">
                        <thead>
                            <tr class="table-info ">
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Address</th>
                                <th scope="col" class="text-center" colspan="2">Status</th>
                            </tr>
                        </thead>
                        <?php
                        $record_per_page = 5;
                        $page = '';
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }
                        $start_page = ($page - 1) * $record_per_page;
                        $user_qry = "SELECT * FROM users LIMIT :start_page,:record_per_page";
                        $s = $pdo->prepare($user_qry);
                        $s->bindParam(":start_page", $start_page, PDO::PARAM_INT);
                        $s->bindParam(":record_per_page", $record_per_page, PDO::PARAM_INT);
                        $s->execute();
                        $allusers = $s->fetchAll(PDO::FETCH_ASSOC);

                        ?>
                        <tbody>

                            <?php foreach ($allusers as $key => $user) : ?>
                            <tr class="table-primary ">
                                <!-- <th scope="row"><?php echo ++$key ?></th> -->
                                <th scope="row"><?php echo $user['user_id'] ?></th>
                                <th scope="row"><?php echo $user['name'] ?></th>
                                <th scope="row"><?php echo $user['email'] ?></th>
                                <th scope="row"><?php echo $user['address'] ?></th>
                                <th class="d-flex items-center justify-content-evenly">
                                    <a href="user-edit.php?id=<?= $user['user_id'] ?>"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <a href="delete.php?id=<?= $user['user_id'] ?>&tbname=users&tbid=user_id"
                                        class="btn btn-sm btn-danger" onclick="alert('are you sure?')">Delete</a>
                                </th>
                            </tr>
                            <?php endforeach ?>

                        </tbody>
                    </table>
                    <div class="pagination m-auto " style="width: fit-content;">
                        <?php
                        $page_qry = "SELECT * FROM users ORDER BY user_id DESC";
                        $page_res = $pdo->prepare($page_qry);
                        $page_res->execute();
                        $total_records = $page_res->rowCount();
                        // print_r($total_records);
                        // die();
                        $total_pages = ceil($total_records / $record_per_page);
                        for ($i = 1; $i < $total_pages; $i++) {
                            echo "<a class='px-3 py-1 border text-center mx-2' href='dashboard.php?page=" . $i . "' >" . $i . "</a>";
                        }
                        ?>
                    </div>
                </div>
            </section>
            <!-- users section end -->
            <!-- categories -->
            <section id="categories" class="my-5">
                <h2 class="text-center mb-4">Categories</h2>
                <div class="row">
                    <div class="col-4  shadow p-3">
                        <h3 class="text-center">Create Category</h3>
                        <form action="dashboard.php" method="post">
                            <div class="mb-3">
                                <input type="text" required placeholder="Category Name..." name="name"
                                    class="form-control mb-3">
                                <input type="submit" class="btn btn-primary" name="cat_submit">
                            </div>
                        </form>
                    </div>
                    <div class="col-8">
                        <h3 class="text-center">Categories List</h3>
                        <table class="table table-striped table-hover ">
                            <thead>

                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM categories";
                                $s = $pdo->prepare($sql);
                                $s->execute();
                                $res = $s->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($res as $key => $value) { ?>
                                <tr>
                                    <td scope="row"><?= ++$key ?></td>
                                    <td scope="row"><?= $value['name'] ?></td>
                                    <td class="">
                                        <a href="category-edit.php?id=<?= $value['category_id'] ?>"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <a href="delete.php?id=<?= $value['category_id'] ?>&tbname=categories&tbid=category_id"
                                            class="btn btn-sm btn-danger" onclick="alert('are you sure?')"
                                            class="btn btn-sm btn-danger">Delete</a>

                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </section>
            <!-- categories end -->
            <!-- products  -->
            <section id="products" class="my-5">
                <h2 class="text-center mb-4">Products</h2>
                <div class="row">
                    <div class="col-4 shadow p-3">
                        <h3 class="text-center mb-3">Create Product</h3>
                        <form action="dashboard.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <select name="category_id" class="form-control">
                                    <option value="" disabled selected>Select Category Name</option>
                                    <?php
                                    $sql = "SELECT * FROM categories";
                                    $s = $pdo->prepare($sql);
                                    $s->execute();
                                    $res = $s->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($res as $key => $value) { ?>
                                    <option value="<?= $value['category_id'] ?>" class="form-control">
                                        <?= $value['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="text" required placeholder="Product Name..." name="name"
                                    class="form-control">
                            </div>
                            <div class="mb-3">
                                <textarea required name="description" placeholder=" description ...."
                                    class="form-control"></textarea>
                            </div>
                            <div class="mb-3">
                                <input type="number" required placeholder="Product Price..." name="price"
                                    class="form-control">
                            </div>
                            <div class="mb-3">
                            </div>
                            <input type="file" required name="photo" class="form-control">

                            <input type="submit" class="btn btn-primary" name="product_submit">
                        </form>
                    </div>
                    <div class="col-8">
                        <h3 class="text-center">Categories List</h3>
                        <table class="table table-striped table-hover ">
                            <thead>

                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Photo</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM products";
                                $s = $pdo->prepare($sql);
                                $s->execute();
                                $res = $s->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($res as $key => $value) { ?>
                                <tr>
                                    <td scope="row"><?= ++$key ?></td>
                                    <td scope="row"><img width="50" src="../img/<?= $value['photo'] ?>" alt="photo">
                                    </td>
                                    <td scope="row"><?= $value['name'] ?></td>
                                    <td scope="row"><?= $value['price'] ?></td>
                                    <td class="">
                                        <a href="product-edit.php?id=<?= $value['product_id'] ?>"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <a href="delete.php?id=<?= $value['product_id'] ?>&tbname=products&tbid=product_id"
                                            class="btn btn-sm btn-danger" onclick="alert('are you sure?')"
                                            class="btn btn-sm btn-danger">Delete</a>

                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </section>
            <!-- products end -->
        </main>
        <!-- main -->
    </div>
</div>
<?php
require "../layouts/footer.php"
?>