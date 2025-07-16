import { styled } from 'styled-components'

export const Container = styled.div`
  height: 100vh;
  background: linear-gradient(135deg, #1e3c72, #2a5298);
  display: flex;
  justify-content: center;
  align-items: center;
`

export const LoginBox = styled.div`
  height: 600px;
  width: 450px;
  background: #ffffff;
  padding: 40px 50px;
  border-radius: 12px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
  display: flex;
  flex-direction: column;
  justify-content: space-evenly;
  align-items: center;
`

export const Title = styled.h2`
  color: #1e3c72;
  /* margin-bottom: 30px; */
  text-align: center;
  font-size: 2em;
`

export const InputGroup = styled.div`
  position: relative;
  margin-bottom: 25px;
`

export const IconWrapper = styled.div`
  position: absolute;
  top: 50%;
  left: 12px;
  transform: translateY(-50%);
  color: #2a5298;
  font-size: 20px;
`

export const Input = styled.input`
  width: 100%;
  padding: 12px 12px 12px 40px;
  border: 2px solid #2a5298;
  border-radius: 6px;
  font-size: 16px;
  outline: none;
  transition: border-color 0.3s ease;

  &:focus {
    border-color: #1e3c72;
  }
`

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

  &:hover {
    background-color: #16345b;
  }
`
