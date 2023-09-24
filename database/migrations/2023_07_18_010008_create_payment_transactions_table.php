<?php
/*
 * Project: sunny-backend
 * File: 2023_07_18_010008_create_payment_transactions_table.php
 * Author: Islam alalfy
 * Company: alalfy.com
 * Website: https://alalfy.com
 * GitHub: https://github.com/EngALAlfy/sunny-backend
 *
 * Copyright (c) 2023 Islam alalfy. All rights reserved.
 * This code is private and confidential.
 * Unauthorized copying or distribution of this file is strictly prohibited.
 */

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->double("value")->default(0);
            $table->string("type")->nullable();
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger("payable_id")->nullable();
            $table->string("payable_type")->nullable();
            $table->string("client_name")->nullable();
            $table->string("client_email")->nullable();
            $table->string("client_phone")->nullable();
            $table->string("note", 300)->nullable();
            $table->foreignIdFor(\App\Models\User::class, "created_by_user_id")->nullable()->constrained("users")->nullOnDelete();
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
        Schema::dropIfExists('payment_transactions');
    }
}
