
<!DOCTYPE html>
<html>
<head>
    <title>Multiplication Table Generator</title>
    <style>
        table {
            border-collapse: collapse;
            margin-top: 20px;
        }
        td {
            border: 1px solid black;
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <h2>Multiplication Table Generator</h2>
    <form method="POST">
        Enter a number: <input type="number" name="number" required>
        <input type="submit" value="Generate Table">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $number = $_POST["number"];
        
        if (!empty($number)) {
            echo "<h3>Multiplication Table for $number</h3>";
            echo "<table>";
            for ($i = 1; $i <= 10; $i++) {
                echo "<tr>";
                echo "<td>$number x $i</td>";
                echo "<td>" . ($number * $i) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    ?>
</body>
</html>

