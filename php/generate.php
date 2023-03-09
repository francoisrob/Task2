<?php
$variations = $_POST['variations'];
if ($variations > 1000500) {
    header("Location: /index.php?invalid=true");
    exit();
}
$today = new DateTime(date('Y-m-d'));
$names = array(
    "Bianca",
    "Jacques",
    "Francois",
    "Vance",
    "Pranav",
    "Thomas",
    "Carl",
    "Nico",
    "Luis",
    "Sean",
    "Sasha Cohen",
    "Erica",
    "Megan",
    "Katya",
    "Annalette",
    "Phillip",
    "Ricus",
    "Jowan",
    "Amiel",
    "Genise"
);
$surnames = array(
    "Robbertze",
    "Harmon",
    "Bolton",
    "Guerrero",
    "Quinn",
    "Hubbard",
    "Moore",
    "Mahoney",
    "Abbott",
    "Spears",
    "Pierce",
    "Hood",
    "Cline",
    "Henderson",
    "Barnard",
    "Jensen",
    "Kirk",
    "Huynh",
    "Acosta",
    "Mcclain"
);

if (file_exists("../output")) {
    $file = fopen("../output/output.csv", "w");
} else {
    mkdir("../output");
    $file = fopen("../output/output.csv", "w");
}
//Header
fputcsv($file, [
    "Id",
    "Name",
    "Surname",
    "Initials",
    "Age",
    "DateOfBirth"
]);


$data = [];
$iCount = 0;
while ($iCount < $variations) {
    $name = $names[array_rand($names)];
    $surname = $surnames[array_rand($surnames)];
    $dob = date("Y-m-d", rand(strtotime("01-01-1940"), strtotime("01-01-2005")));
    $age = calculateage($dob, $today);
    $hash = $name . $surname . $age . $dob;

    if (!isset($data[$hash])) {
        $iCount++;
        $data[$hash] = true;
        $id = $iCount;
        $initials = getinitials($name);
        fputcsv($file, [$id, $name, $surname, $initials, $age, $dob]);
        header("Location: /index.php?success=true");
    }
}

function getinitials($name)
{
    $initials = "";
    $name = explode(" ", $name);
    foreach ($name as $n) {
        $initials .= $n[0];
    }
    return $initials;
}

function calculateage($dob, $today)
{
    // Calculate age
    $bday = new DateTime($dob);
    return $today->diff($bday)->y;
}
?>