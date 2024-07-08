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
        Schema::create('payment_details', function (Blueprint $table) {
		$table->id();
		$table->enum("payment_type",["full_payment","part_payment"]);
		$table->string("payment_mode");
		$table->string("remarks");
		$table->float("net_amount",8,2);
		$table->float("paid_amount",8,2);
		$table->float("remaning_amount",8,2);
		$table->integer("part_payment_id");
		 $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};
