<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class users extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'document_number',
        'password'
    ];


    public function generateToken()
    {
$this->api_token =Str::random();
$this->save();
return $this->api_token;
    }
}
