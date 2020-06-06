<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->after('name')->nullable();
            $table->boolean('profile_finished')->after('locale')->default(false);
            $table->ipAddress('ip')->after('remember_token')->default('0.0.0.0');
            $table->integer('uuid')->after('email')->unsigned()->nullable()->default(32);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->$table->dropColumn(['image', 'profile_finished', 'ip', 'uuid']);
        });
    }
}
