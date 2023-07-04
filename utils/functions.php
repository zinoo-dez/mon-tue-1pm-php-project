<?php
// require "../server/db.php";
function search_qry($id)
{
    global $pdo;
    $sql = "SELECT * FROM products WHERE category_id=:id";
    $s = $pdo->prepare($sql);
    $s->bindParam(":id", $id, PDO::PARAM_INT);
    $s->execute();
    $res = $s->fetchAll(PDO::FETCH_ASSOC);
    // return $res;
}
// search_qry(2);