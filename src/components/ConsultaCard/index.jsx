import {
  Card,
  CardHeader,
  DoctorName,
  DetailRow,
  DetailLabel,
  DetailValue,
} from './styles'

export const ConsultationCard = ({ consultation }) => {
  return (
    <Card>
      <CardHeader>
        <DoctorName>{consultation.doctorName}</DoctorName>
      </CardHeader>

      <PatientName>Paciente: {consultation.patientName}</PatientName>

      <DetailRow>
        <DetailLabel>Data de início:</DetailLabel>
        <DetailValue>{consultation.startDate}</DetailValue>
      </DetailRow>

      <DetailRow>
        <DetailLabel>Data de fim:</DetailLabel>
        <DetailValue>{consultation.endDate}</DetailValue>
      </DetailRow>

      {consultation.notes && (
        <NotesSection>
          <DetailLabel>Observações:</DetailLabel>
          <p>{consultation.notes}</p>
        </NotesSection>
      )}
    </Card>
  )
}
