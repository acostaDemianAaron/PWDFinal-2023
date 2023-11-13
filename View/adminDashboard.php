<?php
include_once("../Config/config.php");
// TODO header call
new Header("Dashboard", $DIRS, 1);

// TODO Blocks can be changed to a table to show data by rows and columns

echo <<<HTML

<h1>Example of Admin headbar</h1>

HTML;

// TODO footer call