<?php

namespace App\Models\Relationships;

use App\Models\Comment;

/**
 * Class CommentRelationship.
 */
trait CommentRelationship
{
    /**
     * @return mixed
     */
    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
