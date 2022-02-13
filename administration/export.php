<?php 
$fr = $_POST["fr"];
$ar = $_POST["ar"];
$eng = $_POST["eng"];

$frN = sizeof($fr);
$arN = sizeof($ar);
$engN = sizeof($eng);
echo "fr : ";
echo "\n";
for($i=0;$i<$frN;$i++){
    echo $fr[$i].",";
    echo "\n";
}
echo "ar : ";
echo "\n";
for($i=0;$i<$arN;$i++){
    echo $ar[$i].",";
    echo "\n";
}
echo "fr : ";
echo "\n";
for($i=0;$i<$engN;$i++){
    echo $eng[$i] .",";
    echo "\n";
}

?>