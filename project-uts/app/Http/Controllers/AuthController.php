<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $statusCode = 200;

        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        $rules = [
            'name' => 'required|max:55',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ];

        $messages = [
            'required' => ':Atribut Harus Diisi dengan Lengkap.',
            'email' => ':Atribut Email Harus Sesuai.',
            'unique' => ':Atribut Sudah Tersedia.'
        ];

        $customAttributes = [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Password'
        ];

        $validator = Validator::make($input, $rules, $messages, $customAttributes);


        if ($validator->fails()) {
            $data = [
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ];

            $statusCode = 400;
        } else {
            $user = User::create($validator->validated());

            $data = [
                'message' => 'Akun Berhasil Dibuat',
                'user' => $user
            ];
        }


        return response()->json($data, $statusCode);
    }

    public function login(Request $request)
    {
        $statusCode = 200;

        $input = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $messages = [
            'email.required' => 'Email harus di isi.',
            'email.email' => 'Email harus valid.',
            'password.required' => 'Password harus di isi.'
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error',
                'errors' => $validator->errors()
            ];

            return response()->json($data, 400);
        } else {

            $user = User::where('email', $input['email'])->first();

            if (!$user || !Hash::check($input['password'], $user->password)) {

                $data = [
                    'message' => 'Akun Salah',
                ];
                $statusCode = 401;
            } else {
                $token = $user->createToken('auth_token')->plainTextToken;

                $data = [
                    'message' => 'Berhasil Login',
                    'user' => $user,
                    'token' => $token
                ];
            }
        }



        return response()->json($data, $statusCode);
    }
}