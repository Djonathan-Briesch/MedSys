import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import logoImage from '../../assets/a.jpeg';
import { NotificationBell } from '../NotificationBell';
import { NotificationsPanel } from '../NotificationPanel';
import { 
  HeaderContainer,
  LogoContainer,
  LogoImage,
  LogoText,
  RightContainer,
  ButtonGroup,
  NavButton
 } from "./styles";


export const Header = () => {
  const navigate = useNavigate();
  const [notifications, setNotifications] = useState([]);
  const [showNotifications, setShowNotifications] = useState(false);

  // TOOD: CONSULTA API
  useEffect(() => {
    const mockNotifications = [
      {
        id: 1,
        title: "Consulta confirmada",
        message: "Sua consulta com Dr. Carlos Silva foi confirmada para 15/03 às 10h",
        read: false,
        date: "2023-03-10T14:30:00",
        type: "confirmation"
      },
      {
        id: 2,
        title: "Lembrete de consulta",
        message: "Você tem uma consulta amanhã com Dra. Ana Oliveira às 14h",
        read: false,
        date: "2023-03-14T09:15:00",
        type: "reminder"
      },
      {
        id: 3,
        title: "Resultado de exames",
        message: "Seus exames de sangue estão disponíveis para visualização",
        read: true,
        date: "2023-03-08T16:45:00",
        type: "results"
      }
    ];
    setNotifications(mockNotifications);
  }, []);

  const toggleNotifications = () => {
    setShowNotifications(!showNotifications);
  };

  const markAsRead = (id) => {
    setNotifications(notifications.map(notification => 
      notification.id === id ? { ...notification, read: true } : notification
    ));
  };

  const unreadCount = notifications.filter(n => !n.read).length;

  return (
    <HeaderContainer>
      <LogoContainer onClick={() => navigate('/')}>
        <LogoImage src={logoImage} alt="Logo da Clínica" />
        <LogoText>MediCare</LogoText>
      </LogoContainer>

      <RightContainer>
        <ButtonGroup>
          <NavButton onClick={() => navigate('/consultas')}>Consultas</NavButton>
          <NavButton primary onClick={() => navigate('/agendamentos')}>Agendamentos</NavButton>
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
  );
};