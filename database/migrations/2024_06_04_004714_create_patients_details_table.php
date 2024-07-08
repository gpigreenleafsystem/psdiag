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
        Schema::create('patients_details', function (Blueprint $table) {
		$table->id();
		$table->integer("name");
		$table->integer("age");
		$table->string("mobileno");
		$table->string("address");
		$table->string("alt_phoneno");
		$table->integer("visit_no");
		$table->string("patienttype");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients_details');
    }
};
