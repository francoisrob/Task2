<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/main.css">
    <title>Task 2</title>
</head>

<body>
    <?php
    session_start()
        ?>
    <div>
        <form action="/php/generate.php" method="post">
            <h2>Generate CSV</h2>
            <label for="variations">Enter the number of variations: </label>
            <input type="number" name="variations" id="variations" required><br>
            <button type="submit">Submit</button>
            <?php
            if (isset($_SESSION['messagegen'])) {
                echo $_SESSION['messagegen'];
                unset($_SESSION['messagegen']);
            }
            ?>
        </form>
    </div>
    <div>
        <form action="/php/import.php" method="post" enctype="multipart/form-data">
            <h2>Import CSV</h2>
            <label for="file">Select a CSV file: </label>
            <input type="file" name="file" id="file" accept=".csv" required><br>
            <button type="submit">Submit file</button>
            <?php
            if (isset($_SESSION['messageimport'])) {
                echo $_SESSION['messageimport'];
                unset($_SESSION['messageimport']);
            }
            ?>
        </form>

    </div>
</body>

</html>