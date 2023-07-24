<?php
/*
 * Project: sunny-backend
 * File: BackupController.php
 * Author: Islam alalfy
 * Company: alalfy.com
 * Website: https://alalfy.com
 * GitHub: https://github.com/EngALAlfy/sunny-backend
 *
 * Copyright (c) 2023 Islam alalfy. All rights reserved.
 * This code is private and confidential.
 * Unauthorized copying or distribution of this file is strictly prohibited.
 */

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class BackupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {

        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);

        $files = $disk->files(config('backup.backup.name'));

        $backups = [];
        // make an array of backup files, with their filesize and creation date
        //\storage\app\AzhaErp
        foreach ($files as $k => $f) {
            // only take the zip files into account

            if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                $backups[] = [
                    'path' => $f,
                    'name' => str_replace(config('backup.backup.name') . "/", '', $f),
                    'size' => ($disk->size($f) / 1024),
                    'created_at' => Carbon::parse($disk->lastModified($f)),
                ];
            }
        }
        // reverse the backups, so the newest one would be on top
        $backups = array_reverse($backups);

        return view('backup.index', compact('backups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function store()
    {
        // start the backup process
        Artisan::call('backup:run --only-db');
        $output = Artisan::output();

        $this->info($output);

        return redirect()->route('backup.index');
    }

    /**
     * Display the specified resource.
     *
     */
    public function show($name)
    {
        $file = config('backup.backup.name') . DIRECTORY_SEPARATOR . $name;
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        if ($disk->exists($file)) {
            return $disk->download($file);
        } else {
            abort(404);
        }
    }


    public function restore($name)
    {
        $file = config('backup.backup.name') . DIRECTORY_SEPARATOR . $name;
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        if ($disk->exists($file)) {
            // start restore
            $path = $disk->path($file);
            $folder = str_replace(".zip", "", $path);
            $db_file = $folder . DIRECTORY_SEPARATOR . "db-dumps" . DIRECTORY_SEPARATOR . "mysql-gooddoctor.sql";

            $zip = new ZipArchive();
            $zip->open($path);
            $zip->extractTo($folder);
            $zip->close();

            ini_set("memory_limit", "-1");
            $output = DB::unprepared(file_get_contents($db_file));

            $this->info($output);

            return redirect()->route('backup.index');
        } else {
            abort(404);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($name)
    {
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        if ($disk->exists(config('backup.backup.name') . DIRECTORY_SEPARATOR . $name)) {
            $disk->delete(config('backup.backup.name') . DIRECTORY_SEPARATOR . $name);
            return redirect()->back();
        } else {
            abort(404);
        }
    }
}
