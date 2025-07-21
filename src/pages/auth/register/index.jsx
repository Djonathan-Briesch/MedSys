import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import { registerUser } from './apiAccess'

import { FiUser, FiMail, FiLock, FiCalendar, FiFileText } from 'react-icons/fi'

import {
  Container,
  RegisterBox,
  Title,
  InputGroup,
  Input,
  Button,
  IconWrapper
} from './styles'

export default function SingUp() {
  const navigate = useNavigate()
  const [form, setForm] = useState({
    name: '',
    email: '',
    birthDate: '',
    cpf: '',
    password: '',
    confirmPassword: '',
    role: 'PATIENT',
    healthPlan: '',
    specialty: ''
  })

  const handleChange = (e) => {
    setForm({
      ...form,
      [e.target.name]: e.target.value
    })
  }

  const handleSubmit = async (e) => {
    e.preventDefault()

    if (form.password !== form.confirmPassword) {
      alert('Senha e confirmar senha não coincidem')
      return
    }

    try {
      const payload = {
        name: form.name,
        cpf: form.cpf,
        email: form.email,
        bd: form.birthDate,
        pass: form.password,
        type: form.role,
        healthPlan: form.healthPlan,
        specialty: form.specialty
      }

      console.log('Payload enviado:', payload)

      const data = await registerUser(payload)
      console.log('Registration successful:', data)

      if (data) {
        navigate('/login')
      }
    } catch (error) {
      console.error('Error during registration:', error)
    }
  }

  return (
    <Container>
      <RegisterBox>
        <Title>Cadastro</Title>
        <form onSubmit={handleSubmit}>
          <InputGroup>
            <IconWrapper>
              <FiUser />
            </IconWrapper>
            <Input
              type="text"
              placeholder="Nome"
              name="name"
              value={form.name}
              onChange={handleChange}
              required
            />
          </InputGroup>
          <InputGroup>
            <IconWrapper>
              <FiMail />
            </IconWrapper>
            <Input
              type="email"
              placeholder="Email"
              name="email"
              value={form.email}
              onChange={handleChange}
              required
            />
          </InputGroup>
          <InputGroup>
            <IconWrapper>
              <FiCalendar />
            </IconWrapper>
            <Input
              type="date"
              placeholder="Data de Nascimento"
              name="birthDate"
              value={form.birthDate}
              onChange={handleChange}
              required
            />
          </InputGroup>
          <InputGroup>
            <IconWrapper>
              <FiFileText />
            </IconWrapper>
            <Input
              type="text"
              placeholder="CPF"
              name="cpf"
              value={form.cpf}
              onChange={handleChange}
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
              name="password"
              value={form.password}
              onChange={handleChange}
              required
            />
          </InputGroup>
          <InputGroup>
            <IconWrapper>
              <FiLock />
            </IconWrapper>
            <Input
              type="password"
              placeholder="Confirmar Senha"
              name="confirmPassword"
              value={form.confirmPassword}
              onChange={handleChange}
              required
            />
          </InputGroup>

          <Button type="submit">Cadastrar</Button>
        </form>
        <p
          onClick={() => {
            navigate('/login')
          }}
        >
          Já tem conta? Faça login
        </p>
      </RegisterBox>
    </Container>
  )
}
