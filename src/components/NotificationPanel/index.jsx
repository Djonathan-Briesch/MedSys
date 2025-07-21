import {
  Panel,
  PanelHeader,
  PanelTitle,
  CloseButton,
  NotificationItem,
  NotificationTitle,
  NotificationMessage,
  NotificationTime,
  EmptyMessage
} from './styles'

export const NotificationsPanel = ({
  notifications,
  onMarkAsRead,
  onClose
}) => {
  const formatDate = (dateString) => {
    const options = {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    }
    return new Date(dateString).toLocaleDateString('pt-BR', options)
  }

  const handleNotificationClick = (notification) => {
    if (!(notification.read || notification.readFlag)) {
      onMarkAsRead(notification.id)
    }
  }

  return (
    <Panel>
      <PanelHeader>
        <PanelTitle>Notificações</PanelTitle>
        <CloseButton onClick={onClose}>×</CloseButton>
      </PanelHeader>

      {notifications.length === 0 ? (
        <EmptyMessage>Nenhuma notificação</EmptyMessage>
      ) : (
        notifications.map((notification) => (
          <NotificationItem
            key={notification.id}
            unread={!(notification.read || notification.readFlag)}
            onClick={() => handleNotificationClick(notification)}
          >
            <NotificationTitle unread={!(notification.read || notification.readFlag)}>
              {notification.title}
            </NotificationTitle>
            <NotificationMessage>{notification.description}</NotificationMessage>
            <NotificationTime>{formatDate(notification.dateTime)}</NotificationTime>
          </NotificationItem>
        ))
      )}
    </Panel>
  )
}
