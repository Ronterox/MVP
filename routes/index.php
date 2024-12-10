<?php

$db = new SQLite3($CACHE . 'db.sqlite', SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
$db->exec("CREATE TABLE IF NOT EXISTS logs (id INTEGER PRIMARY KEY AUTOINCREMENT, ip TEXT, log_time CURRENT_TIMESTAMP, session_time DATETIME);");

$theme = 'blue';
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $user = filter_input(INPUT_POST, 'username');
    $pass = filter_input(INPUT_POST, 'password');

    if ($user == 'admin' && $pass == 'admin') {
        $_SESSION['auth'] = true;
        $_SESSION['session'] = date('Y-m-d H:i:s');

        $db->exec("INSERT INTO logs (ip, log_time) VALUES ('{$_SERVER['REMOTE_ADDR']}', '{$_SESSION['session']}');") or die($db->lastErrorMsg());
        $_SESSION['id'] = $db->lastInsertRowID();

        $message .= "<span hx-get='/' hx-target='body' hx-trigger='every 0.5s'>Success!</span>";
        $color = 'green';
    } else {
        $db->exec("INSERT INTO logs (ip, log_time) VALUES ('{$_SERVER['REMOTE_ADDR']}', '{$_SESSION['session']}');") or die($db->lastErrorMsg());
        http_response_code(401);
        $message .= "Wrong username or password";
        $color = 'red';
    }

    $html = <<<HTML
    <div class="ui $color message">$message</div>
    HTML;

    die($html);
} elseif (isset($_POST['logout'])) {
    $duration = time() - strtotime($_SESSION['session']);
    $db->exec("UPDATE logs SET session_time = '{$duration}' WHERE id = {$_SESSION['id']}") or die($db->lastErrorMsg());

    session_destroy();
    header('Location: /');
}

$query = $db->query('SELECT * FROM logs ORDER BY id DESC LIMIT 10') or die($db->lastErrorMsg());

$logs = [];
while ($row = $query->fetchArray(SQLITE3_ASSOC)) {
    $logs[] = $row;
}

$db->close();

view('index', ['auth' => $_SESSION['auth'], 'theme' => $theme, 'logs' => $logs]);
