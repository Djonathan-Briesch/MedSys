import {
  Card,
  CardHeader,
  DoctorName,
  StatusBadge,
  DetailRow,
  DetailLabel,
  DetailValue,
  ButtonsContainer,
  ActionButton
} from './styles'

export const AppointmentCard = ({ appointment, onCancel, onReschedule }) => {
  console.log(appointment.status);
  
  return (
    <Card status={appointment.status}>
      <CardHeader>
        <DoctorName>{appointment.doctor.name}</DoctorName>
        <StatusBadge status={appointment.status}>
          {appointment.status.charAt(0).toUpperCase() +
            appointment.status.slice(1)}
        </StatusBadge>
      </CardHeader>

      <DetailRow>
        <DetailLabel>Paciente:</DetailLabel>
        <DetailValue>{appointment.patient.name}</DetailValue>
      </DetailRow>

      <DetailRow>
        <DetailLabel>Dia da semana:</DetailLabel>
        <DetailValue>{appointment.day}</DetailValue>
      </DetailRow>

      <DetailRow>
        <DetailLabel>Horário:</DetailLabel>
        <DetailValue>
          {appointment.startTime} - {appointment.endTime}
        </DetailValue>
      </DetailRow>

      {appointment.notes && (
        <DetailRow>
          <DetailLabel>Observações:</DetailLabel>
          <DetailValue>{appointment.notes}</DetailValue>
        </DetailRow>
      )}

      <ButtonsContainer>
        {appointment.status !== 'cancelled' && (
          <ActionButton onClick={() => onCancel(appointment.id)}>
            Cancelar
          </ActionButton>
        )}

        <ActionButton onClick={onReschedule}>Reagendar</ActionButton>
      </ButtonsContainer>
    </Card>
  )
}
