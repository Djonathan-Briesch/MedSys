import { BellContainer, Badge } from './styles'

export const NotificationBell = ({ unreadCount, onClick }) => {
  return (
    <BellContainer onClick={onClick}>
      🔔
      {unreadCount > 0 && <Badge>{unreadCount}</Badge>}
    </BellContainer>
  )
}
