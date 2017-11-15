DROP TRIGGER IF EXISTS implantacao_tarefa_insert_interacao ON implantacao_tarefas;
DROP FUNCTION IF EXISTS implantacao_tarefa_insert_interacao();

CREATE FUNCTION implantacao_tarefa_insert_interacao()
  RETURNS trigger AS
$BODY$
DECLARE
    atrib RECORD;
    impl RECORD;
    impl_str varchar;
BEGIN

	SELECT * INTO impl
	FROM implantacao 
	WHERE id = NEW.id_implantacao;

	SELECT * INTO atrib 
	FROM tarefa_atribuicao 
	WHERE id_tarefa = NEW.id_tarefa 
	AND id_funcionario = impl.id_funcionario
	AND fase = 4 
	AND conclusao < 100;
	IF FOUND THEN
		impl_str:='[Implantação iniciada #'|| NEW.id_implantacao ||']';

		INSERT INTO tarefa_interacao(id_tarefa, id_funcionario, conclusao, observacao, fase, data_hora)
		VALUES (NEW.id_tarefa, impl.id_funcionario, atrib.conclusao, impl_str, 4, NOW());
	END IF;
	
	RETURN NEW;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


CREATE TRIGGER implantacao_tarefa_insert_interacao
AFTER INSERT 
ON implantacao_tarefas
FOR EACH ROW
EXECUTE PROCEDURE implantacao_tarefa_insert_interacao();