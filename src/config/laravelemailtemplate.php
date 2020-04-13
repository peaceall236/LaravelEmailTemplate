<?php

return [
    "middleware" => ['web'], // define middleware to be used ['web', 'auth']
    "templates" => [
        [
            "name" => "template1", // template name
            "variables" => ["variable1", "variable2"], // available placeholders to be considered for the template
            "folder" => "" // path inside resources/views, if not present, laravel default path will be applied
        ], [
            "name" => "template2",
            "variables" => ["variable1", "variable2"],
            "folder" => ""
        ]
    ]
];