export async function fetchDoctorAvailability(doctorId) {
  try {
    const res = await fetch(
      `http://localhost:8000/controller/DoctorAvaliabilityController.php?id=${doctorId}`,
      {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json'
        }
      }
    )
    if (!res.ok) throw new Error('Erro ao buscar disponibilidade do médico')
    console.log('DISPONIBILIDADE', res)
    const data = await res.json()

    return data
  } catch (error) {
    console.error(error)
    return []
  }
}

export async function createAppointment(appointmentData) {
  try {
    const response = await fetch(
      'http://localhost:8000/controller/AppointmentController.php',
      {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(appointmentData)
      }
    )

    if (!response.ok) {
      throw new Error('Erro ao criar agendamento.')
    }

    console.log('Response:', response)

    const data = await response.json()
    console.log('Agendamento criado:', data)
    return data
  } catch (error) {
    console.error('Erro ao criar agendamento:', error)
    throw error
  }
}

export async function updateAppointment(data) {
  try {
    const response = await fetch(
      `http://localhost:8000/controller/AppointmentController.php`,
      {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      }
    );

    if (!response.ok) {
      const errorData = await response.json();
      throw { message: errorData.data || 'Erro ao atualizar agendamento', status: response.status };
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

