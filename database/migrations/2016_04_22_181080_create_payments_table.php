<?php

use App\BusinessLogic\Payment\PaymentService;
use App\BusinessLogic\Status\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration
{
    /**
     * The table name.
     *
     * @var
     */
    protected $table = 'payments';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('transaction_id')->unique();  //external reference (for customers and sellers)
            $table->uuid('product_id');
            $table->string('service_id')->nullable();    //service reference  (paypal txn_id, coinbase account_id etc.)
            $table->string('payment_service')->default(PaymentService::DEFAULT);
            $table->string('pay_to_address')->nullable();
            $table->string('customer_email');             //the customers (not the seller!!) email to send the confirmation email to.
            $table->integer('price_usd');                //price in usd.          
            $table->integer('price_other')->nullable();  //price in any other currency (btc, satoshi, etc)
            $table->tinyInteger('status')->default(0);
            $table->string('reason', 500)->nullable();

            $table->foreign('product_id')
            ->references('id')->on('products')
            ->onUpdate('cascade')->onDelete('cascade');
            
            $table->integer('updated_at');
            $table->integer('created_at');
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
