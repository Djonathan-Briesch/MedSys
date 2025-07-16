import { useState, useEffect } from 'react'
import { useLocation, useNavigate } from 'react-router-dom'
import { Header } from '../../components/Header'
import {
  Container,
  Title,
  FormContainer,
  InputGroup,
  Label,
  Input,
  Select,
  Button,
  ErrorMessage
} from './styles'

export const AppointmentRegister = () => {
  const location = useLocation()
  const navigate = useNavigate()
  const { doctor, appointmentToEdit } = location.state || {}

  const [patientName, setPatientName] = useState('João Silva')
  const [selectedDay, setSelectedDay] = useState(appointmentToEdit?.day || '')
  const [startTime, setStartTime] = useState(appointmentToEdit?.startTime || '')
  const [endTime, setEndTime] = useState(appointmentToEdit?.endTime || '')
  const [availableDays, setAvailableDays] = useState([])
  const [availableTimes, setAvailableTimes] = useState([])
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState('')
  const [success, setSuccess] = useState(false)
  const [notes, setNotes] = useState(appointmentToEdit?.notes || '')

  // FAZER CONSULTA COM API
  const fetchAvailableSlots = async (doctorId) => {
    return new Promise((resolve) => {
      setTimeout(() => {
        const availability = {
          1: {
            availableDays: ['terça', 'quarta', 'sexta'],
            timeSlots: {
              terça: ['08:00', '09:00', '14:00'],
              quarta: ['10:00', '11:00', '15:00'],
              sexta: ['09:00', '13:00', '16:00']
            }
          },
          2: {
            availableDays: ['segunda', 'quinta'],
            timeSlots: {
              segunda: ['08:00', '10:00', '13:00'],
              quinta: ['09:00', '11:00', '14:00']
            }
          }
        }

        resolve(
          availability[doctorId] || {
            availableDays: [],
            timeSlots: {}
          }
        )
      }, 500)
    })
  }
  useEffect(() => {
    if (!doctor) {
      navigate('/')
      return
    }

    const loadAvailability = async () => {
      try {
        setLoading(true)
        const data = await fetchAvailableSlots(doctor.id)
        setAvailableDays(data.availableDays)
        setAvailableTimes(data.timeSlots)
      } catch (err) {
        setError('Erro ao carregar disponibilidade. Tente novamente.')
      } finally {
        setLoading(false)
      }
    }

    loadAvailability()
  }, [doctor, navigate])

  const handleDayChange = (e) => {
    const day = e.target.value
    setSelectedDay(day)
    setStartTime('')
    setEndTime('')
  }

  const handleStartTimeChange = (e) => {
    const time = e.target.value
    setStartTime(time)
    const [hours, minutes] = time.split(':').map(Number)
    const endHours = hours + 1
    setEndTime(
      `${endHours.toString().padStart(2, '0')}:${minutes
        .toString()
        .padStart(2, '0')}`
    )
  }

  const handleSubmit = (e) => {
    e.preventDefault()
    setError('')

    if (!selectedDay || !startTime) {
      setError('Por favor, selecione um dia e horário.')
      return
    }

    console.log('Agendamento enviado:', {
      doctor,
      patientName,
      day: selectedDay,
      startTime,
      endTime,
      notes,
      status: appointmentToEdit ? 'adiado' : 'pendente'
    })

    setSuccess(true)
    setTimeout(() => {
      navigate('/agendamentos')
    }, 2000)
  }

  if (!doctor) return null

  return (
    <>
      <Header />
      <Container>
        <Title>Agendar Consulta</Title>

        <FormContainer>
          <form onSubmit={handleSubmit}>
            <InputGroup>
              <Label>Médico</Label>
              <Input
                type="text"
                value={`${doctor.name} - ${doctor.specialty}`}
                disabled
              />
            </InputGroup>

            <InputGroup>
              <Label>Paciente</Label>
              <Input type="text" value={patientName} disabled />
            </InputGroup>

            <InputGroup>
              <Label>Dia da Semana</Label>
              <Select
                value={selectedDay}
                onChange={handleDayChange}
                disabled={loading || availableDays.length === 0}
                required
              >
                <option value="">Selecione um dia</option>
                {availableDays.map((day) => (
                  <option key={day} value={day}>
                    {day.charAt(0).toUpperCase() + day.slice(1)}
                  </option>
                ))}
              </Select>
            </InputGroup>

            {selectedDay && (
              <InputGroup>
                <Label>Horário de Início</Label>
                <Select
                  value={startTime}
                  onChange={handleStartTimeChange}
                  disabled={loading || !selectedDay}
                  required
                >
                  <option value="">Selecione um horário</option>
                  {availableTimes[selectedDay]?.map((time) => (
                    <option key={time} value={time}>
                      {time}
                    </option>
                  ))}
                </Select>
              </InputGroup>
            )}

            {startTime && (
              <InputGroup>
                <Label>Horário de Término</Label>
                <Input type="text" value={endTime} disabled />
              </InputGroup>
            )}

            {error && <ErrorMessage>{error}</ErrorMessage>}

            {success && (
              <p style={{ color: '#2ecc71', textAlign: 'center' }}>
                Agendamento realizado com sucesso! Redirecionando...
              </p>
            )}

            {!appointmentToEdit && (
              <InputGroup>
                <Label>Observações (opcional)</Label>
                <Input
                  as="textarea"
                  rows="3"
                  value={notes}
                  onChange={(e) => setNotes(e.target.value)}
                  placeholder="Alguma observação importante..."
                />
              </InputGroup>
            )}

            <Button
              type="submit"
              disabled={loading || success || !selectedDay || !startTime}
            >
              {loading ? 'Carregando...' : 'Confirmar Agendamento'}
            </Button>
          </form>
        </FormContainer>
      </Container>
    </>
  )
}
