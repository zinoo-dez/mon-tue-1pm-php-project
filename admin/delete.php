<?php
require "../server/db.php";
$id = $_GET['id'];
$tbname = $_GET['tbname'];
$tbid = $_GET['tbid'];

// echo "$id=>$tbname=>$tbid";
function delete($tbname, $tbid, $id)
{
    global $pdo;
    $sql = "DELETE from $tbname WHERE $tbid=:id";
    $s = $pdo->prepare($sql);
    $s->bindParam(":id", $id, PDO::PARAM_INT);
    $res = $s->execute();
    if ($res) {
        header("location:dashboard.php");
    }
}
$res = delete($tbname, $tbid, $id);
