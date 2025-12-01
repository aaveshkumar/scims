<?php

class NotificationController
{
    private $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new Notification();
    }

    public function index($request)
    {
        $userId = auth()['id'];
        $notifications = $this->notificationModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit(50)
            ->get();

        return view('notifications.index', ['notifications' => $notifications]);
    }

    public function unread($request)
    {
        $userId = auth()['id'];
        $unreadCount = $this->notificationModel->getUnreadCount($userId);
        $notifications = $this->notificationModel->getUnreadNotifications($userId);

        return responseJSON([
            'count' => $unreadCount,
            'notifications' => $notifications
        ]);
    }

    public function markAsRead($request, $id)
    {
        try {
            $notification = $this->notificationModel->find($id);
            
            if (!$notification || $notification['user_id'] != auth()['id']) {
                return responseJSON(['success' => false, 'message' => 'Notification not found'], 404);
            }

            $notificationObj = new Notification();
            foreach ($notification as $key => $value) {
                $notificationObj->$key = $value;
            }
            $notificationObj->markAsRead();

            return responseJSON(['success' => true, 'message' => 'Notification marked as read']);
        } catch (Exception $e) {
            return responseJSON(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function markAllAsRead($request)
    {
        try {
            $notificationObj = new Notification();
            $notificationObj->markAllAsRead(auth()['id']);

            return responseJSON(['success' => true, 'message' => 'All notifications marked as read']);
        } catch (Exception $e) {
            return responseJSON(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function send($request)
    {
        if (!hasRole('admin')) {
            return responseJSON(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $rules = [
            'user_id' => 'required|numeric',
            'title' => 'required',
            'message' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            return responseJSON(['success' => false, 'message' => 'Validation failed'], 400);
        }

        try {
            Notification::send(
                $request->post('user_id'),
                $request->post('title'),
                $request->post('message'),
                $request->post('type', 'info'),
                $request->post('link')
            );

            return responseJSON(['success' => true, 'message' => 'Notification sent successfully']);
        } catch (Exception $e) {
            return responseJSON(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
