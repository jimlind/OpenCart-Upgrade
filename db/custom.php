<?php

$create = "DROP TABLE IF EXISTS `v155_compulsion_data_product`;
CREATE TABLE IF NOT EXISTS `v155_compulsion_data_product` (
	`product_id` int(11) NOT NULL,
	`name` varchar(32) NOT NULL,
	`type` varchar(32) NOT NULL,
	`value` varchar(255) NOT NULL,
	PRIMARY KEY (`product_id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$pdo->query($create);

$data = array();

$rows = $pdo->query('SELECT * FROM `product`');
foreach($rows as $row) {
	if ($row['cost']) {
		$data[] = array(
			'id' => $row['product_id'],
			'name' => 'cost',
			'type' => 'decimal',
			'value' => $row['cost'],
		);
	}
}

$rows = $pdo->query('SELECT * FROM `product_notes`');
foreach($rows as $row) {
	$data[] = array(
		'id' => $row['product_id'],
		'name' => 'notes',
		'type' => 'textarea',
		'value' => $row['note'],
	);
}

foreach ($data as $data) {
	$sql  = "INSERT INTO v155_compulsion_data_product (product_id,name,type,value)";
	$sql .= "VALUES (:product_id,:name,:type,:value)";
	$q = $pdo->prepare($sql);
	$q->execute(array(
		':product_id' => $data['id'],
		':name' => $data['name'],
		':type' => $data['type'],
		':value' => $data['value'],
	));
}

echo 'Custom Product Data Rows Done.';
echo '<br />';