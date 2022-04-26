<?php

use App\BusinessLogic\Status\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoicesTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'invoices';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            //unencrypted
            $table->uuid('id')->unique();
            $table->uuid('product_id');

            //encrypted
            $table->string('transaction_id', 600);  //external reference (for customers and sellers)
            $table->string('service_id')->nullable();    //service reference  (paypal txn_id, coinbase account_id etc.)
            $table->string('payment_service', 600);
            $table->string('pay_to_address', 600)->nullable();
            $table->string('customer_email', 600);            //the customers (not the seller!!) email to send the confirmation email to.
            $table->string('price_usd', 600);                //price in usd.          
            $table->string('price_other', 600)->nullable();  //price in any other currency (btc, satoshi, etc)
            
            //even those are encrypted.
            $table->integer('updated_at');
            $table->integer('created_at');

            //
            $table->foreign('product_id')
            ->references('id')->on('products')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->index('transaction_id');
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
