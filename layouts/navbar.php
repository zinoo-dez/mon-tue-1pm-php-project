<?php
require "./server/db.php";
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">A-Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="project.php">Projects</a>
                </li>

                <div class="dropdown">
                    <a class=" nav-link" href="#" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">Categories</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <?php
                        $sql = "SELECT * FROM categories";
                        $s = $pdo->prepare($sql);
                        $s->execute();
                        $res = $s->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($res as $key => $value) { ?>
                            <li>
                                <a class="dropdown-item" href="index.php?cid=<?= $value['category_id'] ?>"><?= $value['name'] ?></a>
                            </li>
                        <?php } ?>

                    </ul>
                </div>


                <?php
                $auth = isset($_SESSION['name']);
                if ($auth) : ?>
                    <?php if ($_SESSION['name'] === "Admin") : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/dashboard.php"><?= $_SESSION['name'] ?></a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php"><?= $_SESSION['name'] ?></a>
                        </li>
                    <?php endif ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php endif ?>
            </ul>
            <form class="d-flex" action="index.php" method="post" role="search">
                <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" name="submit" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>