import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import { FiFileText, FiLock } from 'react-icons/fi'
import { loginUser } from './apiAccess'
import {
  Container,
  LoginBox,
  Title,
  InputGroup,
  IconWrapper,
  Input,
  Button
} from './styles.js'

export default function Login() {
  const [cpf, setCpf] = useState('')
  const [password, setPassword] = useState('')
  const navigate = useNavigate()

  const handleSubmit = async (e) => {
    e.preventDefault()

    try {
      const data = await loginUser({ cpf, password })
      console.log('Login response:', data)
      sessionStorage.setItem('userId', data.id)
      console.log('User ID stored in sessionStorage:', sessionStorage.getItem('userId'));
      
      if (data.status) {
        alert('CPF ou senha inválidos')
      } else {
        navigate('/dashboard')
      }
    } catch (error) {
      console.error('Error during login:', error)
      alert('Erro ao fazer login')
    }
  }

  return (
    <Container>
      <LoginBox>
        <Title>Login</Title>
        <form onSubmit={handleSubmit}>
          <InputGroup>
            <IconWrapper>
              <FiFileText />
            </IconWrapper>
            <Input
              type="text"
              placeholder="CPF"
              value={cpf}
              onChange={(e) => setCpf(e.target.value)}
              required
            />
          </InputGroup>
          <InputGroup>
            <IconWrapper>
              <FiLock />
            </IconWrapper>
            <Input
              type="password"
              placeholder="Senha"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
          </InputGroup>
          <Button type="submit">Entrar</Button>
        </form>

        <p
          onClick={() => {
            navigate('/register')
          }}
        >
          Não tem conta? Cadastre-se
        </p>
      </LoginBox>
    </Container>
  )
}
