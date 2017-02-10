<?php
require('../vendor/autoload.php');
Flight::set('pathToDb', '../db/autoBase.db');
Flight::set('flight.views.path', '../views/');
Flight::set('baseTable', 'base');
Flight::register('db', 'PDO', ['sqlite:'.Flight::get('pathToDb')], function ($db) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
});
Flight::set(
    'createTable',
    "CREATE TABLE IF NOT EXISTS `". Flight::get('baseTable') ."` (
	`id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`name`	TEXT NOT NULL ,
		`category`	TEXT NOT NULL,
		`alloyWheels`	INTEGER,
		`electricMirrors`	INTEGER,
		`mats`	INTEGER,
		`display`	INTEGER,
		`autoPlay`	INTEGER);"
);
Flight::set('russianTableHeaders', [
    'Номер', 'Наименование','Категория', 'Литьё',
    'ЭлектроПодъемники', 'Коврики', 'Дисплей', 'Авоозапуск'
]);

function getDB() {
    $errorMsg = '';
    try {
        $db =Flight::db();
    } catch (Exception $e) {
        $errorMsg = 'Не удалось подключиться к БД' . $e->getMessage();
    }
    if (!isset($e)) {
        try  {
            $db->exec(Flight::get('createTable'));
        } catch (Exception $e) {
            $errorMsg = 'Не удалось создать таблицу' . $e->getMessage();
        }
    }
    if (!isset($db)) {
        throw new Exception($errorMsg);
    }
    if ($errorMsg) {
        echo $errorMsg;
    }
    return $db;
}
function parseData($dataObject) {
    $data = [];
    foreach ($dataObject as $key => $value) {
        if (is_array($value)) {
            $cleanArray = [];
            foreach ($value as $name => $record) {
                $cleanArray[$name] = htmlspecialchars($record);
            }
            $data[$key] = $cleanArray;
        } else {
            $data[$key] = htmlspecialchars($value);
        }
    }
    return $data;
}
function makeSelectSql() {
    $table = Flight::get('baseTable');
    $sql = "SELECT * FROM $table";
    return $sql;
}

function makeInsertSql($data) {
    $a = 'ОШИБКА ВВОДА ДАННЫХ';
    $table = Flight::get('baseTable');
    if (isset($data['category']) && !empty($data['category'])) {
        $dataArray['category'] = $data['category'][0];
    }
    if (isset($data['subcategory']) && !empty($data['subcategory'])) {
        foreach ($data['subcategory'] as $key => $value) {
            if ($value == 1) {
                $dataArray[$key] = $value;
            } else {
                $dataArray[$key] = $a;
            }
        }
    }
    if (isset($data['name']) && trim($data['name'] != '')) {
        $dataArray['name'] = strtoupper(trim($data['name']));
    }
    return sprintf(
        'INSERT INTO '.$table.' (%s) VALUES ("%s")',
        implode(',', array_keys($dataArray)),
        implode('","', array_values($dataArray))
    );
}
function makeDeleteSql($etc) {
    $table = Flight::get('baseTable');
    $etc = implode(', ', $etc);
    return "DELETE FROM $table WHERE id IN ($etc)";
}
function execSql($sql, $type)
{
    $result = [];
    $success = $fail = '';
    if ($type == 'insert') {
        $success = Flight::get('successInsertMsg');
        $fail = Flight::get('failInsertMsg');
    } elseif ($type == 'select') {
        $success = Flight::get('successSelectMsg');
        $fail = Flight::get('failSelectMsg');
    } elseif ($type == 'delete') {
        $success = Flight::get('successDeleteMsg');
        $fail = Flight::get('failSelectMsg');
    }
    $db = getDb();
    if (is_object($db)) {
        try {
            if ($type == 'insert' || $type == 'delete') {
                $db->exec($sql);
            } elseif ($type == 'select') {
                $rows = $db->query($sql);
            }
        } catch (Exception $e) {
            $result['status'] = 'danger';
            $result['description'] = "$fail: " . $e->getMessage();
            echo $e->getMessage();
        }
        if (!isset($e)) {
            if ($type == 'insert' || $type == 'delete') {
                $result['description'] = $success;
            } elseif ($type == 'select') {
                $result['description'] = $rows->fetchAll();
            }
            $result['status'] = 'success';
        }
        /* Закрыть соединение с БД */
        $db = null;
    } else {
        $result['status'] = 'danger';
        $result['description'] = $db;
    }
    return $result;
}
Flight::route('GET /', function () {
    Flight::render('main.php', [], 'content');
    Flight::render('layout.php', ['title' => 'База авто - Главная страница', 'header' => 'Добро пожаловать в автобазу']);
});
Flight::route('/base', function () {
    if (Flight::request()->method == 'POST') {
        $data = parseData(Flight::request()->data);
        $sql = makeInsertSql($data);
        $result = execSql($sql, 'insert');
    }
    Flight::render('base.php', compact('result'), 'content');
    Flight::render('layout.php', ['title' =>'База автомобилей ', 'header' => 'База данных']);
    $sqlSelect = makeSelectSql();
    $resultSelect = execSql($sqlSelect, 'select');
    $tableBody = $resultSelect['description'];
    Flight::render('table.php', ['tableBody' => compact('tableBody'), 'tableHeaders' => Flight::get('russianTableHeaders')]);
});
Flight::route('/remove', function () {
    $userData = Flight::request()->data;
    if (isset($userData['id'])) {
        $data = parseData(Flight::request()->data);
        var_dump($data);
        $sql = makeDeleteSql($data['id']);
        var_dump($sql);
        $result = execSql($sql, 'delete');
    } else $result['status'] = 'Ошибка удаления';
    Flight::redirect('/base');
});
Flight::route('GET /contacts', function () {
    Flight::render('contacts.php', [], 'content');
    Flight::render('layout.php', ['title' =>'Контакты руководителя', 'header' => 'Контакты']);
});
Flight::start();
