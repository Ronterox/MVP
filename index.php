<?php

// TODO: Add logging table with date and action
// TODO: registration for users using session quick

// TODO: Compare alpinejs advantages vs hyperscript
// if-for for-each x-text
// init on wait send every 5s

$db = new SQLite3('db.sqlite', SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
$db->enableExceptions(true);

$db->exec('CREATE TABLE IF NOT EXISTS logs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    log_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    ip TEXT,
    session_time DATETIME
)');

$theme = 'blue';

session_start();

if ($_SERVER['REQUEST_URI'] == '/logout') {
    $_SESSION['auth'] = false;
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $user = filter_input(INPUT_POST, 'username');
    $pass = filter_input(INPUT_POST, 'password');

    if ($user == 'admin' && $pass == 'admin') {
        $_SESSION['auth'] = true;
        $message .= "<span hx-get='/dashboard' hx-target='body' hx-trigger='every 1s'>Success!</span>";
        $color = 'green';
    } else {
        http_response_code(401);
        $message .= "Wrong username or password";
        $color = 'red';
    }

    $html = <<<HTML
    <div class="ui $color message">$message</div>
    HTML;

    die($html);
} elseif ($_SERVER['REQUEST_URI'] == '/') {
    $_SESSION['auth'] = false;
}

$db->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Htmx/Php Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.classless.<?= $theme ?>.min.css">
    <link rel="stylesheet" href="style.css">

    <script defer src="https://unpkg.com/htmx.org@2.0.3"></script>
    <script defer src="https://unpkg.com/htmx-ext-response-targets@2.0.0/response-targets.js"></script>
</head>

<body hx-ext="response-targets">
    <?php
    if (!$_SESSION['auth']) {
        echo <<<HTML
        <main id="login">
            <h1 class="ui header">Login</h1>
            <form hx-post="/" hx-target-4*='#message'>
                <label for="username" class="ui small blue label">Username</label>
                <input type="text" name="username" required>

                <label for="password" class="ui small blue label">Password</label>
                <input type="password" name="password" required>

                <input type="submit" value="Login">

                <div class="ui horizontal divider">
                    <a href=''>Register</a>
                </div>
                <div id='message'></div>
            </form>
        </main>
        HTML;
    } else {
        echo <<<HTML
            <main id="dashboard">
                <h1 class="ui header">Dashboard</h1>
                <div class="ui horizontal divider">
                    <a hx-get="/logout" hx-target="body">Logout</a>
                </div>
                <table>
                    <tr>
                        <th>Log Time</th>
                        <th>IP</th>
                        <th>Session Time</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>

            </main>
        HTML;
    }
    ?>
</body>

</html>
