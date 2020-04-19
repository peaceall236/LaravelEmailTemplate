<?php

return [
    "middleware" => ['web'], // define middleware to be used ['web', 'auth']
    "templates" => [
        [
            "name" => "template1", // template name
            "variables" => ["variable1", "variable2"], // available placeholders to be considered for the template
            "folder" => "email-template/template1", // path inside resources/views, NB: Each Template must have its own folder
            "entry_file" => "template.php" 
        ], [
            "name" => "template2",
            "variables" => ["variable1", "variable2"],
            "folder" => "email-template/template2",
            "entry_file" => "template.php"
        ]
    ]
];

// love is blinded by hope
// hatred is due to lack of vision and ignorance