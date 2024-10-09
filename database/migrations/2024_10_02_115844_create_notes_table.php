<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content'); // Ensure this is of type text
            $table->string('tags')->nullable();
            $table->timestamps();
            $table->string('shared_token')->nullable(); // To store the unique token
            
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('notes');
    }
}

