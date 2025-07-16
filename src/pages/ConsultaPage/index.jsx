import { useState, useEffect } from 'react'
import { Header } from '../../components/Header'
import { ConsultationCard } from '../../components/ConsultaCard'
import { Container, Title, NoConsultations } from './styles'

// TODO fazer consulta com API 
const fetchConsultations = async () => {
  return new Promise((resolve) => {
    setTimeout(() => {
      resolve([
        {
          id: 1,
          doctorName: 'Dr. Carlos Silva',
          patientName: 'João Silva',
          startDate: '15/03/2023 10:00',
          endDate: '15/03/2023 11:00',
          notes:
            'Paciente com histórico de pressão alta, necessita de acompanhamento mensal'
        },
        {
          id: 2,
          doctorName: 'Dra. Ana Oliveira',
          patientName: 'Maria Souza',
          startDate: '16/03/2023 14:00',
          endDate: '16/03/2023 15:00',
          notes: 'Consulta de rotina, exames anuais'
        },
        {
          id: 3,
          doctorName: 'Dr. Marcos Santos',
          patientName: 'Pedro Almeida',
          startDate: '17/03/2023 09:00',
          endDate: '17/03/2023 10:00',
          notes: ''
        }
      ])
    }, 500)
  })
}

export const ConsultationsPage = () => {
  const [consultations, setConsultations] = useState([])
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    const loadConsultations = async () => {
      try {
        setLoading(true)
        const data = await fetchConsultations()
        setConsultations(data)
      } catch (error) {
        console.error('Erro ao carregar consultas:', error)
      } finally {
        setLoading(false)
      }
    }

    loadConsultations()
  }, [])

  return (
    <>
      <Header />
      <Container>
        <Title>Minhas Consultas</Title>

        {loading ? (
          <NoConsultations>Carregando consultas...</NoConsultations>
        ) : consultations.length === 0 ? (
          <NoConsultations>Nenhuma consulta encontrada</NoConsultations>
        ) : (
          consultations.map((consultation) => (
            <ConsultationCard
              key={consultation.id}
              consultation={consultation}
            />
          ))
        )}
      </Container>
    </>
  )
}
