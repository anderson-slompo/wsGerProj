CREATE OR REPLACE FUNCTION tarefa_log()
  RETURNS trigger AS
$BODY$
DECLARE
    dados_antes JSON;
    dados_depois JSON;
BEGIN
    dados_antes := row_to_json(OLD);
    dados_depois := row_to_json(NEW);
    
    INSERT INTO tarefa_log (id_tarefa, data_hora, dados_antes, dados_depois, id_funcionario) VALUES( NEW.id_tarefa, NOW(), dados_antes, dados_depois, NEW.id_funcionario);
    RETURN NEW;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


CREATE TRIGGER tarefa_log_trigger
AFTER UPDATE 
ON tarefa_interacao
FOR EACH ROW
EXECUTE PROCEDURE tarefa_log();