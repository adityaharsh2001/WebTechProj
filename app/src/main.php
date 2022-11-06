<!-- connect to mongo db  -->

<?php
$mongo = new MongoClient();
$db = $mongo->selectDB('test');
$collection = $db->selectCollection('test');
$collection->insert(array('name' => 'test'));

// use router/

require_once __DIR__ . '/src/complier.php';
?>
