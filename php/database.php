<?php
function connectdb($table_name)
{
    //Create new database object.
    if (!file_exists('../db/')) {
        mkdir('../db/');
    }
    $db = new SQLite3('../db/db.sqlite');
    //Drop table if exists.
    $sql = ('DROP TABLE IF EXISTS csv_import');
    $db->exec($sql);

    $columns = [
        'Id INTEGER PRIMARY KEY',
        'Name TEXT',
        'Surname TEXT',
        'Initials TEXT',
        'Age INTEGER',
        'DateOfBirth TEXT'
    ];
    //Create table.
    $sql = 'CREATE TABLE csv_import (' . implode(',', $columns) . ')';
    $db->exec($sql);
    return $db;
}
?>