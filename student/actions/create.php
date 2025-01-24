
<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $class = $_POST['class'];
    $age = $_POST['age'];

    $stmt = $pdo->prepare("INSERT INTO students (name, class, age) VALUES (:name, :class, :age)");
    $stmt->execute([':name' => $name, ':class' => $class, ':age' => $age]);

    header("Location: ../index.php"); 
    exit();
}
?>
