<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Bagian extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'bagian';
    protected $primaryKey = 'id_bagian';
    protected $fillable = ['nama_bagian'];
}
