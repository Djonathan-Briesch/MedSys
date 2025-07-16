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

export const FormContainer = styled.div`
  background: #ffffff;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
`;

export const InputGroup = styled.div`
  margin-bottom: 20px;
`;

export const Label = styled.label`
  display: block;
  margin-bottom: 8px;
  color: #1e3c72;
  font-weight: 500;
`;

export const Input = styled.input`
  width: 100%;
  padding: 12px;
  border: 2px solid #e0e4eb;
  border-radius: 6px;
  font-size: 16px;
  outline: none;
  transition: border-color 0.3s ease;

  &:focus {
    border-color: #1e3c72;
  }

  &:disabled {
    background-color: #f5f7fa;
    color: #555;
  }
`;

export const Select = styled.select`
  width: 100%;
  padding: 12px;
  border: 2px solid #e0e4eb;
  border-radius: 6px;
  font-size: 16px;
  outline: none;
  background: white;
  appearance: none;
  cursor: pointer;
  transition: border-color 0.3s ease;

  &:focus {
    border-color: #1e3c72;
  }

  &:disabled {
    opacity: 0.7;
    cursor: not-allowed;
  }
`;

export const Button = styled.button`
  width: 100%;
  background-color: #1e3c72;
  color: white;
  font-weight: 600;
  padding: 14px;
  border: none;
  border-radius: 8px;
  font-size: 18px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin-top: 20px;

  &:hover {
    background-color: #16345b;
  }

  &:disabled {
    background-color: #cccccc;
    cursor: not-allowed;
  }
`;

export const ErrorMessage = styled.p`
  color: #e74c3c;
  margin-top: 5px;
  font-size: 14px;
`;

