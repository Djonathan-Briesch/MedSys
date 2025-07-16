import { useState } from 'react'

import {
  FiUser,
  FiMail,
  FiLock,
  FiCalendar,
  FiFileText,
  FiHash
} from 'react-icons/fi'

import {
  Container,
  RegisterBox,
  Title,
  InputGroup,
  Input,
  Button,
  IconWrapper,
  Select
} from './styles'

export default function SingUp() {
  const [form, setForm] = useState({
    nome: '',
    email: '',
    dataNascimento: '',
    cpf: '',
    senha: '',
    confirmarSenha: '',
    tipoUsuario: 'Paciente',
    crm: '',
    especialidade: '',
    planoSaude: ''
  })

  const handleChange = (e) => {
    setForm({
      ...form,
      [e.target.name]: e.target.value
    })
  }

  const handleSubmit = (e) => {
    e.preventDefault()
    alert(JSON.stringify(form, null, 2))
    // TODO: Implementar lógica de registro
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
              name="nome"
              value={form.nome}
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
              name="dataNascimento"
              value={form.dataNascimento}
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
              name="senha"
              value={form.senha}
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
              name="confirmarSenha"
              value={form.confirmarSenha}
              onChange={handleChange}
              required
            />
          </InputGroup>

          <InputGroup>
            <Select
              name="tipoUsuario"
              value={form.tipoUsuario}
              onChange={handleChange}
            >
              <option value="Paciente">Paciente</option>
              <option value="Medico">Médico</option>
            </Select>
          </InputGroup>

          {form.tipoUsuario === 'Medico' && (
            <>
              <InputGroup>
                <IconWrapper>
                  <FiHash />
                </IconWrapper>
                <Input
                  type="text"
                  placeholder="CRM"
                  name="crm"
                  value={form.crm}
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
                  placeholder="Especialidade"
                  name="especialidade"
                  value={form.especialidade}
                  onChange={handleChange}
                  required
                />
              </InputGroup>
            </>
          )}

          {form.tipoUsuario === 'Paciente' && (
            <InputGroup>
              <IconWrapper>
                <FiFileText />
              </IconWrapper>
              <Input
                type="text"
                placeholder="Plano de Saúde"
                name="planoSaude"
                value={form.planoSaude}
                onChange={handleChange}
                required
              />
            </InputGroup>
          )}

          <Button type="submit">Cadastrar</Button>
        </form>
      </RegisterBox>
    </Container>
  )
}
