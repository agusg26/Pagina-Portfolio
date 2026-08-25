<?php
require_once "connect.php";
if (!empty(isset($_GET['id']))) {
    $id = $_GET['id'];
    $sql = "UPDATE materias SET activo=0 WHERE materias_id=$id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    header("location:index.php");
}
