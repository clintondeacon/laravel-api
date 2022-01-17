<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::dropIfExists('stations');

        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->decimal("latitude",10,8);
            $table->decimal("longitude",10,8);
            $table->integer("company_id");
            $table->string("address",1000);
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
        Schema::dropIfExists('stations');
    }
}
