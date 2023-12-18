<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemilik');
            $table->string('no_hp');
            $table->string('nama_usaha');
            $table->string('kegiatan_usaha');
            $table->enum('klasifikasi_usaha', ['MIKRO', 'KECIL', 'MENENGAH']);
            $table->enum('is_active', ['1', '0',])->default('1');
            $table->string('jenis_produk');
            $table->string('alamat');
            $table->string('kecamatan');
            $table->string('long');
            $table->string('lat');
            // $table->text('description');
            // $table->string('image');
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
        Schema::dropIfExists('locations');
    }
}
