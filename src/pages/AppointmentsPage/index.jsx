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
import { useNavigate } from 'react-router-dom'
import { fetchAppointmentsByUserId, updateAppointment } from './apiAccess.js'

export const AppointmentsPage = () => {
  const [appointments, setAppointments] = useState([])
  const [filter, setFilter] = useState('all')
  const [loading, setLoading] = useState(true)
  const navigate = useNavigate()

  useEffect(() => {
    const loadAppointments = async () => {
      setLoading(true)
      try {
        const userId = sessionStorage.getItem('userId')
        if (!userId) {
          console.error('Usuário não autenticado.')
          setAppointments([])
          return
        }

        const data = await fetchAppointmentsByUserId(userId)

        setAppointments(
          data.map((item) => ({
            id: item.id,
            doctor: {
              id: item.doctor.id,
              name: item.doctor.name,
              specialty: item.doctor.specialty || ''
            },
            patient: {
              id: item.patient.id,
              name: item.patient.name
            },
            day: new Date(item.startDateTime).toLocaleDateString('pt-BR', {
              weekday: 'long'
            }),
            startTime: new Date(item.startDateTime).toLocaleTimeString(
              'pt-BR',
              { hour: '2-digit', minute: '2-digit' }
            ),
            endTime: new Date(item.endDateTime).toLocaleTimeString('pt-BR', {
              hour: '2-digit',
              minute: '2-digit'
            }),
            status: item.status.toLowerCase(),
            notes: item.notes,
            startDateTime: item.startDateTime,
            endDateTime: item.endDateTime,
            createdBy: item.createdBy || null,
            editedBy: item.editedBy || null
          }))
        )
      } catch (error) {
        console.error('Erro ao carregar agendamentos:', error)
      } finally {
        setLoading(false)
      }
    }

    loadAppointments()
  }, [])

  const handleCancel = async (appointment) => {
    try {
      if (!appointment || !appointment.doctor || !appointment.patient) {
        console.error('Dados do agendamento incompletos:', appointment)
        alert('Não foi possível cancelar: dados do agendamento incompletos.')
        return
      }

      const updatedData = {
        id: appointment.id,
        status: 'cancelled',
        doctorId: appointment.doctor.id,
        patientId: appointment.patient.id,
        startDateTime: appointment.startDateTime,
        endDateTime: appointment.endDateTime,
        createdBy: appointment.createdBy?.id || appointment.createdBy || null,
        editedBy: sessionStorage.getItem('userId'),
        notes: appointment.notes
      }

      await updateAppointment(updatedData)

      setAppointments((prev) =>
        prev.map((app) =>
          app.id === appointment.id ? { ...app, status: 'cancelled' } : app
        )
      )
    } catch (error) {
      console.error('Erro ao cancelar agendamento:', error)
      alert('Erro ao cancelar agendamento, tente novamente.')
    }
  }

  const handleReschedule = (appointment) => {
    console.log('Reagendando agendamento:', appointment)

    navigate('/agendar', {
      state: {
        doctor: appointment.doctor,
        appointmentToEdit: appointment
      }
    })
  }

  const filteredAppointments =
    filter === 'all'
      ? appointments
      : appointments.filter((app) => app.status === filter)

  return (
    <>
      <Header />
      <Container>
        <Title>Meus Agendamentos</Title>

        <FilterContainer>
          <FilterButton
            active={filter === 'all'}
            onClick={() => setFilter('all')}
          >
            Todos
          </FilterButton>
          <FilterButton
            active={filter === 'pending'}
            onClick={() => setFilter('pending')}
          >
            Pendentes
          </FilterButton>
          <FilterButton
            active={filter === 'confirmed'}
            onClick={() => setFilter('confirmed')}
          >
            Confirmados
          </FilterButton>
          <FilterButton
            active={filter === 'postponed'}
            onClick={() => setFilter('postponed')}
          >
            Adiados
          </FilterButton>
          <FilterButton
            active={filter === 'cancelled'}
            onClick={() => setFilter('cancelled')}
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
              onCancel={() => handleCancel(appointment)}
              onReschedule={() => handleReschedule(appointment)}
            />
          ))
        )}
      </Container>
    </>
  )
}
