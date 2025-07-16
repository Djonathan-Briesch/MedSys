import { useState } from 'react'
import { FiMail, FiLock } from 'react-icons/fi'
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
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')

  const handleSubmit = (e) => {
    e.preventDefault()
    alert(`Email: ${email}\nSenha: ${password}`)
    // TODO: FAZER PARA LOGAR AQUI
  }

  return (
    <Container>
      <LoginBox>
        <Title>Login</Title>
        <form onSubmit={handleSubmit}>
          <InputGroup>
            <IconWrapper>
              <FiMail />
            </IconWrapper>
            <Input
              type="email"
              placeholder="Email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
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
      </LoginBox>
    </Container>
  )
}
