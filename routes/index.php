<?php

// TODO: Auto imports everything in assets
// TODO: Prebuilt components coming from view

$query='astolfo';
exec("curl -Ls 'https://www.google.com/search?udm=2&q=$query' | pup 'img:first-of-type attr{src}' | tail -n +2", $images);

view('index', ['theme' => 'blue', 'astolfo' => $images]);
