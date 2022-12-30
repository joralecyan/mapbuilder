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
        Schema::create('board_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_id');

            $table->integer('AB_coins')->default(0);
            $table->integer('BC_coins')->default(0);
            $table->integer('CD_coins')->default(0);
            $table->integer('DA_coins')->default(0);

            $table->integer('AB_goblins')->default(0);
            $table->integer('BC_goblins')->default(0);
            $table->integer('CD_goblins')->default(0);
            $table->integer('DA_goblins')->default(0);

            $table->integer('AB_points_A')->default(0);
            $table->integer('AB_points_B')->default(0);
            $table->integer('BC_points_B')->default(0);
            $table->integer('BC_points_C')->default(0);
            $table->integer('CD_points_C')->default(0);
            $table->integer('CD_points_D')->default(0);
            $table->integer('DA_points_D')->default(0);
            $table->integer('DA_points_A')->default(0);

            $table->integer('coins')->default(0);

            $table->integer('AB_points')->default(0);
            $table->integer('BC_points')->default(0);
            $table->integer('CD_points')->default(0);
            $table->integer('DA_points')->default(0);

            $table->integer('total')->default(0);

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
        Schema::dropIfExists('board_points');
    }
};
