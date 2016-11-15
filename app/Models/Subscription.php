<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @property Article article
 */
class Subscription extends Model
{
    public $timestamps = false;

    public function article(){
        return $this->belongsTo(Article::class,'article_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}