<?php

namespace App\Http\Controllers\Api;

use DB;
use URL;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Http\Controllers\AppBaseController;
use App\Repositories\NotificationRepository;

class NotificationController extends AppBaseController
{
    //
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepo)
    {
        $this->notificationRepository = $notificationRepo;
    }
    /**
     * @api {get} /notifications/getNotifications/ Get Notifications
     * @apiVersion 1.0.0
     * @apiName getNotifications
     * @apiGroup Notification
     *
     * @apiSuccess {String[]} notifications Array with details of notifications.
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "id": "1",
     *       "title": "Test Notification"
     *       "description": "This parameter is a description."
     *       "url_image": "http://localhost/example/public/../storage/app/japam/notification/1.png"
     *       "url_info": "http://example.com/"
     *       "begin_date": "2018-01-15 00:00:00"
     *       "end_date": "2018-01-15 23:59:59"
     *     }
     *
     * @apiError NotificationsNotFound No notifications to show.
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "NotificationsNotFound"
     *     }
     */
    public function getNotifications()
    {
        $notifications = Notification::select('id', 'title', 'description', DB::raw('CONCAT("'.URL::to('../storage/app/japam/notification').'/",url_image) as url_image'), 'url_info', 'begin_date', 'end_date')
            ->whereRaw('NOW() >= begin_date AND NOW() <= end_date')
            ->orderBy('begin_date', 'desc')
            ->paginate(10);

        return $notifications;
    }
}
