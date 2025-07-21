import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import logoImage from '../../assets/a.jpeg'
import { NotificationBell } from '../NotificationBell'
import { NotificationsPanel } from '../NotificationPanel'
import {
  HeaderContainer,
  LogoContainer,
  LogoImage,
  LogoText,
  RightContainer,
  ButtonGroup,
  NavButton
} from './styles'

import { fetchNotifications, markNotificationAsRead } from './apiAccess.js'

export const Header = () => {
  const navigate = useNavigate()
  const [notifications, setNotifications] = useState([])
  const [showNotifications, setShowNotifications] = useState(false)

  useEffect(() => {
    async function loadNotifications() {
      const notifs = await fetchNotifications()
      console.log('Notificações carregadas:', notifs)
      setNotifications(notifs)
    }
    loadNotifications()
  }, [])

  const toggleNotifications = () => {
    setShowNotifications(!showNotifications)
  }

  const markAsRead = async (id) => {
    const result = await markNotificationAsRead(id)
    if (result) {
      setNotifications(
        notifications.map((notification) =>
          notification.id === id
            ? { ...notification, read: true }
            : notification
        )
      )
    }
  }

  const unreadCount = notifications.filter((n) => !n.read).length

  return (
    <HeaderContainer>
      <LogoContainer onClick={() => navigate('/dashboard')}>
        <LogoImage src={logoImage} alt="Logo da Clínica" />
        <LogoText>MedSys</LogoText>
      </LogoContainer>

      <RightContainer>
        <ButtonGroup>
          <NavButton onClick={() => navigate('/consultas')}>
            Consultas
          </NavButton>
          <NavButton primary onClick={() => navigate('/agendamentos')}>
            Agendamentos
          </NavButton>
        </ButtonGroup>

        <NotificationBell
          unreadCount={unreadCount}
          onClick={toggleNotifications}
        />
      </RightContainer>

      {showNotifications && (
        <NotificationsPanel
          notifications={notifications}
          onMarkAsRead={markAsRead}
          onClose={() => setShowNotifications(false)}
        />
      )}
    </HeaderContainer>
  )
}
