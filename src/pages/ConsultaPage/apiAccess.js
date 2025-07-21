export async function fetchConsultations() {
  try {
    const userId = sessionStorage.getItem('userId')
    console.log(userId);
    
    const res = await fetch(
      `http://localhost:8000/controller/ConsultationController.php?userId=${userId}`,
      {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json'
        }
      }
    )
    if (!res.ok) throw new Error('Erro ao buscar consultas')
    const data = await res.json()
    return data
  } catch (error) {
    console.error(error)
    return []
  }
}
