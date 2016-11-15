<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string  media
 * @property \DateTime | string valid_until
 * @property User user
 * @property string token
 * @property int id
 */
class ConfirmationToken extends Model
{
    const MEDIA_TWITTER = 'twitter';
    const MEDIA_FACEBOOK = 'facebook';

    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function isTwitter(){
        return $this->media == self::MEDIA_TWITTER;
    }

    public function isFacebook(){
        return $this->media == self::MEDIA_FACEBOOK;
    }

}
