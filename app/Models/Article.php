<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string title
 * @property string content
 * @property string category
 * @property int id
 * @property int shares_count
 * @property int comments_count
 * @property int user_id
 * @property boolean open
 * @property string privacy
 * @property string header_image_url
 * @property integer votes_count
 * @property int bookmarks_count
 * @property User user
 * @property string summary
 */
class Article extends Model
{
    const PRIVACY_DRAFT = "draft";
    const PRIVACY_PUBLISHED = "published";

    public function user(){
        return $this->belongsTo(User::class,"user_id","id");
    }

    public function comments()
    {
        return $this->hasMany(Comment::class,"article_id","id");
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class,"article_id","id");
    }
}