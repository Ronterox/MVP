<?php

$theme = 'blue';

session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $user = filter_input(INPUT_POST, 'username');
    $pass = filter_input(INPUT_POST, 'password');

    if ($user == 'admin' && $pass == 'admin') {
        $_SESSION['auth'] = true;
        $message .= "<span hx-get='/' hx-target='body' hx-trigger='every 0.5s'>Success!</span>";
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
} elseif (isset($_POST['logout'])) {
    session_destroy();
    header('Location: /');
}

view('index', ['auth' => $_SESSION['auth'], 'theme' => $theme]);
