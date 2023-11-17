<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employees extends Model
{
    use HasFactory;
    //untuk menghubungkan tabel dengan database
    protected $table = 'employees';

    //kolom yang bisa diisi
    protected $fillable = ['name', 'gender', 'phone', 'address', 'email', 'status', 'hired_on'];
}
