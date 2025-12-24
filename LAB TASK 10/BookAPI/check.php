<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $count = \App\Models\Book::count();
    echo "Success: Book count is " . $count;
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage();
}
