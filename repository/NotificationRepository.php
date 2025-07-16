<?php
require_once '../util/database.php';

function insertNotification($data)
{
    $pdo = getConnection();
    $sql = "INSERT INTO Notification (userId, title, description, dateTime, read)
            VALUES (:userId, :title, :description, :dateTime, :read)";
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([
        ':userId' => $data['userId'],
        ':title' => $data['title'],
        ':description' => $data['description'],
        ':dateTime' => $data['dateTime'],
        ':read' => $data['read'] ? 1 : 0,
    ]);
    return $success ? $pdo->lastInsertId() : false;
}

function findNotificationById($id)
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT * FROM Notification WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function findAllNotifications()
{
    $pdo = getConnection();
    $stmt = $pdo->query("SELECT * FROM Notification ORDER BY dateTime DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateNotificationById($data)
{
    $pdo = getConnection();
    $sql = "UPDATE Notification SET
                userId = :userId,
                title = :title,
                description = :description,
                dateTime = :dateTime,
                read = :read
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':userId' => $data['userId'],
        ':title' => $data['title'],
        ':description' => $data['description'],
        ':dateTime' => $data['dateTime'],
        ':read' => $data['read'] ? 1 : 0,
        ':id' => $data['id'],
    ]);
}

function markNotificationAsRead($id)
{
    $pdo = getConnection();
    $sql = "UPDATE Notification SET read = 1 WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([':id' => $id]);
}


function deleteNotificationById($id)
{
    $pdo = getConnection();
    $stmt = $pdo->prepare("DELETE FROM Notification WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}
