<?php
ini_set('memory_limit', '256M');
require '../index.php';
require 'database.php';
$table_name = 'csv_import';
$db = connectdb($table_name);

$target_dir = 'tmp/';
$target_file = $target_dir . basename($_FILES['file']['tmp_name']);
$file = fopen(checkfile($target_file), 'r');

$header = fgetcsv($file);

$count = 0;
if ($file) {
    $values = [];
    while (($line = fgetcsv($file)) !== false) {
        $id = $db->escapeString($line[0]);
        $name = $db->escapeString($line[1]);
        $surname = $db->escapeString($line[2]);
        $initials = $db->escapeString($line[3]);
        $age = $db->escapeString($line[4]);
        $dateofbirth = $db->escapeString($line[5]);
        $values[] = "('$id', '$name', '$surname', '$initials', '$age', '$dateofbirth')";
        $count++;
    }
    $sql = "INSERT INTO csv_import (Id, Name, Surname, Initials, Age, DateOfBirth) VALUES " . implode(',', $values);
    $db->exec($sql);
} else {
    header("Location: /index.php?error=true");
}

//Close all
$db->close();
unlink($target_file);
rmdir("tmp/");
fclose($file);
$_SESSION['message'] = $count . ' records imported';
header("Location: /index.php");

function checkfile($targetfile)
{
    if (!file_exists("tmp/")) {
        mkdir("tmp/");
    }
    if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetfile)) {
        header('../index.php?importerror=true');
    }
    if (filesize($targetfile) <= 40) {
        header("Location: /index.php?emptyfile=true");
    }
    return $targetfile;
}
?>