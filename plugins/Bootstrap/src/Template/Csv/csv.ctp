<?php
    $this->log('passei aqui no csv ');
    foreach($data as $_l => $_Entity)
    {
        foreach($_Entity as $_field => $_vlrField)
        {
            echo $_field.';';
        }
        echo "\r\n";
    }
