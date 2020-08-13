<?php

namespace App\Http\Controllers;

use App\Student;
use Yajra\DataTables\Facades\DataTables;

class StudentGetController extends Controller
{
    public function index()
    {
          try
        {
            $objStudents = Student::select(['id', 'name', 'email','mobile_number']);
            return DataTables::of($objStudents)
                ->addColumn('action', function ( $objStudents ) {
                    return '<button student_id="' . $objStudents->id . '" class="btn btn-xs btn-primary edit"><i class="glyphicon glyphicon-edit"></i> Edit</button> <button student_id="' . $objStudents->id . '" class="btn btn-xs btn-danger delete"><i class="glyphicon glyphicon-trash"></i> Delete</button>';
                })
                ->make(true);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }
}
