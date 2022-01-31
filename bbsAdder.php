<?php

//db settings
$host = '127.0.0.1';
$dbName = 'laravel';
$dbUser = 'laravel_user';
$pass = '0000'; //не забудь поменять пароль!!!
$charset = 'utf8';

//db request settings
$table = 'bbs';
$numAddRows = 2; //количество добавляемых строк(кортежей)
$prepareItemID = 0; //ID номер подготавлеваемого кортежа

//component parts of the request
$titleBegin = "Название товара № ";
$contentBegin = "Описание Товара № ";
$contentEnd = ": О-о-о-о-о-очень много слов";
$priceStart = 1000;
$user_id = 4;	//от имени какого пользователя будет добавлен кортеж

try
{
    $pdo = new pdo("mysql:host=$host; dbname=$dbName; charset=$charset", $dbUser, $pass);

    //next item ID
    $objTableStatus = $pdo->query('SELECT MAX(id) FROM bbs');
    $arrTableStatus = $objTableStatus->fetchAll(PDO::FETCH_ASSOC);
    $prepareItemID = $arrTableStatus[0]["MAX(id)"] + 1;
    
    //пишем кортежи в DB
    for ($i = 0; $i < $numAddRows; $i++)
    {
        $title = $titleBegin . $prepareItemID;
        $content = $contentBegin . $prepareItemID . $contentEnd;
        $price = $priceStart + $prepareItemID; //чтобы цена отличалась
        $createTime = date('Y-m-d H:i:s');

    	$pdo->query
        (
            "INSERT INTO $table(title, content, price, user_id, created_at, updated_at)
            VALUES('{$title}', '{$content}', $price, $user_id, '{$createTime}', '{$createTime}')"
        );
    	$prepareItemID++;
    }
}


catch( PDOException $Exception ) {
    exit('PDO error: ' . $Exception->getMessage() . "\n");
}

echo "well done!\n";

?>