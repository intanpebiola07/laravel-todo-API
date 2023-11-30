<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todo::all();
        
        if ($todos->count () > 0) {
            return response()->json([
                'status' => true,
                'data' => $todos
            ], 200);
        }else{
            return response()->json([
                'status' => true,
                'message' => 'Data todo tidak ada.'
            ], 404);
        }

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //initial value
        $status = false;
        $message = '';
        
        //validation
        $validator = Validator::make($request->all(),[
            'title' => 'required|max:100|unique:todos',
            'description' => 'required|max:180'
        ],[
            'title.required' => 'Judul Todo harus diisi.',
            'title.max' => 'Judul Todo maksimul 60 karakter',
            'title.unique' => 'Judul Todo sudah ada',
            'description.required' => 'Deskripsi Todo harus diisi.',
            'description.max' => 'Deskripsi Todo maksimum 180 karakter'
        ]
    );

        //creating
        if ($validator->fails()){
            $status = false;
            $message = $validator->errors();

             //sending response 
        return response()->json([
            'status' => $status,
            'message' => $message
        ], 400);
        } else {
            $status = true;
            $message ='Data todo berhasil ditambah.';

            $todo = new Todo();
            $todo->title = $request->title;
            $todo->description = $request->description;
            $todo->save();
        }

        //sending response 
        return response()->json([
            'status' => $status,
            'message' => $message
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        //
    }
}
