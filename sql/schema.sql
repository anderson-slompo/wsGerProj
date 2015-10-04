
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
                CONSTRAINT implantacao_pk PRIMARY KEY (id)
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
                CONSTRAINT erro_pk PRIMARY KEY (id)
);
COMMENT ON TABLE public.erro IS 'Armazena as inconsistencias encontradas pela equipe de testes para cada tarefa ou projeto.';
COMMENT ON COLUMN public.erro.id IS 'Identificador único gerado pelo sistema.';
COMMENT ON COLUMN public.erro.id_tarefa IS 'Identificador da tarefa.';
COMMENT ON COLUMN public.erro.nome IS 'Palavra ou sentença que identifique brevemente o erro encontrado.';
COMMENT ON COLUMN public.erro.descricao IS 'Descrição completa do erro e dos passos necessários para gerá-lo.';
COMMENT ON COLUMN public.erro.id_projeto IS 'Identificador do projeto.';


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
                id INTEGER NOT NULL,
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