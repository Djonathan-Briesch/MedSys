export async function fetchNotifications() {
  try {
    const userId = sessionStorage.getItem('userId')
    console.log(`Fetching notifications for user ID: ${userId}`)

    if (!userId) throw new Error('Usuário não logado')

    const res = await fetch(
      `http://localhost:8000/controller/NotificationController.php?userId=${userId}`
    )

    if (!res.ok) throw new Error('Erro ao buscar notificações')
    const json = await res.json()
    console.log(json)

    return json ?? []
  } catch (error) {
    console.error(error)
    return []
  }
}

export async function markNotificationAsRead(id) {
  try {
    const res = await fetch(
      'http://localhost:8000/controller/NotificationController.php',
      {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}&read=true`
      }
    )
    if (!res.ok) throw new Error('Erro ao marcar notificação como lida')
    return await res.json()
  } catch (error) {
    console.error(error)
    return null
  }
}
