iin
'
'
'i
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
        Schema::create('investigation_details', function (Blueprint $table) {
		$table->id();
		$table->integer("modality_id");
		$table->string("study");
		$table->float("qty",8,2);
		$table->double("rate",8,2);
		$table->double("amount",8,2);
		$table->double("discount",8,2);
		$table->string("report_status");
		$table->string("scanning_status");
           	$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investigation_details');
    }
};
