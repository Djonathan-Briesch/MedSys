CREATE TABLE IF NOT EXISTS Usuario (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    dataNascimento DATE NOT NULL,
    cpf VARCHAR(20) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('PACIENTE', 'MEDICO') NOT NULL
);

CREATE TABLE IF NOT EXISTS Especialidade (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS Paciente (
    idUsuario BIGINT PRIMARY KEY,
    planoSaude VARCHAR(255),
    CONSTRAINT fk_paciente_usuario FOREIGN KEY (idUsuario) REFERENCES Usuario(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS Medico (
    idUsuario BIGINT PRIMARY KEY,
    idEspecialidade BIGINT NOT NULL,
    CONSTRAINT fk_medico_usuario FOREIGN KEY (idUsuario) REFERENCES Usuario(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_medico_especialidade FOREIGN KEY (idEspecialidade) REFERENCES Especialidade(id)
);

CREATE TABLE IF NOT EXISTS Agendamento (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    idMedico BIGINT NOT NULL,
    idPaciente BIGINT NOT NULL,
    dataHoraInicio DATETIME NOT NULL,
    dataHoraFim DATETIME NOT NULL,
    status ENUM('PENDENTE', 'CONFIRMADO', 'RECUSADO', 'ADIANTADO', 'ADIADO', 'CANCELADO') NOT NULL,
    observacoes TEXT,
    criadoPor BIGINT NOT NULL,
    editadoPor BIGINT,
    ultimaAtualizacao TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_agendamento_medico FOREIGN KEY (idMedico) REFERENCES Medico(idUsuario),
    CONSTRAINT fk_agendamento_paciente FOREIGN KEY (idPaciente) REFERENCES Paciente(idUsuario),
    CONSTRAINT fk_agendamento_criadoPor FOREIGN KEY (criadoPor) REFERENCES Usuario(id),
    CONSTRAINT fk_agendamento_editadoPor FOREIGN KEY (editadoPor) REFERENCES Usuario(id)
);

CREATE TABLE IF NOT EXISTS Consulta (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    idAgendamento BIGINT NOT NULL,
    dataHoraInicio DATETIME NOT NULL,
    dataHoraFim DATETIME NOT NULL,
    status ENUM('AGENDADA', 'EM_ANDAMENTO', 'FINALIZADA', 'CANCELADA') NOT NULL,
    notasMedicas TEXT,
    CONSTRAINT fk_consulta_agendamento FOREIGN KEY (idAgendamento) REFERENCES Agendamento(id)
);

CREATE TABLE IF NOT EXISTS Prescricao (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    idConsulta BIGINT NOT NULL,
    nomeMedicamento VARCHAR(255) NOT NULL,
    posologia VARCHAR(255) NOT NULL,
    duracao VARCHAR(100) NOT NULL,
    CONSTRAINT fk_prescricao_consulta FOREIGN KEY (idConsulta) REFERENCES Consulta(id)
);

CREATE TABLE IF NOT EXISTS Notificacao (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    idUsuario BIGINT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    dataHora DATETIME NOT NULL,
    lida BOOLEAN NOT NULL DEFAULT FALSE,
    CONSTRAINT fk_notificacao_usuario FOREIGN KEY (idUsuario) REFERENCES Usuario(id)
);

CREATE TABLE IF NOT EXISTS DisponibilidadeMedico (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    idMedico BIGINT NOT NULL,
    diaSemana ENUM('SEGUNDA', 'TERCA', 'QUARTA', 'QUINTA', 'SEXTA', 'SABADO', 'DOMINGO') NOT NULL,
    horaInicio TIME NOT NULL,
    horaFim TIME NOT NULL,
    CONSTRAINT fk_disponibilidade_medico FOREIGN KEY (idMedico) REFERENCES Medico(idUsuario)
);

CREATE TABLE IF NOT EXISTS CRMs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    idMedico BIGINT NOT NULL,
    numero VARCHAR(50) NOT NULL,
    estado VARCHAR(10) NOT NULL,
    CONSTRAINT fk_crm_medico FOREIGN KEY (idMedico) REFERENCES Medico(idUsuario),
    UNIQUE KEY unique_numero_estado (numero, estado)
);
