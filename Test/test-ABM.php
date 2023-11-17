<?php
include_once("../Config/config.php");
new Header("Test Page", $DIRS, null);

$abm = new ABMUsuario();
$prueba = $abm->LoadObjectId(['idusuario' => 2]);
$prueba2 = $abm->Search();

function showObject($object)
{
    $methods = get_class_methods($object);
    $blockText = "";
    foreach ($methods as $mets) {
        if (mb_substr($mets, 0, 3) == "get" && mb_substr($mets, 3, 3) != "Obj") {
            $blockText .= " " . $object->$mets();
        }
    }
    return $blockText . "<br>";
}

function iteratorObject($array)
{
    $text = "";
    if ($array != array() && !is_object($array)) {
        if ("object" == gettype($array[0])) {
            foreach ($array as $object) {
                $text .= showObject($object);
            }
        }
    } else if(is_object($array)){
        $text .= showObject($array);
    } else {
        $text = "null";
    }
    return $text;
}

$showObject = fn ($object) => iteratorObject($object);

echo <<< HTML

<h1>Este es prueba LoadObject</h1>{$showObject($prueba)}
<h1>Este es prueba Search</h1>{$showObject($prueba2)}

HTML;
