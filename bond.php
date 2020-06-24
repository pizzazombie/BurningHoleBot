<?php
function make_user($name,$chat_id){
	global $db;
	//$name = mysqli_real_escape_string($name);
	//$chat_id = mysqli_real_escape_string($chat_id);
	$query = "insert into `bond`(name,chat_id) values('{$name}','{$chat_id}')";
	mysqli_query($db, $query) or die("пользователя создать не удалось");
}

function is_user_set($name){
	global $db;
	$name = mysqli_real_escape_string($name);
	$result = mysqli_query($db, "select * from `bond` where name='$name' LIMIT 1");

    if(mysqli_fetch_array($result) !== false) return true;
    return false;
}

function set_udata($name,$data = array()){
	global $db;
	$name = mysqli_real_escape_string($name);
	if(!is_user_set($name)){
		make_user($name,0); // если каким-то чудом этот пользователь не зарегистрирован в базе
    };
    
    $text = $data["message"];
    $arr = explode(":", $text);
    $text = $arr[1];
    $data = json_encode($data,JSON_UNESCAPED_UNICODE);
    
   // mysqli_query($db, "update `bond` SET data_json = '{$data}' WHERE name = '{$name}'"); // обновляем запись в базе
    mysqli_query($db, "update `bond` SET text = '{$text}' WHERE name = '{$name}'");
    //mysqli_query($db, "update `bond` SET data_json = '{$data}' WHERE text = '{$name}'");
}

// считываение настройки
function get_udata($name){
	global $db;
	$res = array();
	$name = mysqli_real_escape_string($name);
	$result = mysqli_query($db, "select * from `bond` where used='$name'");
	$arr = mysqli_fetch_assoc($result);
    if(isset($arr['data_json'])){
		$res = json_decode($arr['data_json'], true);
	}
	
	return $res;
}

function set_bond($name,$data = array()){
    global $db;
    $name = mysqli_real_escape_string($name);
    $text = $data["message"];
    $arr = explode(":", $text);
    $text = $arr[1];
    if ($text != "" && $text != ' ')
        mysqli_query($db, "insert into `bond` (text, name) value ('$text', '$name')");
    else
        return 'нельзя отправлять пустую фразу';
    $res = 'Фраза добавлена в список!';
    return $res;
    //mysqli_query($db, "update `bond` SET data_json = '{$data}' WHERE text = '{$name}'");
}

function get_bond($name){
	global $db;
	$res = array();
	$name = mysqli_real_escape_string($name);
    $result = mysqli_query($db, "select * from `bond` where used=0 ORDER BY rand() LIMIT 1");
    //если все фразы уже использованы то выбери рандомную из всех когда-либо использованных
    if (mysqli_num_rows($result) == 0){
        $result = mysqli_query($db, "select * from `bond` where used=1 ORDER BY rand() LIMIT 1");
        //return 'не работает';
    }
	$arr = mysqli_fetch_assoc($result);
    $res = $arr['text'];
    
    mysqli_query($db, "update `bond` SET used = 1 WHERE text='$res'");
    return $res;
}