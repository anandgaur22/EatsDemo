<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRegister extends Model
{
    //
    protected $table='user_register';
    protected $fillable=['user_id','name','email','mobile_no'];
}
