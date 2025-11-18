<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('zone_member_pays', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('member_id');
            $table->string('name')->nullable();
            $table->string('woreda')->nullable();
            $table->string('position');
            $table->integer('amount');
            $table->date('date');
            $table->timestamps();
        });
    }
};
