<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->nullable()->constrained('pages')->onDelete('cascade');
            $table->string('lang');
            $table->string('title');
            $table->mediumText('description')->nullable();
            $table->text('short_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_data');
    }
}
