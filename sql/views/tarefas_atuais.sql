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
        CASE WHEN data_termino < NOW() THEN true ELSE false END AS atrasada
FROM tarefa t
INNER JOIN projeto p ON p.id = t.id_projeto
INNER JOIN tarefa_atribuicao ta ON ta.id_tarefa = t.id
WHERE ta.conclusao < 100