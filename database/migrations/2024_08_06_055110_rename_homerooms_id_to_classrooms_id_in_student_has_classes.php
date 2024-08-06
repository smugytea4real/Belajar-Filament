<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        Schema::table('student_has_classes', function (Blueprint $table) {
            $table->renameColumn('homerooms_id', 'classrooms_id');
            $table->dropForeign(['homerooms_id']);
            $table->foreign('classrooms_id')->references('id')->on('classrooms')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('student_has_classes', function (Blueprint $table) {
            $table->renameColumn('classrooms_id', 'homerooms_id');
            $table->dropForeign(['classrooms_id']);
            $table->foreign('homerooms_id')->references('id')->on('home_rooms')->onDelete('cascade')->onUpdate('cascade');
        });
    }
};