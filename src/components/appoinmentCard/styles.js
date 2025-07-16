import styled from 'styled-components';

export const Card = styled.div`
  background: white;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  margin-bottom: 20px;
  border-left: 5px solid ${props => {
    switch(props.status) {
      case 'confirmado': return '#2980b9';
      case 'cancelado': return '#34495e';
      case 'adiado': return '#3498db';
      default: return '#1e3c72';
    }
  }};
`;

export const CardHeader = styled.div`
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
`;

export const DoctorName = styled.h3`
  color: #1e3c72;
  margin: 0;
`;

export const StatusBadge = styled.span`
  padding: 5px 10px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: bold;
  color: white;
  background-color: ${props => {
    switch(props.status) {
      case 'confirmado': return '#2980b9';
      case 'cancelado': return '#34495e';
      case 'adiado': return '#3498db';
      default: return '#1e3c72';
    }
  }};
`;

export const DetailRow = styled.div`
  display: flex;
  margin-bottom: 8px;
`;

export const DetailLabel = styled.span`
  font-weight: bold;
  color: #1e3c72;
  min-width: 120px;
`;

export const DetailValue = styled.span`
  color: #555;
`;

export const ButtonsContainer = styled.div`
  display: flex;
  gap: 10px;
  margin-top: 15px;
`;

export const ActionButton = styled.button`
  padding: 8px 15px;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;

  &:first-child {
    background-color: #34495e;
    color: white;

    &:hover {
      background-color: #2c3e50;
    }
  }

  &:last-child {
    background-color: #3498db;
    color: white;

    &:hover {
      background-color: #2980b9;
    }
  }
`;
