<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int comment_id
 * @property int user_id
 */
class UserVoteComment extends Model
{
    public $timestamps = false;
}