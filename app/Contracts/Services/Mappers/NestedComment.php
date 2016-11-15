<?php
namespace App\Contracts\Services\Mappers;

use App\Models\Comment;

class NestedComment
{
    /**
     * @var Comment
     */
    public $comment;

    /**
     * @var NestedComment[]
     */
    public $childNestedComments = [];

    public function __construct(Comment $comment){
        $this->comment = $comment;
    }

    public function addChildNestedComment(NestedComment $nestedComment){
        array_push($this->childNestedComments,$nestedComment);
    }
}