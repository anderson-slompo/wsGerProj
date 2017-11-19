DROP VIEW IF EXISTS implantacao_dash;
CREATE VIEW implantacao_dash AS

SELECT i.id,
		i.id_funcionario,
	    i.nome as nome, 
	    TO_CHAR(i.data_hora, 'DD/MM/YYYY HH24:MI') AS data_hora, 
	    i.status, 
	    i.descricao, 
	    COUNT(it.id_tarefa) AS tot_tarefas,
	    TO_CHAR(MIN(data_inicio), 'DD/MM/YYYY') as previsao_inicio,
	    TO_CHAR(MAX(data_termino), 'DD/MM/YYYY') as previsao_fim,
	    CASE WHEN MAX(data_termino) < NOW() THEN TRUE ELSE FALSE END AS atrasada	    
FROM implantacao i
INNER JOIN implantacao_tarefas it ON it.id_implantacao = i.id
INNER JOIN tarefa_atribuicao ta ON ta.id_tarefa = it.id_tarefa 
								AND ta.fase = 4 
								AND ta.id_funcionario = i.id_funcionario

where i.status = 0

GROUP BY i.id,
		 i.id_funcionario,
         i.nome, 
         TO_CHAR(i.data_hora, 'DD/MM/YYYY HH24:MI'), 
         i.status, 
         i.descricao