import styled from 'styled-components';

export const Panel = styled.div`
  position: absolute;
  top: 80px;
  right: 40px;
  width: 350px;
  max-height: 500px;
  overflow-y: auto;
  background: white;
  border-radius: 8px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
  z-index: 1000;
`;

export const PanelHeader = styled.div`
  padding: 15px;
  border-bottom: 1px solid #eee;
  display: flex;
  justify-content: space-between;
  align-items: center;
`;

export const PanelTitle = styled.h3`
  margin: 0;
  color: #1e3c72;
`;

export const CloseButton = styled.button`
  background: none;
  border: none;
  font-size: 20px;
  cursor: pointer;
  color: #555;
`;

export const NotificationItem = styled.div`
  padding: 15px;
  border-bottom: 1px solid #eee;
  background: ${props => props.unread ? '#f8f9fa' : 'white'};
  cursor: pointer;
  transition: background 0.2s;

  &:hover {
    background: #f1f3f5;
  }
`;

export const NotificationTitle = styled.h4`
  margin: 0 0 5px 0;
  color: ${props => props.unread ? '#1e3c72' : '#555'};
  font-weight: ${props => props.unread ? 'bold' : 'normal'};
`;

export const NotificationMessage = styled.p`
  margin: 0;
  color: #666;
  font-size: 14px;
`;

export const NotificationTime = styled.small`
  display: block;
  margin-top: 5px;
  color: #999;
  font-size: 12px;
`;

export const EmptyMessage = styled.div`
  padding: 20px;
  text-align: center;
  color: #666;
`;
