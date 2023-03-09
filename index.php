<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 2</title>
</head>

<body>
    <div>
        <h2>Generate CSV</h2>
        <form action="/php/generate.php" method="post">
            <label for="variations">Enter the number of variations: </label>
            <input type="number" name="variations" id="variations" required><br>
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
    </div>
    <div>
        <h2>Import CSV</h2>
        <form action="/php/import.php" method="post" enctype="multipart/form-data">
            <label for="file">Select a CSV file: </label>
            <input type="file" name="file" id="file" accept=".csv" required><br>
            <button type="submit">Submit file</button>
            <?php
            if (isset($_GET['importsuccess'])) {
                echo "<p>CSV file imported successfully!</p>";
            }
            if (isset($_GET['importerror'])) {
                echo "<p>*There was an error uploading your file!</p>";
            }
            if (isset($_GET['emptyfile'])) {
                echo "<p>*The file is empty!</p>";
            }
            ?>
        </form>

    </div>
</body>

</html>