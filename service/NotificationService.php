<?php
require_once '../repository/NotificationRepository.php';
require_once '../entity/Notification.php';

function createNotification($data) {
    foreach (['userId', 'title', 'description'] as $field) {
        if (empty($data[$field])) {
            return ['data' => "$field is required", 'status' => 400];
        }
    }

    $id = insertNotification($data);
    if ($id === false) {
        return ['data' => 'Failed to create notification', 'status' => 500];
    }

    return ['data' => ['id' => $id], 'status' => 201];
}

function getNotificationById($id) {
    $row = findNotificationById($id);
    if (!$row) {
        return ['data' => 'Notification not found', 'status' => 404];
    }

    $notification = new Notification(
        $row['id'],
        $row['userId'],
        $row['title'],
        $row['description'],
        $row['dateTime'],
        (bool)$row['read']
    );

    return ['data' => $notification, 'status' => 200];
}

function getAllNotifications() {
    $rows = findAllNotifications();
    return ['data' => $rows, 'status' => 200];
}

function getNotificationsByUserId($userId) {
    if (empty($userId)) {
        return ['data' => 'UserId is required', 'status' => 400];
    }

    $rows = findNotificationsByUserId($userId);
    return ['data' => $rows, 'status' => 200];
}


function updateNotification($data) {
    if (empty($data['id'])) {
        return ['data' => 'ID is required', 'status' => 400];
    }

    $success = updateNotificationById($data);
    return ['data' => $success ? 'Updated' : 'Not updated', 'status' => $success ? 200 : 500];
}

function markAsRead($id) {
    if (empty($id)) {
        return ['data' => 'ID is required', 'status' => 400];
    }
    $success = markNotificationAsRead($id);
    return ['data' => $success ? 'Notification marked as read' : 'Failed to update', 'status' => $success ? 200 : 500];
}

function deleteNotification($id) {
    if (empty($id)) {
        return ['data' => 'ID is required', 'status' => 400];
    }

    $success = deleteNotificationById($id);
    return ['data' => $success ? 'Deleted' : 'Not found', 'status' => $success ? 200 : 404];
}
