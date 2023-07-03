<?php
require "../server/db.php";
function delete($tbname, $tbid, $id)
{
    global $pdo;
    $sql = "DELETE from $tbname WHERE $tbid=:id";
    $s = $pdo->prepare($sql);
    $s->bindParam(":id", $id, PDO::PARAM_INT);
    $s->execute();
}
delete("users", "user_id", 6);
