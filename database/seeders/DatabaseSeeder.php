<?php
/*
 * Project: sunny-backend
 * File: DatabaseSeeder.php
 * Author: Islam alalfy
 * Company: alalfy.com
 * Website: https://alalfy.com
 * GitHub: https://github.com/EngALAlfy/sunny-backend
 *
 * Copyright (c) 2023 Islam alalfy. All rights reserved.
 * This code is private and confidential.
 * Unauthorized copying or distribution of this file is strictly prohibited.
 */

namespace Database\Seeders;

use App\Models\Disease;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // increase memory
        ini_set('memory_limit', '3000M');
        // disable database log to free up memory
        DB::disableQueryLog();
        // disable database events to free up memory
        DB::setEventDispatcher(new Dispatcher());

        $this->call(UserSeeder::class);
        $this->call(SettingSeeder::class);
    }
}
