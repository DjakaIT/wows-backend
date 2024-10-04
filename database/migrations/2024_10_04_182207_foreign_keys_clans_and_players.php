<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToClansAndPlayers extends Migration
{
    public function up()
    {
        Schema::table('clans', function (Blueprint $table) {
            $table->foreign('creator')->references('id')->on('players')->onDelete('cascade');
        });

        Schema::table('players', function (Blueprint $table) {
            $table->foreign('clan_id')->references('id')->on('clans')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('clans', function (Blueprint $table) {
            $table->dropForeign(['creator']);
        });

        Schema::table('players', function (Blueprint $table) {
            $table->dropForeign(['clan_id']);
        });
    }
}
