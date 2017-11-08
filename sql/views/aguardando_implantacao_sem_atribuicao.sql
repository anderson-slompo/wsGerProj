DROP VIEW IF EXISTS aguardando_implantacao_sem_atribuicao;
CREATE VIEW aguardando_implantacao_sem_atribuicao AS
SELECT  t.id as tarefa_id,
        t.nome as tarefa_nome,
        p.nome as projeto_nome,
        p.id as projeto_id,
        t.tipo,
        t.status,
        'Aguardando Implantação'::varchar as status_nome
FROM tarefa t
INNER JOIN projeto p ON p.id = t.id_projeto
WHERE t.status = 7
AND NOT EXISTS (
SELECT id FROM tarefa_atribuicao where id_tarefa = t.id AND fase = 4 AND conclusao < 100
)