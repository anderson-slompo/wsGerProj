CREATE OR REPLACE FUNCTION tarefa_atribuicao()
  RETURNS trigger AS
$BODY$
DECLARE
    atrib RECORD;
BEGIN
-- FASES atribuicao: 
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

  CASE NEW.fase 
    WHEN 1 THEN
      UPDATE tarefa SET status = 2 where id = NEW.id_tarefa;
    WHEN 2 THEN
      SELECT COUNT(id) AS tot, MIN(data_inicio) as inicio INTO atrib
      FROM tarefa_atribuicao 
      WHERE id_tarefa = NEW.id_tarefa
      AND fase = 1;
      IF atrib.tot > 0 THEN
        IF atrib.inicio >= NEW.data_inicio THEN
          RAISE EXCEPTION 'A fase de testes não pode iniciar antes do desenvolvimento. O desenvolvimento inicia em %', TO_CHAR(atrib.inicio, 'DD/MM/YYYY');
          RETURN FALSE;
        END IF;
      END IF;
    WHEN 4 THEN
      SELECT COUNT(id) AS tot, MAX(data_termino) as fim INTO atrib
      FROM tarefa_atribuicao 
      WHERE id_tarefa = NEW.id_tarefa
      AND fase IN(2,3);
      IF atrib.tot > 0 THEN
        IF atrib.fim >= NEW.data_inicio THEN
          RAISE EXCEPTION 'A fase de implpantação não pode iniciar antes da finalização dos testes. Os testes finalizam em %', TO_CHAR(atrib.fim, 'DD/MM/YYYY');
        END IF;
      ELSE
        SELECT COUNT(id) AS tot, MAX(data_termino) as fim INTO atrib
        FROM tarefa_atribuicao 
        WHERE id_tarefa = NEW.id_tarefa
        AND fase <> 4;
        IF atrib.tot > 0 THEN
          IF atrib.fim >= NEW.data_inicio THEN
            RAISE EXCEPTION 'A fase de implpantação não pode iniciar antes da finalização das outras fases. Elas finalizam em %', TO_CHAR(atrib.fim, 'DD/MM/YYYY');
          END IF;
        END IF;
      END IF;
  END CASE;
  RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql VOLATILE
COST 100;


CREATE TRIGGER tarefa_atribuicao_trigger
BEFORE INSERT 
ON tarefa_atribuicao
FOR EACH ROW
EXECUTE PROCEDURE tarefa_atribuicao();