<?php

namespace App\Http\Controllers;

use DB;
use Flash;
use Storage;
use Response;
use App\Http\Requests;
use App\Models\Notification;
use App\DataTables\NotificationDataTable;
use App\Repositories\NotificationRepository;
use App\Http\Requests\CreateNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;

class NotificationController extends AppBaseController
{
    /** @var  NotificationRepository */
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepo)
    {
        $this->notificationRepository = $notificationRepo;
    }

    /**
     * Display a listing of the Notification.
     *
     * @param NotificationDataTable $notificationDataTable
     * @return Response
     */
    public function index(NotificationDataTable $notificationDataTable)
    {
        return $notificationDataTable->render('notifications.index');
    }

    /**
     * Show the form for creating a new Notification.
     *
     * @return Response
     */
    public function create()
    {
        return view('notifications.create')
            ->with('showDateImage', true);
    }

    /**
     * Store a newly created Notification in storage.
     *
     * @param CreateNotificationRequest $request
     *
     * @return Response
     */
    public function store(CreateNotificationRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $beginDate = str_replace('/', '-', $request['begin_date']);
            $endDate = str_replace('/', '-', $request['end_date']);

            $notification = Notification::create([
                'title'=> $request['title'],
                'description'=> $request['description'],
                'url_info'=> $request['url_info'],
                'begin_date'=> $beginDate.' 00:00:00',
                'end_date'=> $endDate.' 23:59:59'
            ]);

            $file = $request->file('image');
            $imageName = $notification->id.".".$file->getClientOriginalExtension();

            $imageRoute = 'japam/notification/' . $imageName;
            Storage::put($imageRoute, file_get_contents($file));

            $notification->url_image = $imageName;
            $notification->save();

            $request['url_image'] = $notification->url_image;
            $this->sendNotification($request);
            DB::commit();
            return response()->json(['message' => 'Notificación enviada correctamente.'], 200);
        } catch (QueryException $e) {
            DB::rollback();
            return response()->json(['message' => 'Ocurrió un error al enviar la notificación: ' . $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified Notification.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('notifications.index'));
        }

        return view('notifications.show')->with('notification', $notification);
    }

    /**
     * Show the form for editing the specified Notification.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('notifications.index'));
        }

        return view('notifications.edit')->with('notification', $notification);
    }

    /**
     * Update the specified Notification in storage.
     *
     * @param  int              $id
     * @param UpdateNotificationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNotificationRequest $request)
    {
        $notification = $this->notificationRepository->findWithoutFail($id);
        if (empty($notification)) {
            return response()->json(['message' => 'Notificación no encontrada, imposible actualizar.'], 404);
        }

        try
        {
            DB::beginTransaction();
            $notification->update([
                'title'=> $request['title'],
                'description'=> $request['description'],
                'url_info'=> $request['url_info'],
            ]);

            //$notification->save();
            DB::commit();
            return response()->json(['message' => 'Notificación actualizada correctamente.'], 200);
        } catch (QueryException $e) {
            DB::rollback();
            return response()->json(['message' => 'Ocurrió un error al actualizar la notificación: ' . $e->getMessage()], 422);
        }
    }

    /**
     * Remove the specified Notification from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $notification = $this->notificationRepository->findWithoutFail($id);
        if (empty($notification)) {
            return response()->json(['message' => 'Notificación no encontrada.'], 404);
        }

        Storage::delete('japam/notification/' . $notification->url_image);
        $this->notificationRepository->delete($id);

        return response()->json(['message' => 'Notificación eliminada exitosamente.'], 200);
    }

    public function sendNotification($request)
    {
        $fields = [
            'app_id' => "ff545ce9-8a94-4d5b-97a6-51c6352b02e4",
            'included_segments' => [ 'All' ],
            'data' =>  [
                'title' => $request['title'],//'Centro Civico San Juan del Río.',
                'description' => $request['description'],//'',//'Te recordamos que el nuevo Centro Cívico ya está funcionando para ofrecerte un mejor servicio.',
                'urlImage' => url('../storage/app/japam/notification').'/'.$request['url_image'],
                'urlInfo' => $request['url_info'],
            ],
            'headings' => ['en'=>$request['titlePush']],
            'contents' => ['en' => $request['bodyPush']],
            'big_picture' => url('../storage/app/japam/notification').'/'.$request['url_image'],
        ];
        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic MTcxYTk4MGYtZmUzZS00YjI3LWJiYjktNzYzYzUzZDM3ZDcw'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }



    public function sendNotification2(){
        $url = 'https://fcm.googleapis.com/fcm/send';
        $firebaseAPIKey = 'AAAAmuPYJ8w:APA91bGk9SojO65I-7pnMrGTbBgW-UWdK6BiyQRK9-ICrNkaRCuTLzlQ9EL6I6Xl70CZnJyRfeBDDaFq3ZGRHoRdZ2issXSx9VpZVjZp2b3S6pSJlm__v__ORCFdmhnDziTumVkPlCwE';
        $fields = array(
            'priority' => 'high',
            'to' => 'ewBhiEq28J4:APA91bFd5L_oPvrhr8dpqqwo-7nqPe3OOiaUAXYXG0NMFtn5UHyu-5w_IxOFnVorJl3-9Cs3wlyNdDra4FjIxJ8SxYV1SzdmZuAWorU58YyhK4HMCabDPOZ71KA1eQw_YjyLJQRGDbM_',
            'notification' => [
                'sound' => 'default',
                'body' => 'Te invitamos al Centro Civico San Juan del Río.',
                'title' => 'Atención',
                'icon' => 'push_icon',
            ],
            'data' => [
                'title' => 'Centro Civico San Juan del Río.',
                'description' => '',
                'urlImage' => 'https://instagram.fgdl5-2.fna.fbcdn.net/vp/ec18bbafbe3fb8efeb9a2e8455f43723/5B339283/t51.2885-15/e35/26153235_2003293226611220_2582051943702593536_n.jpg',
                'urlInfo' => 'http://record.com.mx',
                'redirect' => false//indica si al recibir la notificacion redirecciona a la seccion de notificaciones o muestra el modals con la informacion
            ],
        );

        $headers = array(
            'Authorization: key=' . $firebaseAPIKey,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        return $result;
    }

}
