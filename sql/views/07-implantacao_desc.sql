DROP VIEW IF EXISTS implantacao_desc;
CREATE VIEW implantacao_desc AS

SELECT i.id,
	    i.nome as nome, 
	    TO_CHAR(i.data_hora, 'DD/MM/YYYY HH24:MI') AS data_hora, 
	    i.status, 
	    i.descricao, 
	    f.nome as funcionario_nome,
	    COUNT(it.id_tarefa) AS tot_tarefas,
	    CASE WHEN i.status = 0 THEN 'Em Andamento'
	    	 WHEN i.status = 1 THEN 'Finalizada'
	    	 WHEN i.status = 2 THEN 'Cancelada'
	    END AS status_nome
FROM implantacao i
INNER JOIN funcionario f ON f.id = i.id_funcionario
INNER JOIN implantacao_tarefas it ON it.id_implantacao = i.id

GROUP BY i.id,
         i.nome, 
         TO_CHAR(i.data_hora, 'DD/MM/YYYY HH24:MI'), 
         i.status, 
         i.descricao, 
         f.nome