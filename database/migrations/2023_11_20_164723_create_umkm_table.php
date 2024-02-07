<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUmkmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('umkm', function (Blueprint $table) {
            $table->id();
            $table->string('nama_umkm');        //nama_toko_umkm
            $table->string('pemilik');          //nama_pemilik
            $table->string('jenis_produk');     //jenis_produk
            $table->string('omset');
            $table->string('norma_omset');
            $table->string('asset');
            $table->string('norma_asset');
            $table->string('no_hp');
            $table->string('klasifikasi_usaha')->nullable();        //'MIKRO', 'KECIL', 'MENENGAH'
            $table->enum('is_active', ['1', '0',])->default('1');
            $table->string('kegiatan_usaha');
            $table->string('alamat');
            $table->enum('kecamatan', ['PAKUALAMAN', 'DANUREJAN', 'GONDOKUSUMAN', 'GONDOMANAN', 'JETIS', 'KOTAGEDE', 'KRATON', 'MANTRIJERON', 'MERGANGSAN', 'NGAMPILAN', 'GEDONGTENGEN', 'TEGALREJO', 'UMBULHARJO', 'WIROBRAJAN']);
            $table->string('longtitude');
            $table->string('lattitude');
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
        Schema::dropIfExists('umkm');
    }
}
