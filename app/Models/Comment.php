<?php

namespace App\Models;

use App\Models\Relationships\CommentRelationship;;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    use CommentRelationship;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    	'parent_id',
    	'name',
    	'body',
    	'depth'
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'replies',
    ];
}
