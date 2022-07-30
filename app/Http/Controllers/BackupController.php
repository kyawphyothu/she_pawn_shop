<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    public function index()
    {
        $backup = Backup::latest()->get();
        return view('backups.index', [
            'backup' => $backup,
        ]);
    }

    public function store()
    {
        $result = exec('cd .. && php artisan config:clear && php artisan backup:run --only-db ');

        if($result == 'Backup completed!'){
            $lastInsertedFileName = exec('cd storage/shepawnshop && ls -1t |head -1');
            $lastInsertedFileSize = number_format((filesize("storage/shepawnshop/$lastInsertedFileName")/1048576), 2);

            $backup = new Backup();
            $backup->name = $lastInsertedFileName;
            $backup->size = $lastInsertedFileSize;
            $backup->save();
        }

        return back()->with('info', $result);
    }

    public function destory($id)
    {
        $name = Backup::where('id', $id)->first();

        if(File::exists(public_path("storage/shepawnshop/$name->name"))){
            Backup::where('id', $id)->delete();
            File::delete(public_path("storage/shepawnshop/$name->name"));
            return back()->with('info', 'Delete Success');
        } else {
            return back()->with('danger', "Delete Error");
        }
    }
}
