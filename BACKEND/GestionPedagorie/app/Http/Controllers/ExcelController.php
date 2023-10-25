<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;
use App\Imports\ClasseImport;

class ExcelController extends Controller
{
    public function import(Request $request)
    {
        $file = $request->file('excel_file');

        Excel::import(new UsersImport, $file);

        return response()->json(['message' => 'Import réussi']);
    }
    public function importClasse(Request $request)
    {
        $file = $request->file('excel_file');

        Excel::import(new ClasseImport, $file);

        return response()->json(['message' => 'Import réussi']);
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
