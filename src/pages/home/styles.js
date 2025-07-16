import styled from "styled-components";

export const PageContainer = styled.div`
  min-height: 100vh;
  background-color: #f5f7fa;
`;

export const Content = styled.div`
  padding: 40px;
  max-width: 1200px;
  margin: 0 auto;
`;

export const SearchContainer = styled.div`
  margin-bottom: 40px;
  position: relative;
`;

export const SearchInput = styled.input`
  width: 100%;
  padding: 15px 20px;
  border: 2px solid #e0e4eb;
  border-radius: 8px;
  font-size: 16px;
  outline: none;
  transition: all 0.3s ease;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);

  &:focus {
    border-color: #1e3c72;
    box-shadow: 0 4px 15px rgba(30, 60, 114, 0.1);
  }
`;

export const SearchIcon = styled.span`
  position: absolute;
  right: 20px;
  top: 50%;
  transform: translateY(-50%);
  color: #2a5298;
`;

export const DoctorsGrid = styled.div`
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 25px;
`;
