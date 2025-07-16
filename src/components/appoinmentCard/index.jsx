import { useNavigate } from 'react-router-dom';
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
 } from "./styles";

export const AppointmentCard = ({ appointment, onCancel, onReschedule }) => {
  const navigate = useNavigate();

  const handleReschedule = () => {
    navigate('/agendar', { 
      state: { 
        doctor: { 
          id: appointment.doctorId,
          name: appointment.doctorName,
          specialty: appointment.doctorSpecialty
        },
        appointmentToEdit: appointment
      } 
    });
  };

  return (
    <Card status={appointment.status}>
      <CardHeader>
        <DoctorName>{appointment.doctorName}</DoctorName>
        <StatusBadge status={appointment.status}>
          {appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1)}
        </StatusBadge>
      </CardHeader>

      <DetailRow>
        <DetailLabel>Paciente:</DetailLabel>
        <DetailValue>{appointment.patientName}</DetailValue>
      </DetailRow>

      <DetailRow>
        <DetailLabel>Dia da semana:</DetailLabel>
        <DetailValue>{appointment.day}</DetailValue>
      </DetailRow>

      <DetailRow>
        <DetailLabel>Horário:</DetailLabel>
        <DetailValue>{appointment.startTime} - {appointment.endTime}</DetailValue>
      </DetailRow>

      {appointment.notes && (
        <DetailRow>
          <DetailLabel>Observações:</DetailLabel>
          <DetailValue>{appointment.notes}</DetailValue>
        </DetailRow>
      )}

      <ButtonsContainer>
        <ActionButton onClick={() => onCancel(appointment.id)}>Cancelar</ActionButton>
        <ActionButton onClick={handleReschedule}>Adiar/Reagendar</ActionButton>
      </ButtonsContainer>
    </Card>
  );
};