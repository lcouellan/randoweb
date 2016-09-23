<?php
require("dbInfo.php");
define('SERVER', "mysql.info.unicaen.fr");
define('USER', "21201323");
define('PASSWD', "kipheepahtaishod");
define('DB_NAME', "21201323_7");
define('PORT', "3306");
define('PDO_DSN', "mysql:host=" . SERVER . ";port=" . PORT . ";dbname=" . DB_NAME . ";charset=utf8");

// Start XML file, create parent node
$domtree = new DOMDocument('1.0', 'UTF-8');
$markers = $domtree->createElement("markers");
$markers = $domtree->appendChild($markers);
$options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
// Opens a connexion to a mySQL server
$connexion = new PDO(PDO_DSN, USER, PASSWD, $options);
// Select all the rows in the markers table

$sth = $connexion->prepare("SELECT * FROM markers");
$sth->execute();
$liste = $sth->fetchAll();
foreach ($liste as $element) {
  $marker = $domtree->createElement("marker");
  $name = $domtree->createAttribute('name');
  $name->value = $element['name'];
  $marker->appendChild($name);
  $lat = $domtree->createAttribute('lat');
  $lat->value = $element['lat'];
  $marker->appendChild($lat);
  $lng = $domtree->createAttribute('lng');
  $lng->value = $element['lng'];
  $marker->appendChild($lng);
  $markers->appendChild($marker);
}
header("Content-type: text/xml");
echo $domtree->saveXML();
?>