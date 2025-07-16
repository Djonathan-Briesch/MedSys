import styled from 'styled-components';

export const BellContainer = styled.div`
  position: relative;
  cursor: pointer;
  color: white;
  font-size: 24px;
  display: flex;
  align-items: center;
`;

export const Badge = styled.span`
  position: absolute;
  top: -5px;
  right: -5px;
  background-color: #e74c3c;
  color: white;
  border-radius: 50%;
  width: 18px;
  height: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  font-weight: bold;
`;
