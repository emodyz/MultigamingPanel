<?php

use App\Models\Server;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_statuses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('online');
            $table->integer('players_max');
            $table->integer('players_online');

            $table->foreignIdFor(Server::class)
                ->constrained();

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
        Schema::dropIfExists('server_statuses');
    }
}
