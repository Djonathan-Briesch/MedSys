import {
  Card,
  CardHeader,
  DoctorName,
  PatientName,
  DetailRow,
  DetailLabel,
  DetailValue,
  NotesSection,
} from './styles'

export const ConsultationCard = ({ consultation }) => {
  console.log('ConsultationCard:', consultation);
  
  return (
    <Card>
      <CardHeader>
        <DoctorName>{consultation.appointment.doctor.name}</DoctorName>
      </CardHeader>

      <PatientName>Paciente: {consultation.appointment.patient.name}</PatientName>

      <DetailRow>
        <DetailLabel>Data de início:</DetailLabel>
        <DetailValue>{consultation.startDateTime}</DetailValue>
      </DetailRow>

      <DetailRow>
        <DetailLabel>Data de fim:</DetailLabel>
        <DetailValue>{consultation.endDateTime}</DetailValue>
      </DetailRow>

      {(consultation.medicalNotes || consultation.notes) && (
        <NotesSection>
          <DetailLabel>Observações:</DetailLabel>
          <p>{consultation.medicalNotes || consultation.notes}</p>
        </NotesSection>
      )}
    </Card>
  )
}
