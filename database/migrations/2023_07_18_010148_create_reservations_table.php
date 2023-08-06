<?php
/*
 * Project: sunny-backend
 * File: 2023_07_18_010148_create_reservations_table.php
 * Author: Islam alalfy
 * Company: alalfy.com
 * Website: https://alalfy.com
 * GitHub: https://github.com/EngALAlfy/sunny-backend
 *
 * Copyright (c) 2023 Islam alalfy. All rights reserved.
 * This code is private and confidential.
 * Unauthorized copying or distribution of this file is strictly prohibited.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email");
            $table->string("phone");
            $table->date("date");
            $table->string("address")->nullable();
            $table->string("note" , 300)->nullable();
            $table->string("status")->comment("allowed [waiting , confirmed , cancelled]");
            $table->foreignIdFor(\App\Models\User::class , "created_by_user_id")->nullable()->constrained("users")->nullOnDelete();
            $table->foreignIdFor(\App\Models\Doctor::class)->constrained()->nullOnDelete();
            $table->foreignIdFor(\App\Models\Service::class)->constrained()->nullOnDelete();
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
        Schema::dropIfExists('reservations');
    }
}
