export async function registerUser(userData) {
  try {
    const response = await fetch(
      'http://localhost:8000/controller/UserController.php',
      {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          name: userData.name,
          cpf: userData.cpf,
          email: userData.email,
          bd: userData.bd,
          pass: userData.pass,
          type: userData.type,
          healthPlan: userData.healthPlan,
          specialty: userData.specialty
        })
      }
    )

    console.log('Register response:', response)

    if (!response.ok) {
      throw new Error('Registration failed')
    }

    const data = await response.json()
    return data
  } catch (error) {
    console.error('Error during registration:', error)
    throw error
  }
}
