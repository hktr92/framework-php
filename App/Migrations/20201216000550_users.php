<?php

namespace App\Migrations;

use App\Core\Schema\Schema;

$schema = new Schema();

$schema->create('users', function ($table) {
    $table->BIGINT('id')->primaryKey()->autoIncrement();
    $table->VARCHAR('username', 144);
    $table->VARCHAR('email', 144)->unique();
    $table->VARCHAR('password', 255);
    $table->TIMESTAMP('register_at')->defaultValue('CURRENT_TIMESTAMP');
})->generate();
