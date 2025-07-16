import styled from 'styled-components';

export const Card = styled.div`
  background: white;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  margin-bottom: 20px;
  border-left: 5px solid #1e3c72;
`;

export const CardHeader = styled.div`
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
  align-items: center;
`;

export const DoctorName = styled.h3`
  color: #1e3c72;
  margin: 0;
`;

export const PatientName = styled.p`
  color: #555;
  margin: 5px 0;
  font-weight: 500;
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

export const NotesSection = styled.div`
  margin-top: 15px;
  padding-top: 15px;
  border-top: 1px solid #eee;
`;