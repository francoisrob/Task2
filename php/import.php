<?php
require '../index.php';
require 'database.php';
$table_name = 'csv_import';
$db = connectdb($table_name);

$target_dir = 'tmp/';
$target_file = $target_dir . basename($_FILES['file']['tmp_name']);
$file = fopen(checkfile($target_file), 'r');
if ($file) {
    while (($line = fgets($file)) !== false) {
        //add to db
        $sql = $db->prepare("INSERT INTO csv_import (Name, Surname, Initials, Age, DateOfBirth) VALUES (:name, :surname, :initials, :age, :dateofbirth)");
        $sql->bindValue(':name', $line[0]);
        $sql->bindValue(':surname', $line[1]);
        $sql->bindValue(':initials', $line[2]);
        $sql->bindValue(':age', $line[3]);
        $sql->bindValue(':dateofbirth', $line[4]);
        $sql->execute();
    }
} else {
    header("Location: /index.php?error=true");
}

//Close all
$db->close();
unlink($target_file);
rmdir("tmp/");
fclose($file);
header("Location: /index.php?importsuccess=true");

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