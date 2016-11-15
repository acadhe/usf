<?php

namespace App\Models;

use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ResetPasswordToken
 * @property DateTime valid_until
 * @property string token
 * @package App\Models
 * @property User user
 */
class ResetPasswordToken extends Model
{
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }


}
