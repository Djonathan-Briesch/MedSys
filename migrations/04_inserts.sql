-- Insert users (types PATIENT and DOCTOR)
INSERT INTO User (name, email, birthDate, cpf, password, role) VALUES
('John Silva', 'john@example.com', '1980-05-10', '12345678901', 'hash_password1', 'PATIENT'),
('Dr. Mary Souza', 'mary@example.com', '1975-11-20', '10987654321', 'hash_password2', 'DOCTOR');

-- Insert patient (reference to user John)
INSERT INTO Patient (userId, healthPlan) VALUES (1, 'Unimed');

-- Insert doctor (reference to user Mary with specialty)
INSERT INTO Doctor (userId, specialty) VALUES (2, 'Cardiology');

-- Insert doctor's availability (example: Monday from 08:00 to 12:00)
INSERT INTO DoctorAvailability (doctorId, weekday, startTime, endTime) VALUES (2, 'MONDAY', '08:00:00', '12:00:00');

-- Insert appointment between patient John and doctor Mary
INSERT INTO Appointment (
  doctorId,
  patientId,
  startDateTime,
  endDateTime,
  status,
  createdBy,
  notes
) VALUES (
  2,
  1,
  '2025-07-10 14:00:00',
  '2025-07-10 14:30:00',
  'PENDING',
  1,
  'Initial consultation'
);

-- Another appointment example (trigger will create Consultation and Notification)
INSERT INTO Appointment (
  doctorId,
  patientId,
  startDateTime,
  endDateTime,
  createdBy,
  notes
) VALUES (
  2,
  1,
  '2025-07-21 15:00:00',
  '2025-07-21 15:30:00',
  1,
  'Consulta teste para trigger'
);
