<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('students.index');
    }

    public function importExportExcelORCSV(){
        return view('students.index');
    }

    public function getCustomFilter()
{
    return view('students.index');
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $request->validate( [    'name'          => 'required',
                                'email'         => 'required',
                                'uname'         => 'required',
                                'mobile_number' => 'required',
                                'date_of_birth' => 'required',
                                'address'       => 'required',
                                'city'          => 'required',
                                'state'         => 'required',
                                'country'       => 'required',
                                'user_image_path' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
                            ] );

       if( $request->hasfile('user_image_path') ) {

          $file      = $request->file('user_image_path');
          $extension = $file->getClientOriginalExtension();
          $filename  = time() . '.' . $extension;
          $file->move( public_path() . '/uploads/userimg/', $filename );
        }

        Student::create( [ 'name'           => $request->name,
                            'email'         => $request->email,
                            'uname'         => $request->uname,
                            'mobile_number' => $request->mobile_number,
                            'date_of_birth' => $request->date_of_birth,
                            'address'       => $request->address,
                            'city'          => $request->city,
                            'state'         => $request->state,
                            'country'       => $request->country,
                            'user_image_path'=> '/uploads/userimg/'.  $filename
                        ] );

        return back()->with('success', 'Student details added sucessfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return response()->json(['success' => 'successfull retrieve data', 'data' => $student->toJson()], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {


            $objStudent = Student::findOrFail($student->id);
            $objStudent->name = $request->name;
            $objStudent->email = $request->email;
            $objStudent->mobile_number = $request->mobile_number;
            $objStudent->update();

        return back()->with('success', 'Student details updated sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
       Student::destroy($student->id);
       return response()->json(['success' => 'data is successfully deleted'], 200);
    }

    public function downloadExcelFile($type){

        $student = Student::get()->toArray();
        return \Excel::create('student-details', function($excel) use ($student) {
            $excel->sheet('sheet name', function($sheet) use ($student)
            {
                $sheet->fromArray($student);
            });
        })->download($type);
    }



public function getCustomFilterData(Request $request) {

    $student = Student::select(['id', 'name', 'email', 'uname', 'mobile_number', 'user_image_path', 'date_of_birth', 'address', 'city', 'state','country','created_at', 'updated_at'])->get();

    return Datatables::of($student)->filter(function ($instance) use ($request) {

                        if ($request->has('name')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['name'], $request->get('name')) ? true : false;
                            });
                        }

                        if ($request->has('email')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['email'], $request->get('email')) ? true : false;
                            });
                        }

                        if ($request->has('mobile_number')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['mobile_number'], $request->get('mobile_number')) ? true : false;
                            });
                        }

                        if ($request->has('created_at')) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['created_at'], $request->get('created_at')) ? true : false;
                            });
                        }
                } )->make(true);
         }

}
