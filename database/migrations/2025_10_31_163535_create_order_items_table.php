<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
        $table->foreignId('product_id')->nullable()->constrained('san_pham')->nullOnDelete();
        $table->string('ten_san_pham');
        $table->integer('quantity')->default(1);
        $table->decimal('gia', 12, 2)->default(0);
        $table->decimal('tong_tien', 12, 2)->default(0);
        $table->string('color')->nullable();
        $table->string('size')->nullable();
        $table->string('hinh_anh')->nullable();
        $table->timestamps();
        $table->integer('discount')->default(0);
$table->string('coupon_code')->nullable();

    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
