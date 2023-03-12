<?php
ini_set('memory_limit', '256M');
session_start();
$start = hrtime(true);
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
    $_SESSION['messageimport'] = '<p type="error">*File could not be opened.</p>';
    header("Location: /index.php");
}

//Close all
$db->close();
unlink($target_file);
rmdir("tmp/");
fclose($file);
$end = hrtime(true);
$duration = ($end - $start) / 1e+9;
$_SESSION['messageimport'] = '<p>' . number_format($count) . ' records imported in ' . number_format($duration, 2) . ' seconds! </p>';
header("Location: /index.php");

function checkfile($targetfile)
{
    if (mime_content_type($_FILES['file']['tmp_name']) != 'text/csv') {
        $_SESSION['messageimport'] = '<p type="error">File is not a CSV filetype.</p>';
        header("Location: /index.php");
        exit();
    }
    if (!file_exists("tmp/")) {
        mkdir("tmp/");
    }
    if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetfile)) {
        $_SESSION['messageimport'] = '<p type="error">File could not be uploaded.</p>';
        header('../index.php');
        exit();
    }
    if (filesize($targetfile) <= 40) {
        $_SESSION['messageimport'] = '<p type="error">File is empty.</p>';
        header("Location: /index.php");
        exit();
    }
    return $targetfile;
}
?>