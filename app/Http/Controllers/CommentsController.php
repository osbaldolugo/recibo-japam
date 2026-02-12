<?php

namespace App\Http\Controllers;

use App\Events\Comments;
use App\Events\Push;
use App\Http\Requests\CreateCommentsRequest;
use App\Models\Agent;
use App\Models\Ticket;
use App\Models\Comment;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Jenssegers\Date\Date;
use Storage;
use URL;

class CommentsController extends Controller
{
    public function __construct()
    {
        //$this->middleware('IsAdmin', ['only' => ['edit', 'update', 'destroy']]);
        //$this->middleware('ResAccess', ['only' => 'store']);
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(CreateCommentsRequest $commentsRequest)
    {
        try {
            DB::beginTransaction();
            $ticket = Ticket::find($commentsRequest->get('ticket_id'));
            $date = new Date(Carbon::now());
            $comment = new Comment();

            $comment->setPurifiedContent($commentsRequest->get('content'));

            $comment->ticket_id = $commentsRequest->get('ticket_id');
            $comment->user_id = Auth::user()->id;
            $comment->icon = 'fa fa-comments';
            $comment->html_notification = '<li class="media">
                <a href="' . route('tickets.show', $commentsRequest->get('ticket_id')) . '">
                    <div class="media-left"><i class="fa fa-comment media-object bg-blue"></i></div>
                    <div class="media-body">
                        <h6 class="media-heading"> Nuevo comentario</h6>
                        <p>Se ha registrado un nuevo comentario en el tiquet <u>' . $ticket->folio . '</u></p>
                        <div class="text-muted f-s-11">' . $date->format('d/F/Y g:i A') . '</div>
                    </div>
                </a>
            </li>';
            $comment->save();
            //$ticket = Ticket::find($comment->ticket_id);
            $newComment = Comment::where('id', $comment->id)->with('user')->get()->toArray();
            $users = $ticket->userSubs;
            $ticket->updated_at = $comment->created_at;
            $ticket->save();
            $comment->notificationUsers()->attach($users);

            foreach ($users as $user) {
                event(new Push($comment, $ticket, $user));
            }

            event(new Comments($newComment[0]));
            DB::commit();

            return response()->json(['url_image' => URL::to('../storage/app/public/user/' . Auth::user()->url_image), 'name' => Auth::user()->name, 'date' => $comment->created_at->format('d/F/Y'),
                'dateHuman' => $comment->created_at->format('l'), 'lastActivity' => $comment->created_at->format('d/F/Y h:i:s a'), 'time' => $comment->created_at->format('g:i A'), 'icon' => 'fa fa-comments', 'msg' => $commentsRequest->get('content')]);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Code: ' . $e->getCode() . '<br/>' . $e->getMessage()], 500);
        }
//        return back()->with('status', trans('lang.comment-has-been-added-ok'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function sendImage(Request $request)
    {
        try {
            $ticket_id = $request->get('image_ticket_id');
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                $path = 'public/comments/' . $ticket_id . '/';
                $img = '';
                $files_array = [];
                foreach ($files as $file) {
                    $fileName = uniqid('image-', true) . '.' . $file->getClientOriginalExtension();
                    Storage::put($path . $fileName, file_get_contents($file));
                    $img .= '<img src="' . URL::to('/../storage/app/' . $path . $fileName) . '" />';
                    $files_array[] = ['thumbnailUrl' => URL::to('/../storage/app/' . $path . $fileName), 'name' => $fileName, 'size' => $file->getSize()];
                }
                $ticket = Ticket::find($ticket_id);
                $date = new Date(Carbon::now());
                DB::beginTransaction();
                $comment = Comment::create([
                    'content' => 'Se ha agregado una imagen',
                    'html' => $img,
                    'ticket_id' => $ticket_id,
                    'user_id' => Auth::user()->id,
                    'icon' => 'fa fa-comments',
                    'html_notification' => '<li class="media">
                            <a href="' . route('tickets.show', $ticket_id) . '">
                                <div class="media-left"><i class="fa fa-comment media-object bg-blue"></i></div>
                                <div class="media-body">
                                    <h6 class="media-heading"> Nuevo comentario</h6>
                                    <p>Se ha registrado un nuevo comentario en el tiquet <u>' . $ticket->folio . '</u></p>
                                    <div class="text-muted f-s-11">' . $date->format('d/F/Y g:i A') . '</div>
                                </div>
                            </a>
                        </li>'
                ]);
                $newComment = Comment::where('id', $comment->id)->with('user')->get()->toArray();
                $users = $ticket->userSubs;
                $ticket->updated_at = $comment->created_at;
                $ticket->save();
                $comment->notificationUsers()->attach($users);

                foreach ($users as $user) {
                    event(new Push($comment, $ticket, $user));
                }

                event(new Comments($newComment[0]));
                DB::commit();
                return response()->json(['files' => $files_array], 200);
            } else {
                return response()->json(['files' => [0 => ['error' => 'No fue posible subir el archivo']]], 200);
            }
        } catch (QueryException $e) {
            DB::rollBack();
            \Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['message' => 'Code: ' . $e->getCode() . ' Message: ' . $e->getMessage()], 422);
        }
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
     * @param int $id
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
