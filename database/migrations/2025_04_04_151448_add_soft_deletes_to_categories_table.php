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
        Schema::table('categories', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');
            // The softDeletes() method adds a nullable deleted_at timestamp column to the table.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
            // The dropSoftDeletes() method removes the deleted_at column from the table.
            // This is useful if you want to revert the migration and remove soft deletes from the categories table.
            // Note: Be cautious when dropping soft deletes, as it will permanently delete any soft-deleted records.
            // If you have any soft-deleted records, they will be permanently removed from the database.
        });
    }
};
