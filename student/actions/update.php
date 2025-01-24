
<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $class = $_POST['class'];
    $age = $_POST['age'];

    $stmt = $pdo->prepare("UPDATE students SET name = :name, class = :class, age = :age WHERE id = :id");
    $stmt->execute([':id' => $id, ':name' => $name, ':class' => $class, ':age' => $age]);

    header("Location: ../index.php"); 
    exit();
}
?>
