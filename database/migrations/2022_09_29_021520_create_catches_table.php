<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catches', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->index();
            $table->string('name')->index();
            $table->integer('weight',false)->nullable()->default(NULL);
            $table->integer('length')->nullable()->default(NULL);
            $table->string('img_url')->nullable()->default(NULL);
            $table->integer('location_id')->nullable()->default(NULL);
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
        Schema::dropIfExists('catches');
    }
};
