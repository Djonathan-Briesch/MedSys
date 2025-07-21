import { useState, useEffect } from 'react'
import { useLocation, useNavigate } from 'react-router-dom'
import { Header } from '../../components/Header'
import {
  fetchDoctorAvailability,
  createAppointment,
  updateAppointment
} from './apiAccess'
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

  const [selectedDate, setSelectedDate] = useState(
    appointmentToEdit?.startDateTime?.slice(0, 10) || ''
  )

  const [patientName, setPatientName] = useState('João Silva')

  const [startTime, setStartTime] = useState(
    appointmentToEdit?.startDateTime?.slice(11, 16) || ''
  )
  const [endTime, setEndTime] = useState(
    appointmentToEdit?.endDateTime?.slice(11, 16) || ''
  )

  const [availableDays, setAvailableDays] = useState([])
  const [availableTimes, setAvailableTimes] = useState({})
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState('')
  const [success, setSuccess] = useState(false)
  const [notes, setNotes] = useState(appointmentToEdit?.notes || '')

  useEffect(() => {
    if (appointmentToEdit) {
      setStartTime(appointmentToEdit.startDateTime.slice(11, 16))
      setEndTime(appointmentToEdit.endDateTime.slice(11, 16))
      setSelectedDate(appointmentToEdit.startDateTime.slice(0, 10))
      setNotes(appointmentToEdit.notes || '')
    }
  }, [appointmentToEdit])

  useEffect(() => {
    if (!doctor) {
      navigate('/dashboard')
      return
    }

    async function loadAvailability() {
      try {
        setLoading(true)
        const availability = await fetchDoctorAvailability(doctor.id)
        const days = availability
          .map((a) => a.weekDay.toLowerCase())
          .filter(Boolean)
        setAvailableDays([...new Set(days)])

        const timesByDay = {}
        availability.forEach(({ weekDay, startTime, endTime }) => {
          const dayLower = weekDay.toLowerCase()
          if (!timesByDay[dayLower]) timesByDay[dayLower] = []
          timesByDay[dayLower].push({ startTime, endTime })
        })
        setAvailableTimes(timesByDay)
      } catch (err) {
        setError('Erro ao carregar disponibilidade. Tente novamente.')
      } finally {
        setLoading(false)
      }
    }

    loadAvailability()
  }, [doctor, navigate])

  const getWeekDayFromDate = (dateString) => {
    if (!dateString) return ''
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', { weekday: 'long' }).toLowerCase()
  }

  const handleStartTimeChange = (e) => {
    const time = e.target.value
    setStartTime(time)

    const [hours, minutes] = time.split(':').map(Number)
    const endHours = hours + 1
    const calculatedEndTime = `${endHours.toString().padStart(2, '0')}:${minutes
      .toString()
      .padStart(2, '0')}`
    setEndTime(calculatedEndTime)
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    setError('')
    setSuccess(false)

    if (!selectedDate || !startTime) {
      setError('Por favor, selecione uma data e horário.')
      return
    }

    if (appointmentToEdit) {
      const formattedStartDateTime = `${selectedDate} ${startTime}`
      const formattedEndDateTime = `${selectedDate} ${endTime}`

      const updatedData = {
        id: appointmentToEdit.id,
        doctorId: doctor.id, // incluir doctorId
        startDateTime: formattedStartDateTime,
        endDateTime: formattedEndDateTime,
        notes,
        editedBy: sessionStorage.getItem('userId'),
        status:
          appointmentToEdit.status === 'CANCELLED'
            ? 'PENDING'
            : appointmentToEdit.status
      }

      try {
        await updateAppointment(updatedData)
        alert('Agendamento reagendado com sucesso!')
        navigate('/agendamentos')
      } catch (error) {
        console.log(error)
        if (error?.status === 409) {
          setError(
            'Conflito: esse horário já está ocupado. Por favor, escolha outro horário.'
          )
        } else {
          setError(error?.message || 'Erro ao reagendar. Tente novamente.')
        }
      }

      // navigate('/appointments')
    } else {
      const formattedStartDateTime = `${selectedDate} ${startTime}`
      const formattedEndDateTime = `${selectedDate} ${endTime}`

      const appointmentData = {
        doctorId: doctor.id,
        patientId: sessionStorage.getItem('userId'),
        createdBy: sessionStorage.getItem('userId'),
        date: selectedDate,
        startDateTime: formattedStartDateTime,
        endDateTime: formattedEndDateTime,
        notes,
        status: 'PENDING'
      }

      try {
        await createAppointment(appointmentData)
        setSuccess(true)
        setTimeout(() => {
          navigate('/agendamentos')
        }, 2000)
      } catch (error) {
        setError('Erro ao criar agendamento. Tente novamente.')
      }
    }
  }

  if (!doctor) return null

  const currentWeekDay = getWeekDayFromDate(selectedDate)

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
              <Label>Data da Consulta</Label>
              <Input
                type="date"
                value={selectedDate}
                onChange={(e) => {
                  setSelectedDate(e.target.value)
                  setStartTime('')
                  setEndTime('')
                }}
                required
              />
            </InputGroup>
            {selectedDate && (
              <InputGroup>
                <Label>Horário</Label>
                {availableTimes[currentWeekDay]?.length > 0 ? (
                  <Select
                    value={startTime}
                    onChange={handleStartTimeChange}
                    disabled={loading}
                    required
                  >
                    <option value="">Selecione um horário</option>
                    {availableTimes[currentWeekDay].map(
                      ({ startTime, endTime }) => (
                        <option key={startTime} value={startTime}>
                          {startTime} - {endTime}
                        </option>
                      )
                    )}
                  </Select>
                ) : (
                  <p style={{ color: '#e74c3c', fontWeight: 'bold' }}>
                    Este médico não possui horários disponíveis nesta data.
                  </p>
                )}
              </InputGroup>
            )}
            {error && <ErrorMessage>{error}</ErrorMessage>}
            {success && (
              <p style={{ color: '#2ecc71', textAlign: 'center' }}>
                Agendamento realizado com sucesso! Redirecionando...
              </p>
            )}
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

            <Button
              type="submit"
              disabled={loading || success || !selectedDate || !startTime}
            >
              {loading
                ? 'Carregando...'
                : appointmentToEdit
                ? 'Reagendar Consulta'
                : 'Confirmar Agendamento'}
            </Button>
          </form>
        </FormContainer>
      </Container>
    </>
  )
}
