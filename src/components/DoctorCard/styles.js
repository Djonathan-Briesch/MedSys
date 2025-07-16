import styled from 'styled-components'

export const Card = styled.div`
  background: white;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  width: 280px;

  &:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
  }
`

export const DoctorName = styled.h3`
  color: #1e3c72;
  margin-bottom: 10px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
`

export const Specialty = styled.p`
  color: #555;
  margin-bottom: 15px;
  font-size: 14px;
`

export const Price = styled.div`
  background: #f0f4ff;
  padding: 8px 12px;
  border-radius: 6px;
  color: #1e3c72;
  font-weight: bold;
  display: inline-block;
`
