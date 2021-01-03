<?php

use App\Models\Game;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModpacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modpacks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('disk');
            $table->uuid('job_batch_id')->nullable()->unique();
            $table->string('path')->unique();
            $table->json('manifest')->nullable();
            $table->json('manifest_info')->nullable();
            $table->timestamp('manifest_last_update')->nullable();

            $table->foreignIdFor(Game::class)
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
        Schema::dropIfExists('modpacks');
    }
}
