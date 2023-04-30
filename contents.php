<?php

use Blogger\Contents\Reader;

require_once __DIR__ . '/settings.php';

$reader = new Reader(['filePath' => (__DIR__ . '/contents.xml')]);

$dataPages = $reader->pages();
$dataPosts = $reader->posts();

// dd($reader->entries());
// dd($dataPosts, current($dataPosts)->id, current($dataPosts)->created);
dd($dataPosts);
