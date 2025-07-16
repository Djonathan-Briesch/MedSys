import { useNavigate } from 'react-router-dom'
import { Card, DoctorName, Specialty, Price } from './styles'
export const DoctorCard = ({ doctor }) => {
  const navigate = useNavigate()

  const handleClick = () => {
    navigate('/agendar', { state: { doctor } })
  }

  return (
    <Card onClick={handleClick}>
      <DoctorName>{doctor.name}</DoctorName>
      <Specialty>{doctor.specialty}</Specialty>
      <Price>R$ {doctor.price.toFixed(2)}</Price>
    </Card>
  )
}
