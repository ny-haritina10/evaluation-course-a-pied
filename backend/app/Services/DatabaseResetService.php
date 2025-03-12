<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DatabaseResetService
{
    public function resetDatabase()
    {
        $connection = config('database.default');

        if ($connection === 'pgsql') {
            $tables = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public';");

            foreach ($tables as $table) {
                $tableName = $table->tablename;
                
                // unless admins table
                if ($tableName !== 'migrations' && $tableName !== 'admins') {
                    DB::statement("TRUNCATE TABLE \"$tableName\" RESTART IDENTITY CASCADE;");
                }
            }
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            $tables = DB::select('SHOW TABLES');
            $databaseName = env('DB_DATABASE');
            $key = "Tables_in_$databaseName"; 

            foreach ($tables as $table) {
                $tableName = $table->$key;
                DB::table($tableName)->truncate();
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}