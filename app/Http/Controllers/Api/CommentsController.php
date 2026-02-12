<?php

namespace App\Http\Controllers\Api;

use App\Events\Comments;
use App\Events\Push;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateCommentsRequest;
use App\Models\Agent;
use App\Models\Ticket;
use App\Models\Comment;
use Auth;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use URL;

class CommentsController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('IsAdmin', ['only' => ['edit', 'update', 'destroy']]);
        $this->middleware('IsAgent', ['only' => ['edit', 'update', 'destroy']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {


        return redirect()->route('tickets.index');//
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return redirect()->route('tickets.index');//
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCommentsRequest $commentsRequest
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCommentsRequest $commentsRequest)
    {
        try {
            DB::beginTransaction();
            $ticket = Ticket::find($commentsRequest->get('ticket_id'));
            $comment = new Comment();

            $comment->setPurifiedContent($commentsRequest->get('content'));

            $comment->ticket_id = $commentsRequest->get('ticket_id');
            $comment->user_id = Auth::user()->id;
            $comment->icon = 'fa fa-comments';
            $comment->html_notification = '<li class="media">
                <a href="' . route('tickets.show', $commentsRequest->get('ticket_id')) .'">
                    <div class="media-left"><i class="fa fa-comment media-object bg-blue"></i></div>
                    <div class="media-body">
                        <h6 class="media-heading"> Nuevo comentario</h6>
                        <p>Se ha registrado un nuevo comentario en el tiquet <u>' . $ticket->folio . '</u></p>
                        <div class="text-muted f-s-11">' . $ticket->updated_at->format('d/F/Y g:i A') . '</div>
                    </div>
                </a>
            </li>';
            $comment->save();
            $ticket = Ticket::find($comment->ticket_id);

            $newComment = Comment::where('id', $comment->id)->with('user')->get()->toArray();
            $users = $ticket->userSubs;
            $ticket->updated_at = $comment->created_at;
            $ticket->save();
            $comment->notificationUsers()->attach($users);

            foreach ($users as $user){
                event(new Push($comment,$ticket,$user));
            }

            event(new Comments($newComment[0]));

            DB::commit();

            return response()->json($newComment[0],200);
            /*
            return response()->json(['url_image' => URL::to('../storage/app/public/user/' . Auth::user()->url_image), 'name' => Auth::user()->name, 'date' => $comment->created_at->format('d/F/Y'),
                'dateHuman' => $comment->created_at->diffForHumans(), 'time' => $comment->created_at->format('g:i A'), 'icon' => 'fa fa-comments', 'msg' => $commentsRequest->get('content')]);*/
        } catch (QueryException $e){
            DB::rollBack();
            return response()->json(['message' =>  'Code: ' . $e->getCode() . '<br/>' . $e->getMessage()], 500);
        }
//        return back()->with('status', trans('lang.comment-has-been-added-ok'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return redirect()->route('tickets.index');//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        return redirect()->route('tickets.index');//
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        return redirect()->route('tickets.index');//
    }
}
