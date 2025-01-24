
<?php
require_once 'config/db.php';

$stmt = $pdo->query("SELECT * FROM students");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Student Management System</h1>

    <form action="actions/create.php" method="POST">
        <h2>Create Student</h2>
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Class:</label>
        <input type="text" name="class" required>
        <label>Age:</label>
        <input type="number" name="age" required>
        <button type="submit">Add Student</button>
    </form>

    <form action="actions/update.php" method="POST">
        <h2>Update Student</h2>
        <label>ID:</label>
        <input type="number" name="id" required>
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Class:</label>
        <input type="text" name="class" required>
        <label>Age:</label>
        <input type="number" name="age" required>
        <button type="submit">Update Student</button>
    </form>

    <form action="actions/delete.php" method="POST">
        <h2>Delete Student</h2>
        <label>ID:</label>
        <input type="number" name="id" required>
        <button type="submit">Delete Student</button>
    </form>

    <h2>Students List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Class</th>
                <th>Age</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student['id']) ?></td>
                    <td><?= htmlspecialchars($student['name']) ?></td>
                    <td><?= htmlspecialchars($student['class']) ?></td>
                    <td><?= htmlspecialchars($student['age']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

