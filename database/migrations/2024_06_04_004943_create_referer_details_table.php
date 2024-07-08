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
        Schema::create('referer_details', function (Blueprint $table) {
		$table->id();
		$table->string("referer_name");
		$table->integer("referer_phno");
		$table->float("referer_amount",8,2);
		$table->integer("referer_count");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referer_details');
    }
};
