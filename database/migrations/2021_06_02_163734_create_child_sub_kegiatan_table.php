<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildSubKegiatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_sub_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('no_rek_sub');
            $table->string('name');
            $table->integer('child_of');
            $table->tinyInteger('level_sub'); //5 level
            $table->softDeletes();
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
        Schema::dropIfExists('child_sub_kegiatan');
    }
}
