<?php
$tricks = [];

for ($i = 0; $i <10 ; $i++) {
    $tricks[] =  array(
        "id" => $i,
        "name" => "Tricks name",
        "image" => "img/grab.jpg"
    );
}
header('Content-Type: application/json');
echo json_encode($tricks);
