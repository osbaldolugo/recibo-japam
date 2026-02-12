<?php

namespace App\Models;

use Eloquent as Model;
use App\Models\Traits\ContentEllipse;
use App\Models\Traits\Purifiable;
use App\Models\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

class Comment extends Model
{
    use ContentEllipse;
    use Purifiable;
    use DatesTranslator;

    protected $table = 'ticketit_comments';

    public $timestamps = true;

    protected $dates = ['created_at', 'updated_at'];

    protected $primaryKey = 'id';

    public $fillable = [
        'content',
        'html',
        'html_notification',
        'icon',
        'user_id',
        'ticket_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'content' => 'string',
        'html' => 'string',
        'html_notification' => 'string',
        'icon' => 'string',
        'user_id' => 'integer',
        'ticket_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'ticket_id' => 'required|exists:ticketit,id',
        'content' => 'required|min:6'
    ];

    public static $messages = [
        'ticket_id.required' => 'Hubo un error al cargar la página, es necesario recargarla',
        'ticket_id.exists' => 'Es imposible enviar el comentario a un tiquet que no existe',
        'content.required' => 'Es necesario especificar el mensaje que sera enviado',
        'content.min' => 'Es necesario ampliar su comentario, es demasiado corto',
    ];

    /**
     * Get related ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket', 'ticket_id');
    }

    /**
     * Get comment owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Get Users to send Ticket Notification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function notificationUsers()
    {
        return $this->belongsToMany('App\User', 'ticketit_notification', 'comment_id', 'user_receipt_id');
    }

    /**
     * Returns the next folio number
     *
     * @param Ticket $ticket
     * @param [] $comment_array
     * @param Collection $users
     *
     * @return $this
     */
    public static function newComment($ticket, $comment_array, $users)
    {
        try {

            if (isset($ticket)) {
                $comment = $ticket->comments()->create($comment_array);
                $comment->notificationUsers()->attach($users);
                return $comment;
            } else {
                $comment = Comment::create($comment_array);
                $comment->notificationUsers()->attach($users);
                return $comment;
            }
        } catch (QueryException $e) {
            \Log::error('Code: ' . $e->getCode() . ' Error: ' . $e->getMessage());
            return null;
        }
    }
}
