DROP TRIGGER IF EXISTS erro_insert_interacao ON erro;
DROP FUNCTION IF EXISTS erro_insert_interacao();

CREATE FUNCTION erro_insert_interacao()
  RETURNS trigger AS
$BODY$
DECLARE
    atrib RECORD;
    erro_str varchar;
BEGIN

	SELECT * INTO atrib 
	FROM tarefa_atribuicao 
	WHERE id_tarefa = NEW.id_tarefa 
	AND id_funcionario = NEW.id_funcionario
	AND fase IN(2,3)
	AND conclusao < 100;
	IF FOUND THEN
		erro_str:='[Erro reportado #'|| NEW.id ||'] '|| NEW.nome;

		INSERT INTO tarefa_interacao(id_tarefa, id_funcionario, conclusao, observacao, fase, data_hora)
		VALUES (NEW.id_tarefa, NEW.id_funcionario, atrib.conclusao, erro_str, atrib.fase, NOW());
	END IF;
	
	RETURN NEW;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


CREATE TRIGGER erro_insert_interacao
AFTER INSERT 
ON erro
FOR EACH ROW
EXECUTE PROCEDURE erro_insert_interacao();