<?php

require_once 'SimpleQuery.php';

$sq = new SimpleQuery('localhost', 'crud', 'root', '');

$sq->connect();

// select all
//$rs = $sq->getAll('m_user');

// get by id
$rs = $sq->getAllByParams('m_user',
		array(
			'is_active' => array(1, '=')
		)
	);

print_r($rs);