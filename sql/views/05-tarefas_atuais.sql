DROP VIEW IF EXISTS tarefas_atuais;
CREATE VIEW tarefas_atuais AS
SELECT ta.id as id,
		t.id as tarefa_id,
        t.nome as tarefa_nome,
        p.nome as projeto_nome,
        p.id as projeto_id,
        ta.id_funcionario,
        t.tipo,
        t.status,
        TO_CHAR(ta.data_inicio, 'DD/MM/YYYY') as inicio,
        TO_CHAR(ta.data_termino, 'DD/MM/YYYY') as termino,
        ta.conclusao,
        CASE WHEN data_termino < NOW() THEN true ELSE false END AS atrasada,
        CASE WHEN t.status = 0 THEN 'Cancelada'
             WHEN t.status = 1 THEN 'Nova'
             WHEN t.status = 2 THEN 'Aguardando desenvolvimento'
             WHEN t.status = 3 THEN 'Desenvolvimento'
             WHEN t.status = 4 THEN 'Aguardando testes'
             WHEN t.status = 5 THEN 'Testes'
             WHEN t.status = 6 THEN 'Retorno de testes'
             WHEN t.status = 7 THEN 'Aguardando Implantação'
             WHEN t.status = 8 THEN 'Implantada' END AS status_nome,
        ta.fase,
        CASE WHEN ta.fase = 1 THEN 'Desenvolvimento'
             WHEN ta.fase = 2 THEN 'Testes'
             WHEN ta.fase = 3 THEN 'Retorno de testes'
             WHEN ta.fase = 4 THEN 'Implantação' END AS fase_nome
FROM tarefa t
INNER JOIN projeto p ON p.id = t.id_projeto
INNER JOIN tarefa_atribuicao ta ON ta.id_tarefa = t.id
WHERE ta.conclusao < 100
AND ( 
        (ta.fase = 1 AND t.status IN (2,3))
        OR
        (ta.fase = 2 AND t.status IN (4,5))
        OR 
        (ta.fase = 3 AND t.status = 6)
        OR 
        (ta.fase = 4 AND t.status = 7)
)