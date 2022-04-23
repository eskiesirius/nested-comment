<?php

namespace App\Models\Relationships;

use App\Models\Comment;

/**
 * Class CommentRelationship.
 */
trait CommentRelationship
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
