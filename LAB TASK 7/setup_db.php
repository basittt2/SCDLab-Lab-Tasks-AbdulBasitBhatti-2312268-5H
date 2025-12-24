<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Setting up database...\n";

// Users
if (!Schema::hasTable('users')) {
    echo "Creating users table...\n";
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });
}

// Categories
if (!Schema::hasTable('categories')) {
    echo "Creating categories table...\n";
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });
}

// Posts
if (!Schema::hasTable('posts')) {
    echo "Creating posts table...\n";
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id'); // SQLite easy mode
        $table->string('title');
        $table->text('body');
        $table->timestamps();
    });
}

// Comments
if (!Schema::hasTable('comments')) {
    echo "Creating comments table...\n";
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('post_id');
        $table->text('body');
        $table->timestamps();
    });
}

// Pivot
if (!Schema::hasTable('category_post')) {
    echo "Creating category_post table...\n";
    Schema::create('category_post', function (Blueprint $table) {
        $table->id();
        $table->foreignId('post_id');
        $table->foreignId('category_id');
        $table->timestamps();
    });
}

// Sessions (if needed)
if (!Schema::hasTable('sessions')) {
     Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
}


echo "Seeding data...\n";

if (!User::where('email', 'test@example.com')->exists()) {
    User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);
}

if (Category::count() === 0) {
    Category::create(['name' => 'Tech']);
    Category::create(['name' => 'Lifestyle']);
    Category::create(['name' => 'Education']);
}

echo "Database setup complete.\n";
