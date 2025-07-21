import { useState, useEffect } from 'react'
import { Header } from '../../components/Header'
import { ConsultationCard } from '../../components/ConsultaCard'
import { Container, Title, NoConsultations } from './styles'

import { fetchConsultations } from './apiAccess'

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

  console.log('Consultations:', consultations);
  
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
