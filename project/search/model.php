<?php

function getUserData($params){
	//DBの接続情報
	include_once('../env.php');

	//DBコネクタを生成
    $host = DB_HOST;
    $db = DB_NAME;
    $user = DB_USER;
    $pass = DB_PASS;

	$Mysqli = new mysqli($host, $user, $pass, $db);
	if ($Mysqli->connect_error) {
			error_log($Mysqli->connect_error);
			exit;
	}

	//入力された検索条件からSQl文を生成
	$where = [];
	if(!empty($params['name'])){
		$where[] = "name like '%{$params['name']}%'";
	}
	if(!empty($params['sex'])){
		$where[] = 'sex = ' . $params['sex'];
	}
	if(!empty($params['age'])){
		$where[] = 'age <= ' . ((int)$params['age'] + 9) . ' AND age >= ' . (int)$params['age'];
	}
	if($where){
		$whereSql = implode(' AND ', $where);
		$sql = 'select * from users where ' . $whereSql ;
	}else{
		$sql = 'select * from users';
	}
	
	//SQL文を実行する
	$UserDataSet = $Mysqli->query($sql);

	//扱いやすい形に変える
	$result = [];
	while($row = $UserDataSet->fetch_assoc()){
		$result[] = $row;
	}
	return $result;
}