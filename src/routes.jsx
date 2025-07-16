import { createBrowserRouter } from 'react-router-dom'
import Login from './pages/auth/login'
import SingUp from './pages/auth/register'
import { Home } from './pages/home'
import { AppointmentRegister } from './pages/AppointmentRegister'
import { AppointmentsPage } from './pages/AppointmentsPage'
import { ConsultationsPage } from './pages/ConsultaPage'

export const router = createBrowserRouter([
  {
    path: '/login',
    element: <Login />
  },
  {
    path: '/register',
    element: <SingUp />
  },
  {
    path: '/',
    element: <Home />
  },
  {
    path: '/agendar',
    element: <AppointmentRegister />
  },
  {
    path: '/agendamentos',
    element: <AppointmentsPage />
  },
  {
    path: 'consultas',
    element: <ConsultationsPage />
  }
])
