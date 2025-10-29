<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use CodeIgniter\Controller;

class Notifications extends Controller
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    /**
     * Get notifications via AJAX
     */
    public function get()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ])->setStatusCode(401);
        }

        $userId = session()->get('id');

        try {
            $unreadCount = $this->notificationModel->getUnreadCount($userId);
            $notifications = $this->notificationModel->getNotificationsForUser($userId);

            return $this->response->setJSON([
                'status' => 'success',
                'unreadCount' => $unreadCount,
                'notifications' => $notifications
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Get Notifications Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to fetch notifications'
            ])->setStatusCode(500);
        }
    }

    /**
     * Mark notification as read
     */
    public function mark_as_read($id)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ])->setStatusCode(401);
        }

        $userId = session()->get('id');

        try {
            // Verify the notification belongs to the current user
            $notification = $this->notificationModel->find($id);
            
            if (!$notification) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Notification not found'
                ])->setStatusCode(404);
            }

            if ($notification['user_id'] != $userId) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ])->setStatusCode(403);
            }

            if ($this->notificationModel->markAsRead($id)) {
                // Get updated unread count
                $unreadCount = $this->notificationModel->getUnreadCount($userId);

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Notification marked as read',
                    'unreadCount' => $unreadCount
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to mark notification as read'
                ])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Mark as Read Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'An error occurred'
            ])->setStatusCode(500);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function mark_all_as_read()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized'
            ])->setStatusCode(401);
        }

        $userId = session()->get('id');

        try {
            if ($this->notificationModel->markAllAsRead($userId)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'All notifications marked as read'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to mark notifications as read'
                ])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Mark All as Read Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'An error occurred'
            ])->setStatusCode(500);
            }
    }
}