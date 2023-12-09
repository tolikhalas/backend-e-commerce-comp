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
        // Update & Enhance 'products' table
        Schema::table("products", function (Blueprint $table) { 
            // Fixes/ Removed unnecessary field
            // Fixed mistyped field's name
            $table->dropColumn("is_available");
            $table->dropColumn('quanity');
            $table->integer('quantity')->unsigned()->default(0);

            // Made rate optional
            $table->float('rate')->nullable()->change();

            // Added description
            $table->text("description")->nullable();

            // Added image
            $table->string("image")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
