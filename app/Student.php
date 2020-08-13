<?php
/* Author - Yogesh Suryawanshi */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name', 'email', 'uname', 'mobile_number', 'user_image_path', 'date_of_birth', 'address','city','state','country'
    ];
}
