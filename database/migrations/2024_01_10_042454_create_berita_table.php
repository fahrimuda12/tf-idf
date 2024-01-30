<?php

use App\Models\BeritaModel;
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
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->string('berita')->nullable();
            $table->timestamps();
        });

        $data = [
            [
                'judul' => 'CR9 Bikin Mourinho Tak Sabar ke Madrid',
                'berita' => 'Yang spesial dari rencana kepindahan Jose Mourinho ke Real Madrid adalah pertemuan dia dengan Cristiano Ronaldo. Mengaku tak sabar bertemu rekan senegaranya itu, Mourinho juga berharap banyak gol dari CR9.',
            ],
            [
                'judul' => 'Jepang Mau Sampai Semifinal',
                'berita' => 'Kalah atas Korea Selatan tak membuat kepercayaan diri Jepang menyusut. Pelatih "Samurai Biru", Takeshi Okada, malah memasang target tinggi dengan menembus babak semifinal.',
            ],
            [
                'judul' => 'Simpati Milito untuk Cambiasso & Zanetti',
                'berita' => 'Diego Milito mengungkapkan rasa simpatinya kepada rekannya di Inter Milan. Meski sama-sama meraih treble di Inter namun Esteban Cambiasso dan Javier Zanetti tak masuk skuad Argentina. ',
            ],
            [
                'judul' => 'Neville Belum Berencana Pensiun',
                'berita' => 'Gary Neville bersikukuh belum mau pensiun dari timnas Inggris. Meskipun sudah jarang dipanggil memperkuat The Three Lions, bek 35 tahun ini mengaku siap bermain saat negerinya membutuhkan jasanya',
            ],
        ];

        BeritaModel::insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
