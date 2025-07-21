export async function loginUser(credentials) {
  try {
    const response = await fetch('http://localhost:8000/controller/UserController.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        action: 'login',
        cpf: credentials.cpf,
        password: credentials.password
      })
    })

    if (!response.ok) {
      throw new Error('Login failed')
    }

    
    console.log(response);
    const data = await response.json()
    console.log(data);
    
    return data
  } catch (error) {
    console.error('Error during login:', error)
    throw error
  }
}
