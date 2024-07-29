<?php

$theme = include __DIR__.'/themes/default.php';

$theme += [
    'navbar' => [               // Additionnal views to append items to the navbar
        'left'  => [],
        'right' => [],
    ],
    'favicon'    => '/assets/vendor/boilerplate/images/vendor/bootstrap-fileinput/logo_fond_blanc-removebg-preview.png',       // Favicon url
    'fullscreen' => false,      // Fullscreen switch
    'darkmode'   => false,       // Dark mode switch
    'minify'     => true,       // Minify inline JS / CSS when using boilerplate::minify component
];

return $theme;
