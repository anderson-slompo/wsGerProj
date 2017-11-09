DROP VIEW IF EXISTS tarefas_aguardando_atribuicao;
CREATE VIEW tarefas_aguardando_atribuicao AS
(SELECT * FROM aguardando_teste_sem_atribuicao)
UNION ALL
(SELECT * FROM tarefas_retorno_teste_sem_atribuicao)
UNION ALL
(SELECT * FROM aguardando_implantacao_sem_atribuicao)
UNION ALL
(SELECT * FROM nunca_atribuidas)