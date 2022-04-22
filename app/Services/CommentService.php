<?php

namespace App\Services;

use App\Models\Comment;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class CommentService.
 */
class CommentService extends BaseService
{

	/**
	 * CommentService constructor.
	 *
	 * @param Comment $comment
	 */
	public function __construct(Comment $comment)
	{
		$this->model = $comment;
	}

    /**
     * @return Comment Collection 
     */
    public function getComments()
    {
        return $this->model->where('parent_id',null)->latest()->get();
    }

    /**
     * @param  array $data
     *
     * @return Comment
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): Comment
    {
        DB::beginTransaction();

        try {
            $comment = $this->createComment([
                'parent_id' => null,
                'name'      => $data['name'],
                'body'      => $data['body'],
                'depth'     => 0,
            ]);        
        } catch (Exception $e) {
            DB::rollBack();
            
            abort(500);
        }

        DB::commit();

        return $comment;
    }

    /**
     * @param  array $data
     *
     * @return Comment
     * @throws GeneralException
     * @throws \Throwable
     */
    public function reply(array $data = [], Comment $comment): Comment
    {
        DB::beginTransaction();

        try {
            $comment = $this->createComment([
                'parent_id' => $comment->id,
                'name'      => $data['name'],
                'body'      => $data['body'],
                'depth'     => $comment->depth + 1,
            ]);        
        } catch (Exception $e) {
            DB::rollBack();
            
            abort(500);
        }

        DB::commit();

        return $comment;
    }

    /**
     * @param  array  $data
     *
     * @return Comment
     */
    protected function createComment(array $data = []): Comment
    {
        return $this->model::create([
            'parent_id' => $data['parent_id'] ?? null,
            'name'      => $data['name'] ?? null,
            'body'      => $data['body'] ?? null,
            'depth'     => $data['depth'] ?? 0,
        ]);
    }
}
