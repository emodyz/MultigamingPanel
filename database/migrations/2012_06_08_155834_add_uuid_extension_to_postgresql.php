
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUuidExtensionToPostgresql extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = config('database.default');

        $driver = config("database.connections.{$connection}.driver");

        if($driver === 'pgsql') {
            DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No need to remove the extension.
    }
}
