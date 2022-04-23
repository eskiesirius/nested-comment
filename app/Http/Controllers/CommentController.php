<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\Comment\ReplyCommentRequest;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Services\CommentService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommentController extends Controller
{
    /**
     * @var CommentService
     */
    protected $commentService;

    /**
     * CommentController constructor.
     *
     * @param  CommentService   $commentService
     */
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Inertia
     */
    public function index()
    {
        return Inertia::render('Comment/Index',[
            'comments' => CommentResource::collection($this->commentService->getComments())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCommentRequest  $request
     * @return Inertia
     */
    public function store(StoreCommentRequest $request)
    {
        $this->commentService->store($request->validated());

        return redirect()->back();
    }

    /**
     * Reply Comment
     *
     * @param  ReplyCommentRequest  $request
     * @param  Comment $comment
     * @return Inertia
     */
    public function reply(ReplyCommentRequest $request, Comment $comment)
    {
        $this->commentService->reply($request->validated(),$comment);

        return redirect()->back();
    }
}
