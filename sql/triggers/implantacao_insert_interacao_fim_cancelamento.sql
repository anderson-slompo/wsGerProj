DROP TRIGGER IF EXISTS implantacao_insert_interacao_fim_cancelamento ON implantacao;
DROP FUNCTION IF EXISTS implantacao_insert_interacao_fim_cancelamento();

CREATE FUNCTION implantacao_insert_interacao_fim_cancelamento()
  RETURNS trigger AS
$BODY$
DECLARE
    atrib RECORD;
    impl_str varchar;
    pct integer;
BEGIN
	CASE NEW.status
		WHEN 1 THEN
			impl_str:='[Implantação finalizada #'|| NEW.id ||']';
			pct:=100;
		WHEN 2 THEN
			impl_str:='[Implantação cancelada #'|| NEW.id ||']';
			pct:=0;
		ELSE
			RETURN NEW;
	END CASE;

	FOR atrib IN SELECT id_tarefa FROM implantacao_tarefas WHERE id_implantacao = NEW.id				
	LOOP
		INSERT INTO tarefa_interacao(id_tarefa, id_funcionario, conclusao, observacao, fase, data_hora)
		VALUES (atrib.id_tarefa, NEW.id_funcionario, pct, impl_str, 4, NOW());
	END LOOP;
	
	RETURN NEW;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


CREATE TRIGGER implantacao_insert_interacao_fim_cancelamento
AFTER UPDATE 
ON implantacao
FOR EACH ROW
EXECUTE PROCEDURE implantacao_insert_interacao_fim_cancelamento();