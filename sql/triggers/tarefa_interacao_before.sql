DROP TRIGGER IF EXISTS tarefa_interacao_trigger_before ON tarefa_interacao;
DROP FUNCTION IF EXISTS tarefa_interacao_before();

CREATE FUNCTION tarefa_interacao_before()
  RETURNS trigger AS
$BODY$
DECLARE
    atrib_rec RECORD;
BEGIN
	SELECT * INTO atrib_rec 
	FROM tarefa_atribuicao 
	WHERE id_tarefa = NEW.id_tarefa 
	AND id_funcionario = NEW.id_funcionario
	AND fase = NEW.fase
	AND conclusao < 100;
	
	IF NOT FOUND THEN
		RAISE EXCEPTION 'Você não pode interagir com uma tarefa que não esteja atribuído.'; 
	END IF;
	
	RETURN NEW;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


CREATE TRIGGER tarefa_interacao_trigger_before
BEFORE INSERT 
ON tarefa_interacao
FOR EACH ROW
EXECUTE PROCEDURE tarefa_interacao_before();