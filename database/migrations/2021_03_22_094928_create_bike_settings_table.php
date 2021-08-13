<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Bike;

class CreateBikeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bike_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bike_id')->nullable()->constrained('bikes')->onDelete('cascade');
            $table->foreignId('detail_id')->nullable()->constrained('details')->onDelete('cascade');
            $table->longText('value')->nullable();
            $table->integer('status')->default(Bike::STATUS_DETAIL_NORMAL);
            $table->longText('note')->nullable();
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
        Schema::dropIfExists('bike_settings');
    }
}
