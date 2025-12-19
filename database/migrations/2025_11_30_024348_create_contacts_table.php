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
        Schema::create('contacts', function (Blueprint $table) {
    $table->id();
    $table->string('name');      // Tên người liên hệ
    $table->string('phone');     // Số điện thoại
    $table->string('email');     // Email người liên hệ
    $table->text('comment');     // Nội dung tin nhắn
    $table->timestamps();        // created_at & updated_at
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
