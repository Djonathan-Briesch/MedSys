export async function fetchAppointmentsByUserId(userId) {
  try {
    const res = await fetch(
      `http://localhost:8000/controller/AppointmentController.php?patientId=${userId}`,
      {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json'
        }
      }
    )

    if (!res.ok) {
      throw new Error('Erro ao buscar agendamentos do paciente')
    }

    const data = await res.json()
    console.log('AGENDAMENTOS:', data)

    return data || []
  } catch (error) {
    console.error('Erro ao buscar agendamentos:', error)
    return []
  }
}

export async function updateAppointment(data) {
  try {
    const response = await fetch(`http://localhost:8000/controller/AppointmentController.php`, {
      method: 'PATCH',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data),
    });

    if (!response.ok) {
      throw new Error('Erro ao atualizar agendamento');
    }

    console.log('Agendamento atualizado com sucesso:', response);
    
    const result = await response.json();
    console.log('Agendamento atualizado com sucesso:', result);
    return result;
  } catch (error) {
    console.error('Erro na atualização:', error);
    throw error;
  }
}

