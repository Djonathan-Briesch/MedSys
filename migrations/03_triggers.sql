DELIMITER $$

CREATE TRIGGER after_insert_appointment
AFTER INSERT ON Appointment
FOR EACH ROW
BEGIN
    INSERT INTO Consultation (appointmentId, startDateTime, endDateTime, status, medicalNotes)
    VALUES (NEW.id, NEW.startDateTime, NEW.endDateTime, 'SCHEDULED', NULL);

    -- Criar notificação para o criador do agendamento
    INSERT INTO Notification (userId, title, description, dateTime, readFlag)
    VALUES (
        NEW.createdBy,
        'Agendamento criado',
        CONCAT('Seu agendamento #', NEW.id, ' foi criado com status ', NEW.status, '.'),
        NOW(),
        FALSE
    );
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER after_update_appointment_status
AFTER UPDATE ON Appointment
FOR EACH ROW
BEGIN
    IF NEW.status <> OLD.status THEN
        INSERT INTO Notification (userId, title, description, dateTime, readFlag)
        VALUES (
            NEW.createdBy,
            'Status do agendamento atualizado',
            CONCAT('O status do seu agendamento #', NEW.id, ' mudou de ', OLD.status, ' para ', NEW.status, '.'),
            NOW(),
            FALSE
        );
    END IF;
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER after_insert_consultation
AFTER INSERT ON Consultation
FOR EACH ROW
BEGIN
    DECLARE patientUserId BIGINT;

    SELECT patientId INTO patientUserId FROM Appointment WHERE id = NEW.appointmentId;

    INSERT INTO Notification (userId, title, description, dateTime, readFlag)
    VALUES (
        patientUserId,
        'Consulta criada',
        CONCAT('Sua consulta ligada ao agendamento #', NEW.appointmentId, ' foi criada.'),
        NOW(),
        FALSE
    );
END$$

DELIMITER ;
