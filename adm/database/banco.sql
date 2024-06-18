-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.28-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para casadalimpeza
CREATE DATABASE IF NOT EXISTS `casadalimpeza` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `casadalimpeza`;

-- Copiando estrutura para tabela casadalimpeza.tb_ambiente
CREATE TABLE IF NOT EXISTS `tb_ambiente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto` varchar(255) NOT NULL DEFAULT '0',
  `nome` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela casadalimpeza.tb_ambiente: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela casadalimpeza.tb_banner
CREATE TABLE IF NOT EXISTS `tb_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ban_nome` varchar(255) NOT NULL DEFAULT '0',
  `ban_titulo` varchar(255) NOT NULL DEFAULT '0',
  `ban_subtitulo` varchar(50) NOT NULL DEFAULT '0',
  `ban_link` text NOT NULL,
  `ban_posicao` int(11) NOT NULL DEFAULT 0,
  `ban_ordem` text NOT NULL,
  `ban_arquivo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela casadalimpeza.tb_banner: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela casadalimpeza.tb_categoria
CREATE TABLE IF NOT EXISTS `tb_categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto` text NOT NULL,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `url_amigavel` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela casadalimpeza.tb_categoria: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela casadalimpeza.tb_empresa
CREATE TABLE IF NOT EXISTS `tb_empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '0',
  `endereco` varchar(255) NOT NULL DEFAULT '0',
  `cidade` varchar(255) NOT NULL DEFAULT '0',
  `telefone` varchar(255) NOT NULL DEFAULT '0',
  `whatsapp` varchar(255) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '0',
  `facebook` varchar(255) NOT NULL DEFAULT '0',
  `instagram` varchar(255) NOT NULL DEFAULT '0',
  `horario_de_atendimento` varchar(255) NOT NULL DEFAULT '0',
  `link_whatsapp` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela casadalimpeza.tb_empresa: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela casadalimpeza.tb_log
CREATE TABLE IF NOT EXISTS `tb_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_type` varchar(255) NOT NULL DEFAULT '0',
  `log_link` varchar(255) NOT NULL DEFAULT '0',
  `log_usu_id` int(11) NOT NULL DEFAULT 0,
  `log_ip` varchar(150) NOT NULL DEFAULT '0',
  `log_el` varchar(255) NOT NULL DEFAULT '0',
  `log_el_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `log_usu_id` (`log_usu_id`),
  KEY `log_el_id` (`log_el_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela casadalimpeza.tb_log: ~12 rows (aproximadamente)
INSERT INTO `tb_log` (`id`, `log_type`, `log_link`, `log_usu_id`, `log_ip`, `log_el`, `log_el_id`) VALUES
	(1, 'ACCESS', '/wetransfer_site3_novo-fw-png_2024-06-17_1238/adm/banners/', 1, '127.0.0.1', 'BANNER', 0),
	(2, 'ACCESS', '/wetransfer_site3_novo-fw-png_2024-06-17_1238/adm/banners/', 1, '127.0.0.1', 'BANNER', 0),
	(3, 'ACCESS', '/wetransfer_site3_novo-fw-png_2024-06-17_1238/adm/banners/', 1, '127.0.0.1', 'BANNER', 0),
	(4, 'ACCESS', '/wetransfer_site3_novo-fw-png_2024-06-17_1238/adm/banners/', 1, '127.0.0.1', 'BANNER', 0),
	(5, 'ACCESS', '/wetransfer_site3_novo-fw-png_2024-06-17_1238/adm/banners/', 1, '127.0.0.1', 'BANNER', 0),
	(6, 'ACCESS', '/wetransfer_site3_novo-fw-png_2024-06-17_1238/adm/banners/novo.php', 1, '127.0.0.1', 'BANNER', 0),
	(7, 'ACCESS', '/wetransfer_site3_novo-fw-png_2024-06-17_1238/adm/produtos/', 1, '127.0.0.1', 'PRODUTO', 0),
	(8, 'ACCESS', '/wetransfer_site3_novo-fw-png_2024-06-17_1238/adm/produtos/', 1, '127.0.0.1', 'PRODUTO', 0),
	(9, 'ACCESS', '/wetransfer_site3_novo-fw-png_2024-06-17_1238/adm/marcas/', 1, '127.0.0.1', 'MARCA', 0),
	(10, 'ACCESS', '/wetransfer_site3_novo-fw-png_2024-06-17_1238/adm/categorias/', 1, '127.0.0.1', 'CATEGORIA', 0),
	(11, 'ACCESS', '/wetransfer_site3_novo-fw-png_2024-06-17_1238/adm/produtos/', 1, '127.0.0.1', 'PRODUTO', 0),
	(12, 'ACCESS', '/wetransfer_site3_novo-fw-png_2024-06-17_1238/adm/produtos/', 1, '127.0.0.1', 'PRODUTO', 0),
	(13, 'ACCESS', '/wetransfer_site3_novo-fw-png_2024-06-17_1238/adm/produtos/', 1, '127.0.0.1', 'PRODUTO', 0),
	(14, 'ACCESS', '/wetransfer_site3_novo-fw-png_2024-06-17_1238/adm/produtos/', 1, '127.0.0.1', 'PRODUTO', 0);

-- Copiando estrutura para tabela casadalimpeza.tb_marca
CREATE TABLE IF NOT EXISTS `tb_marca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto` text NOT NULL,
  `nome` varchar(255) NOT NULL DEFAULT '',
  `url_amigavel` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela casadalimpeza.tb_marca: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela casadalimpeza.tb_produto
CREATE TABLE IF NOT EXISTS `tb_produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '0',
  `url_amigavel` text NOT NULL,
  `descricao` text NOT NULL,
  `foto1` text NOT NULL,
  `foto2` text NOT NULL,
  `foto3` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `preco` decimal(10,2) NOT NULL DEFAULT 0.00,
  `desconto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `alteracao` datetime DEFAULT NULL,
  `id_categoria` int(11) NOT NULL DEFAULT 0,
  `id_marca` int(11) NOT NULL DEFAULT 0,
  `id_tipo` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`),
  KEY `id_marca` (`id_marca`),
  KEY `id_tipo` (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela casadalimpeza.tb_produto: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela casadalimpeza.tb_tipo
CREATE TABLE IF NOT EXISTS `tb_tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela casadalimpeza.tb_tipo: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela casadalimpeza.tb_usuario
CREATE TABLE IF NOT EXISTS `tb_usuario` (
  `usu_id` int(11) NOT NULL AUTO_INCREMENT,
  `usu_nome` varchar(55) NOT NULL,
  `usu_login` varchar(65) NOT NULL,
  `usu_senha` varchar(100) NOT NULL,
  `usu_status` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`usu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela casadalimpeza.tb_usuario: ~1 rows (aproximadamente)
INSERT INTO `tb_usuario` (`usu_id`, `usu_nome`, `usu_login`, `usu_senha`, `usu_status`) VALUES
	(1, 'suporte', 'suporte', '531225954e151ba16ea61fae23a7b750696210f3', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
