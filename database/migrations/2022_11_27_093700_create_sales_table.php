<?php

use App\Models\Customer;
use App\Models\User;
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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class, 'customer_id');
            $table->foreignIdFor(User::class, 'user_id');
            $table->integer('payment_method_id')->default(1);
            $table->string('invoice_no', 255);
            $table->integer('total_quantities');
            $table->decimal('sub_total', 10, 2);
            $table->decimal('vat', 10, 2);
            $table->decimal('grand_total', 10, 2);
            $table->decimal('pay', 10, 2)->nullable()->default(0.00);
            $table->decimal('due', 10, 2)->nullable()->default(0.00);
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
        Schema::dropIfExists('sales');
    }
};
