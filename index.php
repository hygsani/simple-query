<?php

require_once 'SimpleQuery.php';

$sq = new SimpleQuery('localhost', 'crud', 'root', '');

$sq->connect();

// select all
$rs = $sq->getAll('m_user');

// get one record by id
$rs = $sq->getOneById('m_user', array('user_id' => 1));
$rs = $sq->getOneById('m_user', 1);

// get first record
$rs = $sq->getFirst('m_user', 'user_id');

// get last record
$rs = $sq->getLast('m_user', 'user_id');


// get by id
$rs = $sq->getAllByParams('m_user',
		array(
			'name' => array('jo', 'like', 'and'),
			'is_active' => array(0, '=')
		)
	);