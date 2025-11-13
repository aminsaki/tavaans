<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('fullName'); // نام
            $table->string('phone');
            $table->unsignedTinyInteger('companions')->default(0); // تعداد همراه (۱ تا ۴)
            $table->boolean('has_car')->default(false); // ماشین دارد یا نه
            $table->timestamp('entry_time')->nullable(); // زمان ورود
            $table->timestamp('exit_time')->nullable();  // زمان خروج
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
