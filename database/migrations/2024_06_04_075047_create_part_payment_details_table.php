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
        Schema::create('part_payment_details', function (Blueprint $table) {
		$table->id();
		$table->enum("pp_mode",["credit_card","debit_card","cash","upi","cheque"]);
		$table->integer("bill_no");
		$table->string("pp_status");
    		$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part_payment_details');
    }
};
