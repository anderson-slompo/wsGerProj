
CREATE SEQUENCE public.anexo_id_seq;

CREATE TABLE public.anexo (
                id INTEGER NOT NULL DEFAULT nextval('public.anexo_id_seq'),
                caminho VARCHAR(255) NOT NULL,
                nome VARCHAR(50) NOT NULL,
                descricao VARCHAR(255) NOT NULL,
                original VARCHAR(100) NOT NULL,
                CONSTRAINT anexo_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.anexo IS 'Armazena os arquivos enviados como anexo em tarefas ou projetos.';
COMMENT ON COLUMN public.anexo.id IS 'Identificador único gerado pelo sistema.';
COMMENT ON COLUMN public.anexo.caminho IS 'Caminho onde o arquivo foi salvo no servidor';
COMMENT ON COLUMN public.anexo.nome IS 'Nome informado pelo usuário para o arquivo.';
COMMENT ON COLUMN public.anexo.descricao IS 'Descrição do arquivo informado pelo usuário.';
COMMENT ON COLUMN public.anexo.original IS 'Nome original do arquivo.';


ALTER SEQUENCE public.anexo_id_seq OWNED BY public.anexo.id;

CREATE SEQUENCE public.implantacao_id_seq;

CREATE TABLE public.implantacao (
                id INTEGER NOT NULL DEFAULT nextval('public.implantacao_id_seq'),
                data_hora TIMESTAMP NOT NULL,
                nome VARCHAR(50) NOT NULL,
                descricao TEXT NOT NULL,
                status INTEGER NOT NULL,
                id_funcionario integer NOT NULL,
                CONSTRAINT implantacao_pk PRIMARY KEY (id),
                CONSTRAINT implantacao_id_funcionario_fkey FOREIGN KEY (id_funcionario)
                      REFERENCES funcionario (id) MATCH SIMPLE
                      ON UPDATE NO ACTION ON DELETE NO ACTION
);
COMMENT ON TABLE public.implantacao IS 'Armazena as implantações a serem executadas.';
COMMENT ON COLUMN public.implantacao.id IS 'Identificador único gerado pelo sistema.';
COMMENT ON COLUMN public.implantacao.data_hora IS 'Momento em que a implantação foi armaenada.';
COMMENT ON COLUMN public.implantacao.nome IS 'Nome único para a implantação.';
COMMENT ON COLUMN public.implantacao.descricao IS 'Descritivo da implantação e seus impactos.';
COMMENT ON COLUMN public.implantacao.status IS 'Situação atual da implantação. Ex.: Concluida.';


ALTER SEQUENCE public.implantacao_id_seq OWNED BY public.implantacao.id;

CREATE SEQUENCE public.projeto_id_seq;

CREATE TABLE public.projeto (
                id INTEGER NOT NULL DEFAULT nextval('public.projeto_id_seq'),
                nome VARCHAR(50) NOT NULL,
                descricao TEXT NOT NULL,
                CONSTRAINT projeto_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.projeto IS 'Armazena os projetos de desenvolvimento de software que são desenvolvidos pela empresa.';
COMMENT ON COLUMN public.projeto.id IS 'Identificador único gerado pelo sistema.';
COMMENT ON COLUMN public.projeto.nome IS 'Campo unico com o nome do projeto a ser desenvolvido.';
COMMENT ON COLUMN public.projeto.descricao IS 'Breve descrição do escopo do projeto.';


ALTER SEQUENCE public.projeto_id_seq OWNED BY public.projeto.id;

CREATE TABLE public.projeto_anexos (
                id_projeto INTEGER NOT NULL,
                id_anexo INTEGER NOT NULL,
                CONSTRAINT projeto_anexos_pk PRIMARY KEY (id_projeto, id_anexo)
);
COMMENT ON TABLE public.projeto_anexos IS 'Armazenas relacionamento deprojeto com os anexos enviados.';
COMMENT ON COLUMN public.projeto_anexos.id_projeto IS 'Identificador do projeto.';
COMMENT ON COLUMN public.projeto_anexos.id_anexo IS 'Identificador do arquivo anexo.';


CREATE SEQUENCE public.tarefa_id_seq;

CREATE TABLE public.tarefa (
                id INTEGER NOT NULL DEFAULT nextval('public.tarefa_id_seq'),
                id_projeto INTEGER,
                nome VARCHAR(50) NOT NULL,
                descricao TEXT NOT NULL,
                tipo INTEGER NOT NULL,
                status INTEGER NOT NULL,
                CONSTRAINT tarefa_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.tarefa IS 'Armazena as tarefas para cada projeto.';
COMMENT ON COLUMN public.tarefa.id IS 'Identificador único gerado pelo sistema.';
COMMENT ON COLUMN public.tarefa.id_projeto IS 'Identificador do projeto.';
COMMENT ON COLUMN public.tarefa.nome IS 'Palavra ou sentença que descreva brevemente a tarefa.';
COMMENT ON COLUMN public.tarefa.descricao IS 'Descrição detalhada do que é esperado na tarefa.';
COMMENT ON COLUMN public.tarefa.tipo IS '1 - nova / 2 - melhoria';
COMMENT ON COLUMN public.tarefa.status IS 'Campo atribuido automaticamente pelo sistema atrvess da fase e progresso informados pelo usuário:  1 - Nova / 2 - Aguardando desenvolvimento / 3 - Em desenvolvimento / 4 - Aguardando testes / 5 - Em teste / 6 - Retorno de teste / 7 - Aguardando implantação / 8 - Implantada / 0 - Cancelada';


ALTER SEQUENCE public.tarefa_id_seq OWNED BY public.tarefa.id;

CREATE SEQUENCE public.tarefa_itens_id_seq;

CREATE TABLE public.tarefa_itens (
                id INTEGER NOT NULL DEFAULT nextval('public.tarefa_itens_id_seq'),
                id_tarefa INTEGER NOT NULL,
                titulo VARCHAR(100) NOT NULL,
                descricao TEXT,
                porcentagem INTEGER NOT NULL,
                status SMALLINT DEFAULT 0 NOT NULL,
                CONSTRAINT tarefa_itens_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.tarefa_itens IS 'Armazena os passos necessários para efetuar a tarefa bem como a porcentagem que cada item corresponde da totalidade da tarefa.';
COMMENT ON COLUMN public.tarefa_itens.id IS 'Identificador do item';
COMMENT ON COLUMN public.tarefa_itens.id_tarefa IS 'Identificador único gerado pelo sistema.';
COMMENT ON COLUMN public.tarefa_itens.porcentagem IS 'Campo que representa a quanto do total da tarefao item representa.';
COMMENT ON COLUMN public.tarefa_itens.status IS 'Campo que indica se um determinado item já foi comcluido ou não.
0 - Pendente
1 - Concluido';


ALTER SEQUENCE public.tarefa_itens_id_seq OWNED BY public.tarefa_itens.id;

CREATE TABLE public.tarefa_anexos (
                id_tarefa INTEGER NOT NULL,
                id_anexo INTEGER NOT NULL,
                CONSTRAINT tarefa_anexos_pk PRIMARY KEY (id_tarefa, id_anexo)
);
COMMENT ON TABLE public.tarefa_anexos IS 'Armazena a relação das tarefas com os anexos enviados.';
COMMENT ON COLUMN public.tarefa_anexos.id_tarefa IS 'Identificador da tarefa.';
COMMENT ON COLUMN public.tarefa_anexos.id_anexo IS 'Identificador do arquivo anexo.';


CREATE SEQUENCE public.erro_id_seq;

CREATE TABLE public.erro (
                id INTEGER NOT NULL DEFAULT nextval('public.erro_id_seq'),
                id_tarefa INTEGER DEFAULT NULL,
                nome VARCHAR(50) NOT NULL,
                descricao TEXT NOT NULL,
                id_projeto INTEGER,
                id_funcionario integer NOT NULL,
                id_funcionario_fix integer,
                corrigido boolean NOT NULL DEFAULT false,
                CONSTRAINT erro_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.erro IS 'Armazena as inconsistencias encontradas pela equipe de testes para cada tarefa ou projeto.';
COMMENT ON COLUMN public.erro.id IS 'Identificador único gerado pelo sistema.';
COMMENT ON COLUMN public.erro.id_tarefa IS 'Identificador da tarefa.';
COMMENT ON COLUMN public.erro.nome IS 'Palavra ou sentença que identifique brevemente o erro encontrado.';
COMMENT ON COLUMN public.erro.descricao IS 'Descrição completa do erro e dos passos necessários para gerá-lo.';
COMMENT ON COLUMN public.erro.id_projeto IS 'Identificador do projeto.';
COMMENT ON COLUMN public.erro.id_funcionario IS 'Identificador do funcionário que reportou o erro.';
COMMENT ON COLUMN public.erro.id_funcionario_fix IS 'Identificador do funcionário que corrigiu o erro.';


ALTER SEQUENCE public.erro_id_seq OWNED BY public.erro.id;

CREATE TABLE public.implantacao_tarefas (
                id_tarefa INTEGER NOT NULL,
                id_implantacao INTEGER NOT NULL,
                CONSTRAINT implantacao_tarefas_pk PRIMARY KEY (id_tarefa, id_implantacao)
);
COMMENT ON TABLE public.implantacao_tarefas IS 'Relaciona quais tarefas serão liberadas em uma determinada janela de  implantação.';
COMMENT ON COLUMN public.implantacao_tarefas.id_tarefa IS 'Identificador da tarefa.';
COMMENT ON COLUMN public.implantacao_tarefas.id_implantacao IS 'Identificador da implantação.';


CREATE TABLE public.tarefa_log (
                id serial NOT NULL,
                id_tarefa INTEGER NOT NULL,
                data_hora TIMESTAMP NOT NULL,
                dados_antes TEXT NOT NULL,
                dados_depois TEXT NOT NULL,
                id_funcionario INTEGER NOT NULL,
                CONSTRAINT tarefa_log_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.tarefa_log IS 'Armazena todas as alterações realizadas em uma tarefa.';
COMMENT ON COLUMN public.tarefa_log.id IS 'Identificador único gerado pelo sistema.';
COMMENT ON COLUMN public.tarefa_log.id_tarefa IS 'Identificador da tarefa que foi alterada.';
COMMENT ON COLUMN public.tarefa_log.data_hora IS 'Momento em que a edição foi realizada.';
COMMENT ON COLUMN public.tarefa_log.dados_antes IS 'Objeto serializado em JSON da tarefa antes da alteração.';
COMMENT ON COLUMN public.tarefa_log.dados_depois IS 'Objeto da tarefa serializado em JSON após a alteração ser realizada.';


CREATE SEQUENCE public.cliente_id_seq;

CREATE TABLE public.cliente (
                id INTEGER NOT NULL DEFAULT nextval('public.cliente_id_seq'),
                nome VARCHAR(255) NOT NULL,
                id_externo INTEGER NOT NULL,
                CONSTRAINT cliente_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.cliente IS 'Armazena apenas o básico do cliente pois todos já são gerenciados por um outro sistema de CRM.';
COMMENT ON COLUMN public.cliente.id IS 'Identificador único gerado pelo sistema.';
COMMENT ON COLUMN public.cliente.nome IS 'Nome completo do cliente';
COMMENT ON COLUMN public.cliente.id_externo IS 'Identificador do cliente no sistema de CRM.';


ALTER SEQUENCE public.cliente_id_seq OWNED BY public.cliente.id;

CREATE TABLE public.projetos_cliente (
                id_projeto INTEGER NOT NULL,
                id_cliente INTEGER NOT NULL,
                CONSTRAINT projetos_cliente_pk PRIMARY KEY (id_projeto, id_cliente)
);
COMMENT ON TABLE public.projetos_cliente IS 'Relaciona o cliente com os projetos que ele comprou da empresa.';
COMMENT ON COLUMN public.projetos_cliente.id_projeto IS 'Identificador do projeto.';
COMMENT ON COLUMN public.projetos_cliente.id_cliente IS 'Identificador do cliente.';


CREATE SEQUENCE public.departamento_id_seq;

CREATE TABLE public.departamento (
                id INTEGER NOT NULL DEFAULT nextval('public.departamento_id_seq'),
                descricao VARCHAR(50) NOT NULL,
                CONSTRAINT departamento_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.departamento IS 'Armazena os departamentos (pré-definidos). Ex,: Desenvolvimento, testes, gerência ...';
COMMENT ON COLUMN public.departamento.id IS 'Identificador único gerado pelo sistema.';
COMMENT ON COLUMN public.departamento.descricao IS 'Desenvolvimento, testes, implantação e gerência.';


ALTER SEQUENCE public.departamento_id_seq OWNED BY public.departamento.id;

CREATE SEQUENCE public.funcionario_id_seq;

CREATE TABLE public.funcionario (
                id INTEGER NOT NULL DEFAULT nextval('public.funcionario_id_seq'),
                nome VARCHAR(255) NOT NULL,
                login VARCHAR(50) NOT NULL,
                senha VARCHAR(32) NOT NULL,
                data_nascimento DATE,
                data_admissao DATE NOT NULL,
                status BOOLEAN DEFAULT true NOT NULL,
                CONSTRAINT funcionario_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.funcionario IS 'Armazena os funcionários com suas informações básicas e de acesso ao sistema.';
COMMENT ON COLUMN public.funcionario.id IS 'Identificador único gerado pelo sistema.';
COMMENT ON COLUMN public.funcionario.nome IS 'Nome completo do usuário.';
COMMENT ON COLUMN public.funcionario.login IS 'Usuário que será utilizado para realizar o acesso ao sistema.';
COMMENT ON COLUMN public.funcionario.senha IS 'Senha armazenada utilizando a criptografia hash MD5';
COMMENT ON COLUMN public.funcionario.data_nascimento IS 'Data de nascimento do funcionário.';
COMMENT ON COLUMN public.funcionario.data_admissao IS 'Data de contratação do funcionário.';
COMMENT ON COLUMN public.funcionario.status IS 'Ativo - true / Inatavo - false';


ALTER SEQUENCE public.funcionario_id_seq OWNED BY public.funcionario.id;

CREATE SEQUENCE public.tarefa_atribuicao_id_seq;

CREATE TABLE public.tarefa_atribuicao (
                id INTEGER NOT NULL DEFAULT nextval('public.tarefa_atribuicao_id_seq'),
                id_tarefa INTEGER NOT NULL,
                id_funcionario INTEGER NOT NULL,
                data_inicio DATE NOT NULL,
                data_termino DATE NOT NULL,
                fase INTEGER NOT NULL,
                data_hora TIMESTAMP NOT NULL,
                conclusao integer NOT NULL DEFAULT 0,
                CONSTRAINT tarefa_atribuicao_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.tarefa_atribuicao IS 'Armazena as atribuições de tarefa a funcionarios, bem como seu prazo de execussão e conclusão.';
COMMENT ON COLUMN public.tarefa_atribuicao.id IS 'Identificador único gerado pelo sistema.';
COMMENT ON COLUMN public.tarefa_atribuicao.id_tarefa IS 'Identificador da tarefa';
COMMENT ON COLUMN public.tarefa_atribuicao.id_funcionario IS 'Identificador do funcionário';
COMMENT ON COLUMN public.tarefa_atribuicao.data_inicio IS 'Data programada para inicio da tarefa.';
COMMENT ON COLUMN public.tarefa_atribuicao.data_termino IS 'Data programada para finalização da tarefa.';
COMMENT ON COLUMN public.tarefa_atribuicao.fase IS 'Campo gerado automaticamente seguinto o fluxo padrão do sistema, porem pode ser alterado pelo gerente.';
COMMENT ON COLUMN public.tarefa_atribuicao.data_hora IS 'Momento em que a atribuição da tarefa foi armazenada no sistema.';


ALTER SEQUENCE public.tarefa_atribuicao_id_seq OWNED BY public.tarefa_atribuicao.id;

CREATE SEQUENCE public.tarefa_interacao_id_seq;

CREATE TABLE public.tarefa_interacao (
                id INTEGER NOT NULL DEFAULT nextval('public.tarefa_interacao_id_seq'),
                id_tarefa INTEGER NOT NULL,
                id_funcionario INTEGER NOT NULL,
                conclusao INTEGER NOT NULL,
                observacao TEXT NOT NULL,
                fase INTEGER NOT NULL,
                data_hora TIMESTAMP NOT NULL,
                CONSTRAINT tarefa_interacao_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.tarefa_interacao IS 'Armazena as interações com a tarefa em todas as suas fases com percentual de conclusão.';
COMMENT ON COLUMN public.tarefa_interacao.id IS 'Identificador único gerado pelo sistema.';
COMMENT ON COLUMN public.tarefa_interacao.id_tarefa IS 'Identificador da tarefa.';
COMMENT ON COLUMN public.tarefa_interacao.id_funcionario IS 'Identificador do funcionario que interage com a tarefa.';
COMMENT ON COLUMN public.tarefa_interacao.conclusao IS 'Armazena percentual de conclusão da tarefa para a fase atual da mesma. Campo calculado automaticamente com base nos itens concluidos da mesma.';
COMMENT ON COLUMN public.tarefa_interacao.observacao IS 'Comentários pertinentes à interação com a tarefa para posterior consulta.';
COMMENT ON COLUMN public.tarefa_interacao.fase IS 'Fase da tarefa, gerada automaticamente baseado na informação de porcentagem de conclusão.';
COMMENT ON COLUMN public.tarefa_interacao.data_hora IS 'Momento em que a interação com a tarefa foi armazenada no sistema.';


ALTER SEQUENCE public.tarefa_interacao_id_seq OWNED BY public.tarefa_interacao.id;

CREATE TABLE public.projeto_funcionarios (
                id_projeto INTEGER NOT NULL,
                id_funcionario INTEGER NOT NULL,
                CONSTRAINT projeto_funcionarios_pk PRIMARY KEY (id_projeto, id_funcionario)
);
COMMENT ON TABLE public.projeto_funcionarios IS 'Relaciona funcionários que trabalham em cada projeto para que a listagem de funcionarios na atribuição da tarefa seja mais prática.';
COMMENT ON COLUMN public.projeto_funcionarios.id_projeto IS 'Identificador do projeto.';
COMMENT ON COLUMN public.projeto_funcionarios.id_funcionario IS 'Identificador do funcionário.';


CREATE TABLE public.departamentos_funcionario (
                id_funcionario INTEGER NOT NULL,
                id_departamento INTEGER NOT NULL,
                CONSTRAINT departamentos_funcionario_pk PRIMARY KEY (id_funcionario, id_departamento)
);
COMMENT ON TABLE public.departamentos_funcionario IS 'Relaciona o funcionário aos departamentos em que ele atua. Tal relcionamento é utilizado para liberar ou bloquear funcionalidades dentro do sistema.';
COMMENT ON COLUMN public.departamentos_funcionario.id_funcionario IS 'Identificador do funcionário.';
COMMENT ON COLUMN public.departamentos_funcionario.id_departamento IS 'Identificador do departamento.';


CREATE SEQUENCE public.tipo_endereco_id_seq;

CREATE TABLE public.tipo_endereco (
                id INTEGER NOT NULL DEFAULT nextval('public.tipo_endereco_id_seq'),
                descricao VARCHAR(50) NOT NULL,
                CONSTRAINT tipo_endereco_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.tipo_endereco IS 'Armazena os possíveis tipos de endereço para cadastro dos contatos. Ex.: Residencial, comercial...';
COMMENT ON COLUMN public.tipo_endereco.id IS 'Identificador único gerado pelo sistema.';


ALTER SEQUENCE public.tipo_endereco_id_seq OWNED BY public.tipo_endereco.id;

CREATE TABLE public.funcionario_enderecos (
                id_funcionario INTEGER NOT NULL,
                id_tipo_endereco INTEGER NOT NULL,
                endereco VARCHAR(255) NOT NULL,
                CONSTRAINT funcionario_enderecos_pk PRIMARY KEY (id_funcionario, id_tipo_endereco)
);
COMMENT ON TABLE public.funcionario_enderecos IS 'Relaciona os endereços dos funcionarios com o tipo adequado de endereço.';
COMMENT ON COLUMN public.funcionario_enderecos.id_funcionario IS 'Identificador do funcionário.';
COMMENT ON COLUMN public.funcionario_enderecos.id_tipo_endereco IS 'Identificador do tipo de endereço.';
COMMENT ON COLUMN public.funcionario_enderecos.endereco IS 'Endereço prorpriamente dito.';


CREATE SEQUENCE public.tipo_contato_id_seq;

CREATE TABLE public.tipo_contato (
                id INTEGER NOT NULL DEFAULT nextval('public.tipo_contato_id_seq'),
                descricao VARCHAR(50) NOT NULL,
                CONSTRAINT tipo_contato_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.tipo_contato IS 'Armazena os diversos tipos de contato possíveis. Ex.: Celular, residencial...';
COMMENT ON COLUMN public.tipo_contato.id IS 'Identificador único gerado pelo sistema.';


ALTER SEQUENCE public.tipo_contato_id_seq OWNED BY public.tipo_contato.id;

CREATE TABLE public.funcionario_contatos (
                id_funcionario INTEGER NOT NULL,
                id_tipo_contato INTEGER NOT NULL,
                contato VARCHAR(255) NOT NULL,
                CONSTRAINT funcionario_contatos_pk PRIMARY KEY (id_funcionario, id_tipo_contato)
);
COMMENT ON TABLE public.funcionario_contatos IS 'Relaciona o funcionario com seus contatos e tipo de cada contato.';
COMMENT ON COLUMN public.funcionario_contatos.id_funcionario IS 'Identificador do funcionário.';
COMMENT ON COLUMN public.funcionario_contatos.id_tipo_contato IS 'Identificador do tipo de contato.';
COMMENT ON COLUMN public.funcionario_contatos.contato IS 'Contato prorpiamente dito';


ALTER TABLE public.tarefa_anexos ADD CONSTRAINT anexo_tarefa_anexos_fk
FOREIGN KEY (id_anexo)
REFERENCES public.anexo (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.projeto_anexos ADD CONSTRAINT anexo_projeto_anexos_fk
FOREIGN KEY (id_anexo)
REFERENCES public.anexo (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.implantacao_tarefas ADD CONSTRAINT implantacao_implantacao_tarefas_fk
FOREIGN KEY (id_implantacao)
REFERENCES public.implantacao (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.projetos_cliente ADD CONSTRAINT projeto_projetos_cliente_fk
FOREIGN KEY (id_projeto)
REFERENCES public.projeto (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.projeto_funcionarios ADD CONSTRAINT projeto_projeto_funcionarios_fk
FOREIGN KEY (id_projeto)
REFERENCES public.projeto (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.tarefa ADD CONSTRAINT projeto_tarefa_fk
FOREIGN KEY (id_projeto)
REFERENCES public.projeto (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.erro ADD CONSTRAINT projeto_erro_fk
FOREIGN KEY (id_projeto)
REFERENCES public.projeto (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.projeto_anexos ADD CONSTRAINT projeto_projeto_anexos_fk
FOREIGN KEY (id_projeto)
REFERENCES public.projeto (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.tarefa_interacao ADD CONSTRAINT tarefa_tarefa_interacao_fk
FOREIGN KEY (id_tarefa)
REFERENCES public.tarefa (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.tarefa_atribuicao ADD CONSTRAINT tarefa_tarefa_atribuicao_fk
FOREIGN KEY (id_tarefa)
REFERENCES public.tarefa (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.tarefa_log ADD CONSTRAINT tarefa_tarefa_log_fk
FOREIGN KEY (id_tarefa)
REFERENCES public.tarefa (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.implantacao_tarefas ADD CONSTRAINT tarefa_implantacao_tarefas_fk
FOREIGN KEY (id_tarefa)
REFERENCES public.tarefa (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.erro ADD CONSTRAINT tarefa_erro_fk
FOREIGN KEY (id_tarefa)
REFERENCES public.tarefa (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.erro ADD CONSTRAINT funcionario_erro_fk
FOREIGN KEY (id_funcionario)
REFERENCES public.funcionario (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE erro ADD CONSTRAINT funcionario_fix_fk 
  FOREIGN KEY (id_funcionario_fix) 
  REFERENCES funcionario (id) 
  ON UPDATE NO ACTION 
  ON DELETE NO ACTION;


ALTER TABLE public.tarefa_anexos ADD CONSTRAINT tarefa_tarefa_anexos_fk
FOREIGN KEY (id_tarefa)
REFERENCES public.tarefa (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.tarefa_itens ADD CONSTRAINT tarefa_tarefa_itens_fk
FOREIGN KEY (id_tarefa)
REFERENCES public.tarefa (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.projetos_cliente ADD CONSTRAINT cliente_projetos_cliente_fk
FOREIGN KEY (id_cliente)
REFERENCES public.cliente (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.departamentos_funcionario ADD CONSTRAINT departamento_departamentos_funcionario_fk
FOREIGN KEY (id_departamento)
REFERENCES public.departamento (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.funcionario_contatos ADD CONSTRAINT funcionario_funcionario_contatos_fk
FOREIGN KEY (id_funcionario)
REFERENCES public.funcionario (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.funcionario_enderecos ADD CONSTRAINT funcionario_funcionario_enderecos_fk
FOREIGN KEY (id_funcionario)
REFERENCES public.funcionario (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.departamentos_funcionario ADD CONSTRAINT funcionario_departamentos_funcionario_fk
FOREIGN KEY (id_funcionario)
REFERENCES public.funcionario (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.projeto_funcionarios ADD CONSTRAINT funcionario_projeto_funcionarios_fk
FOREIGN KEY (id_funcionario)
REFERENCES public.funcionario (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.tarefa_interacao ADD CONSTRAINT funcionario_tarefa_interacao_fk
FOREIGN KEY (id_funcionario)
REFERENCES public.funcionario (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.tarefa_atribuicao ADD CONSTRAINT funcionario_tarefa_atribuicao_fk
FOREIGN KEY (id_funcionario)
REFERENCES public.funcionario (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.funcionario_enderecos ADD CONSTRAINT tipo_endereco_funcionario_enderecos_fk
FOREIGN KEY (id_tipo_endereco)
REFERENCES public.tipo_endereco (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE public.funcionario_contatos ADD CONSTRAINT tipo_contato_funcionario_contatos_fk
FOREIGN KEY (id_tipo_contato)
REFERENCES public.tipo_contato (id)
ON DELETE NO ACTION
ON UPDATE NO ACTION
NOT DEFERRABLE;

-----------------------------------------------------
-- INSERTS

INSERT INTO departamento VALUES
(1, 'Desenvolvimento'),
(2, 'Testes'),
(3, 'Implantação'),
(4, 'Gerência');

INSERT INTO tipo_endereco
VALUES (1, 'Residencial'), (2, 'Comercial');

INSERT INTO tipo_contato
VALUES (1, 'Celular'), (2, 'Fixo');

INSERT INTO funcionario (nome,login,senha,data_nascimento,data_admissao,status)
VALUES ('Gerente Geral', 'gerente', '1e48c4420b7073bc11916c6c1de226bb', '1991-09-16', '1991-01-16', true);
INSERT INTO departamentos_funcionario(id_funcionario, id_departamento) VALUES (1,4);

-----------------------------------------------------
-- TRIGGERS

DROP TRIGGER IF EXISTS erro_insert_interacao ON erro;
DROP FUNCTION IF EXISTS erro_insert_interacao();

CREATE FUNCTION erro_insert_interacao()
  RETURNS trigger AS
$BODY$
DECLARE
    atrib RECORD;
    erro_str varchar;
BEGIN

    SELECT * INTO atrib 
    FROM tarefa_atribuicao 
    WHERE id_tarefa = NEW.id_tarefa 
    AND id_funcionario = NEW.id_funcionario
    AND fase IN(2,3)
    AND conclusao < 100;
    IF FOUND THEN
        erro_str:='[Erro reportado #'|| NEW.id ||'] '|| NEW.nome;

        INSERT INTO tarefa_interacao(id_tarefa, id_funcionario, conclusao, observacao, fase, data_hora)
        VALUES (NEW.id_tarefa, NEW.id_funcionario, atrib.conclusao, erro_str, atrib.fase, NOW());
    END IF;
    
    RETURN NEW;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


CREATE TRIGGER erro_insert_interacao
AFTER INSERT 
ON erro
FOR EACH ROW
EXECUTE PROCEDURE erro_insert_interacao();

DROP TRIGGER IF EXISTS erro_insert_interacao_fix ON erro;
DROP FUNCTION IF EXISTS erro_insert_interacao_fix();

CREATE FUNCTION erro_insert_interacao_fix()
  RETURNS trigger AS
$BODY$
DECLARE
    atrib RECORD;
    erro_str varchar;
BEGIN
    IF NEW.corrigido THEN
        SELECT * INTO atrib 
        FROM tarefa_atribuicao 
        WHERE id_tarefa = NEW.id_tarefa 
        AND id_funcionario = NEW.id_funcionario
        AND fase IN(2,3)
        AND conclusao < 100;
        IF FOUND THEN
            erro_str:='[Erro corrigido #'|| NEW.id ||'] '|| NEW.nome;

            INSERT INTO tarefa_interacao(id_tarefa, id_funcionario, conclusao, observacao, fase, data_hora)
            VALUES (NEW.id_tarefa, NEW.id_funcionario_fix, atrib.conclusao, erro_str, atrib.fase, NOW());
        END IF;
    END IF;
    RETURN NEW;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


CREATE TRIGGER erro_insert_interacao_fix
AFTER UPDATE 
ON erro
FOR EACH ROW
EXECUTE PROCEDURE erro_insert_interacao_fix();

DROP TRIGGER IF EXISTS implantacao_insert_interacao_fim_cancelamento ON implantacao;
DROP FUNCTION IF EXISTS implantacao_insert_interacao_fim_cancelamento();

CREATE FUNCTION implantacao_insert_interacao_fim_cancelamento()
  RETURNS trigger AS
$BODY$
DECLARE
    atrib RECORD;
    impl_str varchar;
    pct integer;
BEGIN
    CASE NEW.status
        WHEN 1 THEN
            impl_str:='[Implantação finalizada #'|| NEW.id ||']';
            pct:=100;
        WHEN 2 THEN
            impl_str:='[Implantação cancelada #'|| NEW.id ||']';
            pct:=0;
        ELSE
            RETURN NEW;
    END CASE;

    FOR atrib IN SELECT id_tarefa FROM implantacao_tarefas WHERE id_implantacao = NEW.id                
    LOOP
        INSERT INTO tarefa_interacao(id_tarefa, id_funcionario, conclusao, observacao, fase, data_hora)
        VALUES (atrib.id_tarefa, NEW.id_funcionario, pct, impl_str, 4, NOW());
    END LOOP;
    
    RETURN NEW;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


CREATE TRIGGER implantacao_insert_interacao_fim_cancelamento
AFTER UPDATE 
ON implantacao
FOR EACH ROW
EXECUTE PROCEDURE implantacao_insert_interacao_fim_cancelamento();

DROP TRIGGER IF EXISTS implantacao_tarefa_insert_interacao ON implantacao_tarefas;
DROP FUNCTION IF EXISTS implantacao_tarefa_insert_interacao();

CREATE FUNCTION implantacao_tarefa_insert_interacao()
  RETURNS trigger AS
$BODY$
DECLARE
    atrib RECORD;
    impl RECORD;
    impl_str varchar;
BEGIN

    SELECT * INTO impl
    FROM implantacao 
    WHERE id = NEW.id_implantacao;

    SELECT * INTO atrib 
    FROM tarefa_atribuicao 
    WHERE id_tarefa = NEW.id_tarefa 
    AND id_funcionario = impl.id_funcionario
    AND fase = 4 
    AND conclusao < 100;
    IF FOUND THEN
        impl_str:='[Implantação iniciada #'|| NEW.id_implantacao ||']';

        INSERT INTO tarefa_interacao(id_tarefa, id_funcionario, conclusao, observacao, fase, data_hora)
        VALUES (NEW.id_tarefa, impl.id_funcionario, atrib.conclusao, impl_str, 4, NOW());
    END IF;
    
    RETURN NEW;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


CREATE TRIGGER implantacao_tarefa_insert_interacao
AFTER INSERT 
ON implantacao_tarefas
FOR EACH ROW
EXECUTE PROCEDURE implantacao_tarefa_insert_interacao();

DROP TRIGGER IF EXISTS tarefa_atribuicao_trigger ON tarefa_atribuicao;
DROP FUNCTION IF EXISTS tarefa_atribuicao();

CREATE OR REPLACE FUNCTION tarefa_atribuicao()
  RETURNS trigger AS
$BODY$
DECLARE
    atrib RECORD;
    tarefa RECORD;
BEGIN
-- FASES atribuicao: 
-- 1 -> Desenvolvimento
-- 2 -> Testes
-- 3 -> Retorno de testes
-- 4 -> Implantação

-- Status tarefas
-- 0 -> Cancelada
-- 1 -> Nova
-- 2 -> Aguardando desenvolvimento
-- 3 -> Desenvolvimento
-- 4 -> Aguardando testes
-- 5 -> Testes
-- 6 -> Retorno de testes
-- 7 -> Aguardando Implantação
-- 8 -> Implantada

  IF NEW.data_inicio > NEW.data_termino THEN
    RAISE EXCEPTION 'A data de início não pode ser superior à data final.';
  END IF;
  
  SELECT * INTO tarefa FROM tarefa WHERE id = NEW.id_tarefa;
  IF tarefa.status = 4 AND NEW.fase = 1 THEN
    RAISE EXCEPTION 'Não é possivel realizar a atribuição na fase de Desenvolvimento, pois a tarefa esta aguardando testes';
  END IF;

  IF tarefa.status = 5 AND NEW.fase = 1 THEN
    RAISE EXCEPTION 'Não é possivel realizar a atribuição na fase de Desenvolvimento, pois a tarefa esta em testes';
  END IF;

  IF (tarefa.status = 6 AND NEW.fase IN(1,2)) THEN
    RAISE EXCEPTION 'Não é possivel realizar a atribuição na fase de escolhida, pois a tarefa esta em retorno de testes';
  END IF;

  IF (tarefa.status = 7 AND NEW.fase IN(1,2,3)) THEN
    RAISE EXCEPTION 'Não é possivel realizar a atribuição na fase de escolhida, pois a tarefa esta aguardando implpantação';
  END IF;

  IF tarefa.status = 0 THEN
    RAISE EXCEPTION 'Não é possivel realizar a atribuição em uma tarefa cancelada';
  END IF;

  IF tarefa.status = 8 THEN
    RAISE EXCEPTION 'Não é possivel realizar a atribuição em uma tarefa implantada';
  END IF;

  CASE NEW.fase 
    WHEN 1 THEN
      UPDATE tarefa SET status = 2 where id = NEW.id_tarefa;
    WHEN 2 THEN
      SELECT COUNT(id) AS tot, MIN(data_inicio) as inicio INTO atrib
      FROM tarefa_atribuicao 
      WHERE id_tarefa = NEW.id_tarefa
      AND fase = 1;
      IF atrib.tot > 0 THEN
        IF atrib.inicio >= NEW.data_inicio THEN
          RAISE EXCEPTION 'A fase de testes não pode iniciar antes do desenvolvimento. O desenvolvimento inicia em %', TO_CHAR(atrib.inicio, 'DD/MM/YYYY');
          RETURN FALSE;
        END IF;
      END IF;
    WHEN 4 THEN
      SELECT COUNT(id) AS tot, MAX(data_termino) as fim INTO atrib
      FROM tarefa_atribuicao 
      WHERE id_tarefa = NEW.id_tarefa
      AND fase IN(2,3);
      IF atrib.tot > 0 THEN
        IF atrib.fim >= NEW.data_inicio THEN
          RAISE EXCEPTION 'A fase de implpantação não pode iniciar antes da finalização dos testes. Os testes finalizam em %', TO_CHAR(atrib.fim, 'DD/MM/YYYY');
        END IF;
      ELSE
        SELECT COUNT(id) AS tot, MAX(data_termino) as fim INTO atrib
        FROM tarefa_atribuicao 
        WHERE id_tarefa = NEW.id_tarefa
        AND fase <> 4;
        IF atrib.tot > 0 THEN
          IF atrib.fim >= NEW.data_inicio THEN
            RAISE EXCEPTION 'A fase de implpantação não pode iniciar antes da finalização das outras fases. Elas finalizam em %', TO_CHAR(atrib.fim, 'DD/MM/YYYY');
          END IF;
        END IF;
      END IF;
      select count(distinct(id_tarefa)) as tot_implantacao, MIN(i.id) as id_implantacao INTO atrib
      FROM implantacao_tarefas it 
      INNER JOIN implantacao i ON i.id = it.id_implantacao AND i.status <> 2
      WHERE it.id_tarefa = NEW.id_tarefa;
      IF atrib.tot_implantacao > 0 THEN 
        RAISE EXCEPTION 'A tarefa já está adicionada à uma implantação #%', atrib.id_implantacao;
      END IF;
    ELSE
      RETURN NEW;
  END CASE;
  RETURN NEW;
END;
$BODY$
LANGUAGE plpgsql VOLATILE
COST 100;


CREATE TRIGGER tarefa_atribuicao_trigger
BEFORE INSERT 
ON tarefa_atribuicao
FOR EACH ROW
EXECUTE PROCEDURE tarefa_atribuicao();

DROP TRIGGER IF EXISTS tarefa_interacao_trigger ON tarefa_interacao;
DROP FUNCTION IF EXISTS tarefa_interacao();

CREATE FUNCTION tarefa_interacao()
  RETURNS trigger AS
$BODY$
DECLARE
    intera RECORD;
    proximo_status integer;
    atrib_rec RECORD;
BEGIN
-- FASES interaçao: 
-- 1 -> Desenvolvimento
-- 2 -> Testes
-- 3 -> Retorno de testes
-- 4 -> Implantação
-- Status tarefas
-- 0 -> Cancelada
-- 1 -> Nova
-- 2 -> Aguardando desenvolvimento
-- 3 -> Desenvolvimento
-- 4 -> Aguardando testes
-- 5 -> Testes
-- 6 -> Retorno de testes
-- 7 -> Aguardando Implantação
-- 8 -> Implantada
    proximo_status:=NULL;
    
    
    UPDATE tarefa_atribuicao SET conclusao = NEW.CONCLUSAO WHERE id = (SELECT MIN(id)
                                                                FROM tarefa_atribuicao 
                                                                WHERE id_tarefa = NEW.id_tarefa 
                                                                AND id_funcionario = NEW.id_funcionario
                                                                AND fase = NEW.fase
                                                                AND conclusao < 100);
    

    CASE NEW.fase
        WHEN 1 THEN 
            IF NEW.conclusao >= 100 THEN
                proximo_status:=4; -- aguardando testes
            ELSE
                proximo_status:=3; -- em desenvolvimento
            END IF;
        WHEN 2 THEN
            IF NEW.conclusao >= 100 THEN
                SELECT COUNT(*) as total INTO intera FROM erro WHERE id_tarefa = NEW.id_tarefa AND corrigido = FALSE;
                IF intera.total > 0 THEN
                    proximo_status:=6; -- retorno de testes
                ELSE
                    proximo_status:=7; -- aguardando implantação
                END IF;
            ELSE
                proximo_status:=5; -- em testes
            END IF;
        WHEN 3 THEN 
            IF NEW.conclusao >= 100 THEN
                proximo_status:=4;
            END IF;
        WHEN 4 THEN
            IF NEW.conclusao >= 100 THEN
                proximo_status:=8; -- implantada
            END IF;
        ELSE
            RAISE EXCEPTION 'Fase informada inválida';
    END CASE;
    IF proximo_status IS NOT NULL THEN
        UPDATE tarefa SET status = proximo_status where id = NEW.id_tarefa;
    END IF;
    RETURN NEW;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


CREATE TRIGGER tarefa_interacao_trigger
AFTER INSERT 
ON tarefa_interacao
FOR EACH ROW
EXECUTE PROCEDURE tarefa_interacao();

    DROP TRIGGER IF EXISTS tarefa_interacao_trigger_before ON tarefa_interacao;
DROP FUNCTION IF EXISTS tarefa_interacao_before();

CREATE FUNCTION tarefa_interacao_before()
  RETURNS trigger AS
$BODY$
DECLARE
    atrib_rec RECORD;
BEGIN
    SELECT * INTO atrib_rec 
    FROM tarefa_atribuicao 
    WHERE id_tarefa = NEW.id_tarefa 
    AND id_funcionario = NEW.id_funcionario
    AND fase = NEW.fase
    AND conclusao < 100;
    
    IF NOT FOUND THEN
        RAISE EXCEPTION 'Você não pode interagir com uma tarefa que não esteja atribuído.'; 
    END IF;
    
    RETURN NEW;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


CREATE TRIGGER tarefa_interacao_trigger_before
BEFORE INSERT 
ON tarefa_interacao
FOR EACH ROW
EXECUTE PROCEDURE tarefa_interacao_before();

CREATE OR REPLACE FUNCTION tarefa_log()
  RETURNS trigger AS
$BODY$
DECLARE
    dados_antes JSON;
    dados_depois JSON;
BEGIN
    dados_antes := row_to_json(OLD);
    dados_depois := row_to_json(NEW);
    
    INSERT INTO tarefa_log (id_tarefa, data_hora, dados_antes, dados_depois, id_funcionario) VALUES( NEW.id_tarefa, NOW(), dados_antes, dados_depois, NEW.id_funcionario);
    RETURN NEW;
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


CREATE TRIGGER tarefa_log_trigger
AFTER UPDATE 
ON tarefa_interacao
FOR EACH ROW
EXECUTE PROCEDURE tarefa_log();

-----------------------------------------------------
-- VIEWS

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

DROP VIEW IF EXISTS aguardando_teste_sem_atribuicao;
CREATE VIEW aguardando_teste_sem_atribuicao AS
SELECT  t.id as tarefa_id,
        t.nome as tarefa_nome,
        p.nome as projeto_nome,
        p.id as projeto_id,
        t.tipo,
        t.status,
        'Aguardando testes'::varchar as status_nome
FROM tarefa t
INNER JOIN projeto p ON p.id = t.id_projeto
WHERE t.status = 4
AND NOT EXISTS (
SELECT id FROM tarefa_atribuicao where id_tarefa = t.id AND fase = 2 AND conclusao < 100
)

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

DROP VIEW IF EXISTS tarefas_retorno_teste_sem_atribuicao;
CREATE VIEW tarefas_retorno_teste_sem_atribuicao AS
SELECT  t.id as tarefa_id,
        t.nome as tarefa_nome,
        p.nome as projeto_nome,
        p.id as projeto_id,
        t.tipo,
        t.status,
        'Retorno de testes'::varchar as status_nome
FROM tarefa t
INNER JOIN projeto p ON p.id = t.id_projeto
WHERE t.status = 6
AND NOT EXISTS (
SELECT id FROM tarefa_atribuicao where id_tarefa = t.id AND fase = 3 AND conclusao < 100
)

DROP VIEW IF EXISTS tarefas_aguardando_atribuicao;
CREATE VIEW tarefas_aguardando_atribuicao AS
(SELECT * FROM aguardando_teste_sem_atribuicao)
UNION ALL
(SELECT * FROM tarefas_retorno_teste_sem_atribuicao)
UNION ALL
(SELECT * FROM aguardando_implantacao_sem_atribuicao)
UNION ALL
(SELECT * FROM nunca_atribuidas)

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

DROP VIEW IF EXISTS projetos_gantt;
CREATE VIEW projetos_gantt AS
SELECT 'projeto_'||p.id as id, 
        p.nome as name,
        to_json(array_agg(ta.id order by ta.data_inicio)) as children
FROM projeto p
INNER JOIN tarefa t on t.id_projeto = p.id AND t. status <> 0
INNER JOIN tarefa_atribuicao ta on ta.id_tarefa = t.id
GROUP BY p.id

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
