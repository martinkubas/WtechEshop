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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'images')) {
                $table->json('images')->nullable();
            }

            $table->dropColumn(['platform', 'genre', 'release_date', 'developer']);
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'platform')) {
                $table->string('platform');
            }

            if (!Schema::hasColumn('products', 'genre')) {
                $table->string('genre');
            }

            if (!Schema::hasColumn('products', 'release_date')) {
                $table->date('release_date');
            }

            if (!Schema::hasColumn('products', 'developer')) {
                $table->string('developer');
            }

            if (Schema::hasColumn('products', 'images')) {
                $table->dropColumn('images');
            }
        });
    }
};
