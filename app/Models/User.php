<?php

namespace App\Models;

use DateTime;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;

/**
 * @property string name
 * @property string type
 * @property string twitter_id
 * @property string facebook_id
 * @property integer id
 * @property string password
 * @property string email
 * @property string google_plus_id
 * @property string photo_url
 * @property string tagline
 * @property string description
 * @property string twitter_name
 * @property string facebook_name
 * @property string google_plus_name
 * @property string twitter_oauth_token
 * @property string twitter_oauth_token_secret
 * @property string facebook_access_token
 * @property DateTime facebook_access_token_expires_at
 * @property Article[] articles
 */
class User extends Authenticatable
{
    public $timestamps = false;
    const TYPE_USER = 'user';
    const TYPE_PANELIST = 'panelist';
    const TYPE_ADMIN = 'admin';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin(){
        return $this->type == self::TYPE_ADMIN;
    }

    public function isPanelist(){
        return $this->type == self::TYPE_PANELIST;
    }

    public function isUser(){
        return $this->type == self::TYPE_USER;
    }

    public function hasTwitter(){
        return $this->twitter_id != null;
    }

    public function hasFacebook(){
        return $this->facebook_id != null;
    }

    public function hasGooglePlus(){
        return $this->google_plus_id != null;
    }

    public function minRole($role){
        if($role == self::TYPE_ADMIN){
            return $this->isAdmin();
        } else if ($role == self::TYPE_PANELIST){
            return $this->isAdmin() || $this->isPanelist();
        } else {
            return true;
        }
    }

    public function bookmarkedArticles(){
        return $this->belongsToMany(Article::class,'bookmarks','user_id','article_id');
    }

    public function articles(){
        return $this->hasMany(Article::class,'user_id','id');
    }

}
