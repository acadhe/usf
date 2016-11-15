<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string  twitter_id
 * @property string twitter_name
 * @property string twitter_oauth_token
 * @property string twitter_oauth_token_secret
 * @property string twitter_photo_url
 */
class TwitterIntegration extends Model
{
    public $timestamps = false;

    public function confirmationToken()
    {
        return $this->belongsTo(ConfirmationToken::class,'confirmation_token_id','id');
    }
}
