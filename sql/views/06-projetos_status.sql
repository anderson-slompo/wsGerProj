DROP VIEW IF EXISTS status_projetos;
CREATE VIEW status_projetos AS
SELECT p.id,
        p.nome,
        p.descricao,
        COUNT(DISTINCT CASE WHEN t.status IN(3,5,6,7) THEN t.id END) AS tot_em_execucao,
        (SELECT COUNT(DISTINCT tarefa_id) FROM tarefas_atuais WHERE atrasada is true AND projeto_id = p.id) AS tot_atrasadas,
        (SELECT COUNT(DISTINCT tarefa_id) FROM tarefas_aguardando_atribuicao WHERE projeto_id = p.id) AS tot_aguardando_atribuicao
FROM projeto p
LEFT JOIN tarefa t ON t.id_projeto = p.id and t.status IN(2,3,4,5,6,7)
GROUP BY p.id