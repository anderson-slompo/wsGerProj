DROP VIEW IF EXISTS tarefas_gantt;
CREATE VIEW tarefas_gantt AS
SELECT ta.id as id,
        t.nome,
		t.nome || '(' || f.nome || ')' as name,
        t.status,
        TO_CHAR(ta.data_inicio, 'YYYYMMDD') as from,
        TO_CHAR(ta.data_termino, 'YYYYMMDD') as to,
        ta.conclusao as progress,
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
INNER JOIN funcionario f on f.id = ta.id_funcionario
where t.status <> 0