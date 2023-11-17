<?php

namespace App\Http\Controllers;

use App\Models\employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kode = 200;
        $employees = Employees::all();

        if ($employees->isEmpty()) {
            $data = [
                'message' => 'Data Tidak Ditemukan'
            ];
            $kode = 404;
        } else {
            $data = [
                'message' => 'Mendapatkan Semua Data Pegawai',
                'data' => $employees
            ];
        }

        return response()->json($data, $kode);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kode = 201;
        // validasi input data yang dibutuhkan
        $input = [
            'name' => $request->name,
            'gender' => $request->gender,
            'status' => 'active',
            'hired_on' => $request->hired_on,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email
        ];

        //membuat aturan data supaya tervalidasi
        $rules = [
            'name' =>  'required',
            'gender' => 'required',
            'status' => 'required',
            'hired_on' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required'
        ];

        // create validator
        $validator = Validator::make($input, $rules);

        // check if validation fails
        if ($validator->fails()) {
            $data = [
                "status" => "error",
                "message" => "Validasi Eror",
                "errors" => $validator->errors()
            ];

            $statusCode = 400;
        } else {
            // create employee
            $employee = Employees::create($validator->validated());

            $data = [
                "status" => "Sukses",
                "message" => "Data Pegawai Berhasil Dibuat",
                "data" => $employee
            ];
        }

        // Return a collection of $employee
        return response()->json($data, $kode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kode = 200;

        $employees = Employees::find($id);

        if ($employees) {
            $data = [
                'message' => 'Mendapatkan Detail Data Pegawai',
                'data' => $employees
            ];
        } else {
            $data = [
                'message' => 'Data Tidak Ditemukan'
            ];

            $kode = 404;
        }

        return response()->json($data, $kode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kode = 200;


        $employees = Employees::find($id);

        if ($employees) {
            $input = [
                'name' => $request->name ?? $employees->name,
                'gender' => $request->gender ?? $employees->gender,
                'phone' => $request->phone ?? $employees->phone,
                'address' => $request->address ?? $employees->address,
                'email' => $request->email ?? $employees->email,
                'status' => $request->status ?? $employees->status,
                'hired_on' => $request->hired_on ?? $employees->hired_on
            ];

            $employees->update($input);

            $data = [
                'message' => 'Data Berhasil Diubah',
                'data' => $employees
            ];
        } else {
            $data = [
                'message' => 'Data Tidak Ditemukan'
            ];

            $kode = 404;
        }

        return response()->json($data, $kode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kode = 200;

        $employees = Employees::find($id);

        if ($employees) {
            $employees->delete();

            $data = [
                'message' => 'Data Pegawai Berhasil Dihapus',
                'data' => $employees
            ];
        } else {
            $data = [
                'message' => 'Data Tidak Ditemukan'
            ];

            $kode = 404;
        }

        return response()->json($data, $kode);
    }

    // Mencari resource by name
    public function search(string $name)
    {
        $kode = 200;

        $employees = Employees::where('name', 'like', '%' . $name . '%')->get();

        if ($employees) {
            $data = [
                'message' => 'Mendapatkan Hasil Data Pegawai',
                'data' => $employees
            ];
        } else {
            $data = [
                'message' => 'Data Tidak Ditemukan'
            ];

            $kode = 404;
        }
        return response()->json($data, $kode);
    }

    // Mendapatkan resource yang aktif
    public function active()
    {
        $kode = 200;

        $employees = Employees::where('status', 'active')->get();

        if ($employees) {
            $data = [
                'message' => 'Mendapatkan Data Aktif',
                'data' => $employees
            ];
        } else {
            $data = [
                'message' => 'Tidak Ditemukan'
            ];

            $kode = 404;
        }
        return response()->json($data, $kode);
    }

    // Mendapatkan resource yang tidak aktif
    public function inactive()
    {
        $kode = 200;

        $employees = Employees::where('status', 'inactive')->get();

        if ($employees) {
            $data = [
                'message' => 'Mendapatkan Data Inactive',
                'data' => $employees
            ];
        } else {
            $data = [
                'message' => 'Tidak Ditemukan'
            ];

            $kode = 404;
        }
        return response()->json($data, $kode);
    }

    // Mendapatkan resource yang diberhentikan
    public function terminated()
    {
        $kode = 200;

        $employees = Employees::where('status', 'terminated')->get();

        if ($employees) {
            $data = [
                'message' => 'Mendapatkan Data Yang Hilang',
                'data' => $employees
            ];
        } else {
            $data = [
                'message' => 'Tidak Ditemukan'
            ];

            $kode = 404;
        }
        return response()->json($data, $kode);
    }
}
