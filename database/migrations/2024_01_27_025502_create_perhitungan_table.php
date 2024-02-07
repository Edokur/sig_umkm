<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerhitunganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perhitungan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('centroid_id');
            $table->string('nilai_mikro');
            $table->string('nilai_kecil');
            $table->string('nilai_menengah');
            $table->string('nilai_jarak');
            $table->timestamps();

            // $table->foreign('centroid_id')->references('id')->on('centroid')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perhitungan');
    }
}
