<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'products';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            //Not encryptable
            $table->uuid('id')->unique();
            $table->uuid('user_id'); //needed to get public_key to verify signature.
            $table->boolean('enabled')->default(false);

            //encryptABLE
            $table->string('name', 600);
            $table->string('description', 600)->nullable();
            $table->string('price', 600); //in usd pennies.
            $table->string('updated_at', 600);
            $table->string('created_at', 600);

            //key
            $table->string('encrypted_key', 600);

            //other
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            //pointless with encryption (because the encrypted name changes even with the same input name) its also too long.
            //$table->unique(array('user_id', 'name')); 
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
