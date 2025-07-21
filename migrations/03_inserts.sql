-- Insert users (types PATIENT and DOCTOR)
INSERT INTO User (name, email, birthDate, cpf, password, role) VALUES
('John Silva', 'john@example.com', '1980-05-10', '12345678901', 'hash_password1', 'PATIENT'),
('Dr. Mary Souza', 'mary@example.com', '1975-11-20', '10987654321', 'hash_password2', 'DOCTOR');

-- Insert patient (reference to user John)
INSERT INTO Patient (userId, healthPlan) VALUES
((SELECT id FROM User WHERE email='john@example.com'), 'Unimed');

-- Insert doctor (reference to user Mary with specialty)
INSERT INTO Doctor (userId, specialty) VALUES
((SELECT id FROM User WHERE email='mary@example.com'), 'Cardiology');

-- Insert appointment between patient John and doctor Mary
INSERT INTO Appointment (
    doctorId, patientId, startDateTime, endDateTime, status, createdBy, editedBy, lastUpdate, notes
) VALUES (
    (SELECT userId FROM Doctor WHERE userId = (SELECT id FROM User WHERE email='mary@example.com')),
    (SELECT userId FROM Patient WHERE userId = (SELECT id FROM User WHERE email='john@example.com')),
    '2025-07-10 14:00:00', '2025-07-10 14:30:00', 'PENDING',
    (SELECT id FROM User WHERE email='john@example.com'),
    NULL,
    NULL,
    'Initial consultation'
);

-- Insert consultation linked to appointment
INSERT INTO Consultation (appointmentId, startDateTime, endDateTime, status, medicalNotes) VALUES
(
    (SELECT id FROM Appointment WHERE notes='Initial consultation'),
    '2025-07-10 14:00:00', '2025-07-10 14:30:00', 'SCHEDULED',
    NULL
);

-- Insert doctor's availability (example: Monday from 08:00 to 12:00)
INSERT INTO DoctorAvailability (doctorId, weekday, startTime, endTime) VALUES
(
    (SELECT userId FROM Doctor WHERE userId = (SELECT id FROM User WHERE email='mary@example.com')),
    'MONDAY',
    '08:00:00',
    '12:00:00'
);

-- Insert notification for user John
INSERT INTO Notification (userId, title, description, dateTime, readFlag) VALUES
(
    (SELECT id FROM User WHERE email='john@example.com'),
    'Appointment Reminder',
    'You have an appointment scheduled for 07/10/2025 at 2:00 PM',
    NOW(),
    FALSE
);
