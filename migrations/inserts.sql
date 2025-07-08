-- Inserir especialidades
INSERT INTO Especialidade (nome) VALUES ('Cardiologia'), ('Dermatologia');

-- Inserir usuários (tipo PACIENTE e MEDICO)
INSERT INTO Usuario (nome, email, dataNascimento, cpf, senha, tipo) VALUES
('João Silva', 'joao@example.com', '1980-05-10', '12345678901', 'hash_senha1', 'PACIENTE'),
('Dra. Maria Souza', 'maria@example.com', '1975-11-20', '10987654321', 'hash_senha2', 'MEDICO');

-- Inserir paciente (referencia ao usuário João)
INSERT INTO Paciente (idUsuario, planoSaude) VALUES
((SELECT id FROM Usuario WHERE email='joao@example.com'), 'Unimed');

-- Inserir médico (referencia ao usuário Maria e especialidade Cardiologia)
INSERT INTO Medico (idUsuario, idEspecialidade) VALUES
(
  (SELECT id FROM Usuario WHERE email='maria@example.com'),
  (SELECT id FROM Especialidade WHERE nome='Cardiologia')
);

-- Inserir CRMs para a médica Maria
INSERT INTO CRMs (idMedico, numero, estado) VALUES
(
  (SELECT idUsuario FROM Medico WHERE idUsuario = (SELECT id FROM Usuario WHERE email='maria@example.com')),
  '12345', 'RS'
);

-- Inserir agendamento entre paciente João e médica Maria
INSERT INTO Agendamento (
    idMedico, idPaciente, dataHoraInicio, dataHoraFim, status, criadoPor, editadoPor, ultimaAtualizacao, mensagem
) VALUES (
    (SELECT idUsuario FROM Medico WHERE idUsuario = (SELECT id FROM Usuario WHERE email='maria@example.com')),
    (SELECT idUsuario FROM Paciente WHERE idUsuario = (SELECT id FROM Usuario WHERE email='joao@example.com')),
    '2025-07-10 14:00:00', '2025-07-10 14:30:00', 'PENDENTE',
    (SELECT id FROM Usuario WHERE email='joao@example.com'),
    NULL,
    NULL,
    'Consulta inicial'
);

-- Inserir consulta vinculada ao agendamento
INSERT INTO Consulta (idAgendamento, dataHoraInicio, dataHoraFim, status, notasMedicas) VALUES
(
    (SELECT id FROM Agendamento WHERE mensagem='Consulta inicial'),
    '2025-07-10 14:00:00', '2025-07-10 14:30:00', 'AGENDADA',
    NULL
);

-- Inserir prescrição para a consulta
INSERT INTO Prescricao (idConsulta, nomeMedicamento, posologia, duracao) VALUES
(
    (SELECT id FROM Consulta WHERE idAgendamento = (SELECT id FROM Agendamento WHERE mensagem='Consulta inicial')),
    'Dipirona', '1 comprimido a cada 8 horas', '5 dias'
);

-- Inserir disponibilidade do médico (exemplo segunda-feira das 08h às 12h)
INSERT INTO DisponibilidadeMedico (idMedico, diaSemana, horaInicio, horaFim) VALUES
(
    (SELECT idUsuario FROM Medico WHERE idUsuario = (SELECT id FROM Usuario WHERE email='maria@example.com')),
    'SEGUNDA',
    '08:00:00',
    '12:00:00'
);

-- Inserir notificação para usuário João
INSERT INTO Notificacao (idUsuario, titulo, descricao, dataHora, lida) VALUES
(
    (SELECT id FROM Usuario WHERE email='joao@example.com'),
    'Lembrete de consulta',
    'Você tem uma consulta agendada para 10/07/2025 às 14:00',
    NOW(),
    FALSE
);
