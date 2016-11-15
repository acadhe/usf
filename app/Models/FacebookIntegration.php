<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string facebook_id
 * @property string facebook_name
 * @property string facebook_access_token
 * @property string facebook_access_token_expires_at
 * @property string facebook_photo_url
 */
class FacebookIntegration extends Model
{
    public $timestamps = false;

    public function confirmationToken(){
        return $this->belongsTo(ConfirmationToken::class,'confirmation_token_id','id');
    }
}
