CREATE DATABASE TCC_BOV;

USE TCC_BOV;

# Tabela STATUS do animal/usuário, ativo/inativo
CREATE TABLE STATUS (
	STA_ID		INT PRIMARY KEY NOT NULL,
    STA_DESC	VARCHAR(255)
);
#########        CADASTRAR STATUS     #########
# ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ #
INSERT INTO STATUS VALUES(1,'Ativo');
INSERT INTO STATUS VALUES(2,'Inativo');
# ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ #
#########        CADASTRAR STATUS     #########

CREATE TABLE USUARIO (
	USU_ID			INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    USU_NOME		VARCHAR(255),
    USU_EMAIL		VARCHAR(255),
    USU_SENHA		VARCHAR(255),
    USU_DTCADASTRO	DATETIME
);
######### PROCEDURE CADASTRAR USUARIO #########
# ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ #
DELIMITER $$

CREATE PROCEDURE AddUser(IN NOME VARCHAR(255), IN EMAIL VARCHAR(255), IN SENHA VARCHAR(255))
	BEGIN
		INSERT INTO USUARIO (USU_NOME, USU_EMAIL, USU_SENHA, USU_DTCADASTRO) VALUES (NOME, EMAIL, SENHA, Now());
	END $$
DELIMITER ;


##  CALL AddUser('Rodrigo','email','Senha');
# ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ #
######### PROCEDURE CADASTRAR USUARIO #########

# Tabela para Cadastrar as raças existentes que serão exibidas
CREATE TABLE RACA (
	RACA_ID			INT PRIMARY KEY NOT NULL,
    RACA_DESCRICAO	VARCHAR(255)
);
#########        CADASTRAR RAÇA       #########
# ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ #
INSERT INTO RACA VALUES(1, 'Gir');
INSERT INTO RACA VALUES(2, 'Cruzado');
INSERT INTO RACA VALUES(3, 'Holandesa');
INSERT INTO RACA VALUES(4, 'Jersey');
INSERT INTO RACA VALUES(5, 'Nelore');
INSERT INTO RACA VALUES(6, 'Nelore mocho');
INSERT INTO RACA VALUES(7, 'Tabapuã');
INSERT INTO RACA VALUES(8, 'Guzerá');
INSERT INTO RACA VALUES(9, 'Indubrasil');
INSERT INTO RACA VALUES(10, 'Sindi');
INSERT INTO RACA VALUES(11, 'Brahma');
INSERT INTO RACA VALUES(12, 'Shorthorn');
INSERT INTO RACA VALUES(13, 'Polled Hereford');
INSERT INTO RACA VALUES(14, 'Hereford');
INSERT INTO RACA VALUES(15, 'Aberdeem Angus');
INSERT INTO RACA VALUES(16, 'Red Angus');
INSERT INTO RACA VALUES(17, 'Red Poll');
INSERT INTO RACA VALUES(18, 'Devon');
INSERT INTO RACA VALUES(19, 'Charolês');
INSERT INTO RACA VALUES(20, 'Chianina');
INSERT INTO RACA VALUES(21, 'Marchigiana');
INSERT INTO RACA VALUES(22, 'Blonde Daquitane');
INSERT INTO RACA VALUES(23, 'Piemontês');
INSERT INTO RACA VALUES(24, 'Limosin');
INSERT INTO RACA VALUES(25, 'Simental');
INSERT INTO RACA VALUES(26, 'Normanda');
INSERT INTO RACA VALUES(27, 'Simental');
INSERT INTO RACA VALUES(28, 'Flechwiech');
INSERT INTO RACA VALUES(29, 'Caracu');
INSERT INTO RACA VALUES(30, 'Pardo-suíço');
INSERT INTO RACA VALUES(31, 'Santa Gertrudis');
INSERT INTO RACA VALUES(32, 'Brangus');
INSERT INTO RACA VALUES(33, 'Ibagé');
INSERT INTO RACA VALUES(34, 'Braford');
INSERT INTO RACA VALUES(35, 'Canchim');
INSERT INTO RACA VALUES(36, 'Pitangueiras');
INSERT INTO RACA VALUES(37, 'Santa Gabriela');
INSERT INTO RACA VALUES(38, 'Tropicana');
INSERT INTO RACA VALUES(39, 'Beefalo');
# ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ #
#########        CADASTRAR RAÇA       #########

# Tabela para cadastrar as vacinas existentes que serão exibidas
CREATE TABLE CADASTROVACINA (
	CADVAC_ID			INT PRIMARY KEY NOT NULL,
    CADVAC_DESCRICAO	VARCHAR(255)
);
#########        CADASTRAR VACINA     #########
# ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ #
INSERT INTO CADASTROVACINA VALUES (1, 'Vacinação Mastite ou Mamite');
INSERT INTO CADASTROVACINA VALUES (2, 'Vacinação Tristeza Parasitária Bovina (babesiose/ anaplasmose)');
INSERT INTO CADASTROVACINA VALUES (3, 'Vacinação Brucelose');
INSERT INTO CADASTROVACINA VALUES (4, 'Vacinação Tuberculose');
INSERT INTO CADASTROVACINA VALUES (5, 'Vacinação Febre Aftosa');
INSERT INTO CADASTROVACINA VALUES (6, 'Vacinação Leptospirose');
INSERT INTO CADASTROVACINA VALUES (7, 'Vacinação Clostridioses');
INSERT INTO CADASTROVACINA VALUES (8, 'Vacinação Doenças de Casco');
INSERT INTO CADASTROVACINA VALUES (9, 'Vacinação Babesiose');
INSERT INTO CADASTROVACINA VALUES (10, 'Vacinação Verminoses');
INSERT INTO CADASTROVACINA VALUES (11, 'Vacinação Rinotraqueíte Infecciosa Bovina (IBR) - Viral');
INSERT INTO CADASTROVACINA VALUES (12, 'Vacinação Diarréia bovina a vírus (BVD) - Viral');
INSERT INTO CADASTROVACINA VALUES (13, 'Vacinação Neosporose ');
INSERT INTO CADASTROVACINA VALUES (14, 'Vacinação Campilobacteriose ');
INSERT INTO CADASTROVACINA VALUES (15, 'Vacinação Tricomoniase ');
# ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ #
#########        CADASTRAR VACINA     #########

# Tabela para cadastrar as doenças existentes que serão exibidas
CREATE TABLE CADASTRODOENCA (
	CADDOENCA_ID	INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    CADDOENCA_DESC	VARCHAR(255)
); 
# ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ # 

INSERT INTO CADASTRODOENCA VALUES (1, 'Mastite ou Mamite');
INSERT INTO CADASTRODOENCA VALUES (2, 'Tristeza Parasitária Bovina (babesiose/ anaplasmose)');
INSERT INTO CADASTRODOENCA VALUES (3, 'Brucelose');
INSERT INTO CADASTRODOENCA VALUES (4, 'Tuberculose');
INSERT INTO CADASTRODOENCA VALUES (5, 'Febre Aftosa');
INSERT INTO CADASTRODOENCA VALUES (6, 'Leptospirose');
INSERT INTO CADASTRODOENCA VALUES (7, 'Clostridioses');
INSERT INTO CADASTRODOENCA VALUES (8, 'Doenças de Casco');
INSERT INTO CADASTRODOENCA VALUES (9, 'Babesiose');
INSERT INTO CADASTRODOENCA VALUES (10, 'Verminoses');
INSERT INTO CADASTRODOENCA VALUES (11, 'Rinotraqueíte Infecciosa Bovina (IBR) - Viral');
INSERT INTO CADASTRODOENCA VALUES (12, 'Diarréia bovina a vírus (BVD) - Viral');
INSERT INTO CADASTRODOENCA VALUES (13, 'Neosporose ');
INSERT INTO CADASTRODOENCA VALUES (14, 'Campilobacteriose ');
INSERT INTO CADASTRODOENCA VALUES (15, 'Tricomoniase ');

# ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ #
#########        CADASTRAR VACINA     #########

# Tabela com principais dados do animal
CREATE TABLE BOVINO (
	BOV_STA			INT NOT NULL,								FOREIGN KEY (BOV_STA)	REFERENCES STATUS			(STA_ID),
    BOV_USU			INT NOT NULL,								FOREIGN KEY (BOV_USU)	REFERENCES USUARIO			(USU_ID),
    BOV_ID			INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    BOV_BRINCO		VARCHAR(255) NOT NULL,
    BOV_TIPO		VARCHAR(50),
    BOV_RACA		INT NOT NULL,								FOREIGN KEY (BOV_RACA)	REFERENCES RACA				(RACA_ID),
    BOV_PAI			INT,										FOREIGN KEY	(BOV_PAI)	REFERENCES BOVINO			(BOV_ID),
    BOV_MAE			INT,										FOREIGN KEY	(BOV_MAE)	REFERENCES BOVINO			(BOV_ID),
    BOV_PRODUCLITRO	FLOAT,
    BOV_PRODUCARROBA FLOAT,
    BOV_DT_NASC		DATE,
    BOV_DT_AQUIS	DATE,
    BOV_DT_VENDA	DATE,
    BOV_DT_DESMAME	DATE
);

######### PROCEDURE CADASTRAR BOVINOS #########
# ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ #
DELIMITER $$

CREATE PROCEDURE AddBov(IN BOV_STA INT,
						IN BOV_USU INT,
                        IN BOV_BRINCO VARCHAR(255),
                        IN BOV_TIPO VARCHAR(255),
                        IN BOV_RACA INT,
                        IN BOV_PAI INT,
                        IN BOV_MAE INT,
                        IN BOV_PRODUCLITRO FLOAT,
                        IN BOV_PRODUCARROBA FLOAT,
                        IN BOV_DT_NASC DATE,
                        IN BOV_DT_AQUIS DATE,
                        IN BOV_DT_VENDA DATE)
	BEGIN
		INSERT INTO BOVINO (BOV_STA, BOV_USU, BOV_BRINCO, BOV_TIPO, BOV_RACA, BOV_PAI, BOV_MAE, BOV_PRODUCLITRO, BOV_PRODUCARROBA, BOV_DT_NASC, BOV_DT_AQUIS,  BOV_DT_VENDA)
					VALUES (BOV_STA, BOV_USU, BOV_BRINCO, BOV_TIPO, BOV_RACA, BOV_PAI, BOV_MAE, BOV_PRODUCLITRO, BOV_PRODUCARROBA, BOV_DT_NASC, BOV_DT_AQUIS,  BOV_DT_VENDA);
	END $$
DELIMITER ;

##  CALL AddBov();
# ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ #
######### PROCEDURE CADASTRAR BOVINOS #########

# Tabela para cadastrar as vacinas realizadas nos bovinos, podendo um bovino ter várias vacinas
CREATE TABLE VACINACAO (
	VAC_ID			INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    CADVAC_ID		INT,										FOREIGN KEY	(CADVAC_ID)	REFERENCES 	CADASTROVACINA	(CADVAC_ID),
    VAC_BOV_ID		INT,										FOREIGN KEY	(VAC_BOV_ID)REFERENCES	BOVINO			(BOV_ID),
    VAC_DATA		DATE,
    VAC_DATA_CAD	DATETIME
);

# Tabela para cadastrar as doenças de um bovino, podendo um bovino ter várias doenças
CREATE TABLE REGISTRADOENCA (
	REGDOENCA_ID	INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    CADDOE_ID		INT,										FOREIGN KEY	(CADDOE_ID)	REFERENCES CADASTRODOENCA	(CADDOENCA_ID),
    REG_BOV_ID		INT,										FOREIGN KEY (REG_BOV_ID)REFERENCES BOVINO			(BOV_ID),
    REGDOENCA_DATA	DATE,
    REGDOENCA_DATA_CAD	DATETIME,
    REGDOENCA_MEDIC	TEXT
);

# Tabela para cadastrar o peso do animal, podendo ser cadastrado mais de um peso por animal
CREATE TABLE PESO (
	PESO_ID			INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    PESO_ANIMAL		INT,
    PESO_BOV_ID		INT,										FOREIGN KEY	(PESO_BOV_ID)REFERENCES BOVINO			(BOV_ID),
    PESO_DATA		DATETIME
);

CREATE TABLE PRODUCAO (
	PRODUC_ID		INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    PRODUC_LITROS	INT,
    PRODUC_BOV_ID	INT,										FOREIGN KEY (PRODUC_BOV_ID) REFERENCES BOVINO		(BOV_ID),
    PRODUC_DATA	DATETIME
);

CREATE TABLE INSEMINACAO (
	INSEM_ID		INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    INSEM_DESCRICAO VARCHAR(500),
    INSEM_DATA		DATE,
    INSEM_BOV_ID	INT,										FOREIGN KEY (INSEM_BOV_ID)	REFERENCES BOVINO (BOV_ID)
);
