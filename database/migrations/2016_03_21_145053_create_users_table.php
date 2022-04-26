<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'users';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password', 64);

            $table->integer('subscription_end'); //Service days
            $table->integer('credits')->default(0);     //for testing.       
            $table->boolean('email_confirmed')->default(false);
            $table->boolean('is_banned')->default(false);
            
            $table->integer('updated_at');
            $table->integer('created_at');
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop($this->table);
    }
}
