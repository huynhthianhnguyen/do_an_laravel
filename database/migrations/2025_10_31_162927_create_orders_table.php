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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
        $table->string('name');
        $table->string('phone');
        $table->string('city')->nullable();
        $table->string('district')->nullable();
        $table->text('address');
        $table->string('payment_method')->nullable();
        $table->decimal('subtotal', 12, 2)->default(0);
        $table->decimal('shipping_fee', 12, 2)->default(0);
        $table->decimal('vat', 12, 2)->default(0);
        $table->decimal('total', 12, 2)->default(0);
        $table->string('status')->default('pending');
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
        Schema::dropIfExists('orders');
    }
};
