import styled from 'styled-components';

export const HeaderContainer = styled.header`
  background: linear-gradient(135deg, #1e3c72, #2a5298);
  padding: 20px 40px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  position: relative;
`;

export const LogoContainer = styled.div`
  display: flex;
  align-items: center;
  gap: 15px;
  cursor: pointer;
`;

export const LogoImage = styled.img`
  height: 40px;
  width: 40px;
  border-radius: 50%;
  object-fit: cover;
`;

export const LogoText = styled.div`
  color: white;
  font-size: 24px;
  font-weight: bold;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
`;

export const RightContainer = styled.div`
  display: flex;
  align-items: center;
  gap: 25px;
`;

export const ButtonGroup = styled.div`
  display: flex;
  gap: 15px;
`;

export const NavButton = styled.button`
  background: ${props => props.primary ? "#1e3c72" : "transparent"};
  color: white;
  padding: 10px 20px;
  border: ${props => props.primary ? "none" : "1px solid white"};
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
  transition: all 0.3s ease;

  &:hover {
    background: ${props => props.primary ? "#16345b" : "rgba(255, 255, 255, 0.1)"};
  }
`;