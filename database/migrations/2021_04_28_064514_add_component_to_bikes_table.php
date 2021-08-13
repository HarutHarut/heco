<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddComponentToBikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bikes', function (Blueprint $table) {
            $table->foreignId('component_id')->nullable()->constrained('components')->onDelete('set null')->after('brand_model_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bikes', function (Blueprint $table) {
            //
        });
    }
}
