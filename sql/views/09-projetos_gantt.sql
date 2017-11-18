DROP VIEW IF EXISTS projetos_gantt;
CREATE VIEW projetos_gantt AS
SELECT 'projeto_'||p.id as id, 
		p.nome as name,
		to_json(array_agg(ta.id order by ta.data_inicio)) as children
FROM projeto p
INNER JOIN tarefa t on t.id_projeto = p.id AND t. status <> 0
INNER JOIN tarefa_atribuicao ta on ta.id_tarefa = t.id
GROUP BY p.id