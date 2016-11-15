<?php

namespace App\Services\Repositories;

use App\Contracts\Repositories\UserRepository;
use App\Models\Article;
use App\Models\Bookmark;
use App\Models\UserVoteArticle;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Collection;


class UserRepositoryImpl implements UserRepository
{
    public function save(User $user)
    {
        return $user->save();
    }

    public function delete(User $user)
    {
        return $user->delete();
    }

    public function findByFacebookId($id)
    {
        return User::where('facebook_id','=',$id)->first();
    }

    public function findByEmail($email)
    {
        return User::where('email','=',$email)->first();
    }

    public function findByTwitterId($twitter_id)
    {
        return User::where('twitter_id','=',$twitter_id)->first();
    }

    public function findByGooglePlusId($gplusid)
    {
        return User::where('google_plus_id','=',$gplusid)->first();
    }

    public function findById($id)
    {
        return User::where('id','=',$id)->first();
    }

    public function findAllByNotType($type)
    {
        return User::where('type','!=',$type)->get();
    }

    public function findAllByType($type)
    {
        return User::where('type','=',$type)->get();
    }

    public function findAllByArticleSubscriber(Article $article)
    {
        $subscriptions = Subscription::where('article_id','=',$article->id)->with(['user'])->get();
        $users = new Collection();
        foreach ($subscriptions as $subscription){
            $users->push($subscription->user);
        }
        return $users;
    }

    public function findAllByNameLikeAndType($name, $type)
    {
        return User::where('name','LIKE',"%{$name}%")->where('type','=',$type)->get();
    }

    public function findAll()
    {
        return User::all();
    }

    public function findAllByNameLike($name)
    {
        return User::where('name','LIKE',"%{$name}%")->get();
    }

    public function findAllByArticleBookmarker(Article $article)
    {
        $users = new Collection();
        $bookmarks = Bookmark::where('article_id','=',$article->id)->with(['user'])->get();
        foreach($bookmarks as $bookmark){
            $users->push($bookmark->user);
        }
        
        $voters = UserVoteArticle::where('article_id','=',$article->id)->with(['user'])->get();
    		foreach($voters as $vote){
    				if(!$users->search($vote->user)) $users->push($vote->user);
    		}
        return $users;
    }
}
