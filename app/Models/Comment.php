<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int article_id
 * @property int user_id
 * @property string support
 * @property string content
 * @property int replied_comment_id
 * @property bool show
 * @property int id
 * @property int votes_count
 * @property User user
 * @property Article article
 */
class Comment extends Model
{
    const SUPPORT_PRO = 'pro';
    const SUPPORT_CONTRA = 'contra';
    const SUPPORT_REPLY_COMMENT = 'reply_comment';

    public function userVoteComments(){
        return $this->hasMany(UserVoteComment::class,"comment_id","id");
    }

    public function user(){
        return $this->belongsTo(User::class,"user_id","id");
    }

    public function article(){
        return $this->belongsTo(Article::class,'article_id','id');
    }
    
    public function repliedComment(){
        return $this->belongsTo(Comment::class,'replied_comment_id','id');
    }
}