<?php

namespace App\Migrations;

use App\Core\Schema\Schema;

$schema = new Schema();

$schema->create('sessions', function ($table) {
    $table->VARCHAR('session_id', 255)->primarykey();
    $table->BIGINT('user_id')
        ->foreignKey()
        ->references('users.id')
        ->onUpdate('cascade')
        ->onDelete('cascade');
    $table->TIMESTAMP('login_time')->defaultValue('CURRENT_TIMESTAMP');
})->generate();
