<?php

require_once __DIR__.'/../vendor/autoload.php';

use FreeMobileSMS\Sender;

$Sender = new Sender("user_id", "api_key");
$Sender->Send("Hello from PHP");