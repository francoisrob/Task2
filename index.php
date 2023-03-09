<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 2</title>
</head>

<body>
    <h2>Generate CSV</h2>
    <form action="/php/generate.php" method="post">
        <label for="variations">Enter the number of variations: </label>
        <input type="number" name="variations" id="variations" required>
        <button type="submit">Submit</button>
        <?php
        if (isset($_GET['success'])) {
            echo "<p>CSV file generated successfully!</p>";
        }
        ;
        if (isset($_GET['invalid'])) {
            echo "<p>The number of variations have to be between 1 and 1,000,500!</p>";
        }
        ;
        ?>
    </form>
</body>

</html>