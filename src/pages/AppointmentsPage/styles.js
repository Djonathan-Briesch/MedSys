import styled from 'styled-components';

export const Container = styled.div`
  padding: 40px;
  max-width: 800px;
  margin: 0 auto;
`;

export const Title = styled.h2`
  color: #1e3c72;
  margin-bottom: 30px;
  text-align: center;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
`;

export const FilterContainer = styled.div`
  display: flex;
  gap: 15px;
  margin-bottom: 30px;
`;

export const FilterButton = styled.button`
  padding: 8px 15px;
  border: none;
  border-radius: 6px;
  background-color: ${props => props.active ? '#1e3c72' : '#e0e4eb'};
  color: ${props => props.active ? 'white' : '#555'};
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;

  &:hover {
    background-color: ${props => props.active ? '#16345b' : '#d0d4db'};
  }
`;

export const NoAppointments = styled.p`
  text-align: center;
  color: #555;
  font-size: 18px;
  margin-top: 50px;
`;