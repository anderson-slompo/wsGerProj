DROP TRIGGER IF EXISTS tarefa_interacao_trigger ON tarefa_interacao;
DROP FUNCTION IF EXISTS tarefa_interacao();

CREATE FUNCTION tarefa_interacao()
  RETURNS trigger AS
$BODY$
DECLARE
    intera RECORD;
    proximo_status integer;
    atrib_rec RECORD;
BEGIN
-- FASES interaçao: 
-- 1 -> Desenvolvimento
-- 2 -> Testes
-- 3 -> Retorno de testes
-- 4 -> Implantação
-- Status tarefas
-- 0 -> Cancelada
-- 1 -> Nova
-- 2 -> Aguardando desenvolvimento
-- 3 -> Desenvolvimento
-- 4 -> Aguardando testes
-- 5 -> Testes
-- 6 -> Retorno de testes
-- 7 -> Aguardando Implantação
-- 8 -> Implantada
	proximo_status:=NULL;
	
	
	UPDATE tarefa_atribuicao SET conclusao = NEW.CONCLUSAO WHERE id = (SELECT MIN(id)
																FROM tarefa_atribuicao 
																WHERE id_tarefa = NEW.id_tarefa 
																AND id_funcionario = NEW.id_funcionario
																AND fase = NEW.fase
																AND conclusao < 100);
	

	CASE NEW.fase
		WHEN 1 THEN 
			IF NEW.conclusao >= 100 THEN
				proximo_status:=4; -- aguardando testes
			ELSE
				proximo_status:=3; -- em desenvolvimento
			END IF;
		WHEN 2, 3 THEN
			IF NEW.conclusao >= 100 THEN
				SELECT COUNT(*) as total INTO intera FROM erro WHERE id_tarefa = NEW.id_tarefa AND corrigido = FALSE;
				IF intera.total > 0 THEN
					proximo_status:=6; -- retorno de testes
				ELSE
					proximo_status:=7; -- aguardando implantação
				END IF;
			ELSE
				proximo_status:=5; -- em testes
			END IF;
		WHEN 4 THEN
			IF NEW.conclusao >= 100 THEN
				proximo_status:=8; -- implantada
			END IF;
	END CASE;
	IF proximo_status IS NOT NULL THEN
		UPDATE tarefa SET status = proximo_status where id = NEW.id_tarefa;
	END IF;
	RETURN NEW;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


CREATE TRIGGER tarefa_interacao_trigger
AFTER INSERT 
ON tarefa_interacao
FOR EACH ROW
EXECUTE PROCEDURE tarefa_interacao();