import { useState, useEffect } from 'react'
import { Header } from '../../components/Header'
import { AppointmentCard } from '../../components/appoinmentCard'
import {
  Container,
  Title,
  FilterContainer,
  FilterButton,
  NoAppointments
} from './styles'

export const AppointmentsPage = () => {
  const [appointments, setAppointments] = useState([])
  const [filter, setFilter] = useState('todos')
  const [loading, setLoading] = useState(true)

  // FAZER CONSULTA COM API
  const fetchAppointments = async () => {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve([
          {
            id: 1,
            doctorId: 1,
            doctorName: 'Dr. Carlos Silva',
            doctorSpecialty: 'Cardiologia',
            patientName: 'João Silva',
            day: 'quarta',
            startTime: '10:00',
            endTime: '11:00',
            status: 'confirmado',
            notes: 'Paciente com histórico de pressão alta'
          },
          {
            id: 2,
            doctorId: 2,
            doctorName: 'Dra. Ana Oliveira',
            doctorSpecialty: 'Dermatologia',
            patientName: 'João Silva',
            day: 'quinta',
            startTime: '09:00',
            endTime: '10:00',
            status: 'pendente',
            notes: ''
          },
          {
            id: 3,
            doctorId: 3,
            doctorName: 'Dr. Marcos Souza',
            doctorSpecialty: 'Ortopedia',
            patientName: 'João Silva',
            day: 'sexta',
            startTime: '13:00',
            endTime: '14:00',
            status: 'adiado',
            notes: 'Paciente solicitou reagendamento'
          }
        ])
      }, 500)
    })
  }

  useEffect(() => {
    const loadAppointments = async () => {
      try {
        setLoading(true)
        const data = await fetchAppointments()
        setAppointments(data)
      } catch (error) {
        console.error('Erro ao carregar agendamentos:', error)
      } finally {
        setLoading(false)
      }
    }

    loadAppointments()
  }, [])

  const handleCancel = (appointmentId) => {
    setAppointments((prev) =>
      prev.map((app) =>
        app.id === appointmentId ? { ...app, status: 'cancelado' } : app
      )
    )
  }

  const filteredAppointments =
    filter === 'todos'
      ? appointments
      : appointments.filter((app) => app.status === filter)

  return (
    <>
      <Header />
      <Container>
        <Title>Meus Agendamentos</Title>

        <FilterContainer>
          <FilterButton
            active={filter === 'todos'}
            onClick={() => setFilter('todos')}
          >
            Todos
          </FilterButton>
          <FilterButton
            active={filter === 'pendente'}
            onClick={() => setFilter('pendente')}
          >
            Pendentes
          </FilterButton>
          <FilterButton
            active={filter === 'confirmado'}
            onClick={() => setFilter('confirmado')}
          >
            Confirmados
          </FilterButton>
          <FilterButton
            active={filter === 'adiado'}
            onClick={() => setFilter('adiado')}
          >
            Adiados
          </FilterButton>
          <FilterButton
            active={filter === 'cancelado'}
            onClick={() => setFilter('cancelado')}
          >
            Cancelados
          </FilterButton>
        </FilterContainer>

        {loading ? (
          <NoAppointments>Carregando agendamentos...</NoAppointments>
        ) : filteredAppointments.length === 0 ? (
          <NoAppointments>Nenhum agendamento encontrado</NoAppointments>
        ) : (
          filteredAppointments.map((appointment) => (
            <AppointmentCard
              key={appointment.id}
              appointment={appointment}
              onCancel={handleCancel}
            />
          ))
        )}
      </Container>
    </>
  )
}
