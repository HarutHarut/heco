<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bikes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('description')->nullable();
            $table->year('year')->nullable();
            $table->double('msrp')->nullable();
            $table->enum('msrp_currency', ['USD', 'EUR', 'GBP'])->default('EUR');
            $table->double('price')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
            $table->foreignId('brand_model_id')->nullable()->constrained('brand_models')->onDelete('set null');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->double('recommended_price')->nullable();
            $table->double('weight')->nullable();
            $table->double('wheels_size')->nullable();
            $table->double('frame_size')->nullable();
            $table->string('milage')->nullable();
            $table->string('last_service')->nullable();
            $table->string('color')->nullable();
            $table->string('image_path')->nullable();
            $table->string('condition')->nullable();
            $table->string('status', 50)->default('inactive');
            $table->boolean('preowned')->default(0);
            $table->boolean('shipping')->default(0);
            $table->boolean('bargain')->default(0);
            $table->string('token')->nullable();
            $table->string('mail')->nullable();
            $table->boolean('parent_id')->default(0);
            $table->integer('count_of_visits')->default(0);
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
        Schema::dropIfExists('bikes');
    }
}
