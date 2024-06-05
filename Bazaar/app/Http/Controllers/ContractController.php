<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    public function show()
    {
        $users = User::all();
        $date = date('d/m/Y');

        $rawFiles = Storage::files('public/contracts');
        $files = [];

        foreach ($rawFiles as $rawFile) {
            $file = [
                'name' => basename($rawFile, 'public/contracts'),
                'path' => Storage::get(public_path($rawFile)),
            ];

            array_push($files, $file);
        }

        return view('admin.contract', ['users' => $users, 'date' => $date, 'files' => $files]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'contract' => 'required|file|mimes:pdf|max:2048',
        ]);

        $originalFileName = pathinfo($request->file('contract')->getClientOriginalName(), PATHINFO_FILENAME);
        $newFileName = $originalFileName.'.'.$request->file('contract')->getClientOriginalExtension();
        $request->file('contract')->storeAs('public/contracts', $newFileName, 'local');

        return to_route('admin.contract.show');
    }

    public function downloadFile($rawFile)
    {
        $fileName = basename($rawFile, 'public/contracts');
        $filePath = 'public/contracts/' . $fileName;

        if (Storage::exists($filePath)) {
            return Storage::download($filePath, $fileName);
        }

        return to_route('admin.contract.show');
    }

}
