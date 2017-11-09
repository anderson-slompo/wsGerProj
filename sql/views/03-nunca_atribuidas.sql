DROP VIEW IF EXISTS nunca_atribuidas;
CREATE VIEW nunca_atribuidas AS
SELECT  t.id as tarefa_id,
        t.nome as tarefa_nome,
        p.nome as projeto_nome,
        p.id as projeto_id,
        t.tipo,
        t.status,
        'Nova'::varchar as status_nome
FROM tarefa t
INNER JOIN projeto p ON p.id = t.id_projeto
WHERE t.status = 1