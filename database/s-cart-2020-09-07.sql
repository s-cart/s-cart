-- MariaDB dump 10.17  Distrib 10.4.11-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: s-cart
-- ------------------------------------------------------
-- Server version	10.4.11-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2020_00_00_step1_create_tables_admin',1),(2,'2020_00_00_step2_create_tables_shop',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES (1,NULL,'SCart Personal Access Client','vm2Msfc79nmLF8vi4WG0sWPSS1k0hBYhvvSv9bTW','http://localhost',1,0,0,'2020-09-07 15:37:57','2020-09-07 15:37:57'),(2,NULL,'SCart Password Grant Client','qhbQ2jRfO4CdL5nsCNsGdaxNJgxW4Nle9RkkerEE','http://localhost',0,1,0,'2020-09-07 15:37:57','2020-09-07 15:37:57');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` VALUES (1,1,'2020-09-07 15:37:57','2020-09-07 15:37:57');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_admin_config`
--

DROP TABLE IF EXISTS `sc_admin_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_admin_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  `detail` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_admin_config_key_store_id_unique` (`key`,`store_id`),
  KEY `sc_admin_config_code_index` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_admin_config`
--

LOCK TABLES `sc_admin_config` WRITE;
/*!40000 ALTER TABLE `sc_admin_config` DISABLE KEYS */;
INSERT INTO `sc_admin_config` VALUES (1,'Plugins','Payment','Cash','1',0,0,'Plugins/Payment/Cash::lang.title'),(2,'Plugins','Shipping','ShippingStandard','1',0,0,'lang::Shipping Standard'),(3,'global','env_global','ADMIN_LOG','on',0,0,'lang::env.ADMIN_LOG'),(4,'global','env_global','ADMIN_LOG_EXP','',0,0,'lang::env.ADMIN_LOG_EXP'),(5,'global','config_other','domain_strict','0',0,1,'lang::config.domain_strict'),(6,'global','cache','cache_status','0',0,0,'lang::cache.config_manager.cache_status'),(7,'global','cache','cache_time','600',0,0,'lang::cache.config_manager.cache_time'),(8,'global','cache','cache_category','0',0,3,'lang::cache.config_manager.cache_category'),(9,'global','cache','cache_product','0',0,4,'lang::cache.config_manager.cache_product'),(10,'global','cache','cache_news','0',0,5,'lang::cache.config_manager.cache_news'),(11,'global','cache','cache_category_cms','0',0,6,'lang::cache.config_manager.cache_category_cms'),(12,'global','cache','cache_content_cms','0',0,7,'lang::cache.config_manager.cache_content_cms'),(13,'global','cache','cache_page','0',0,8,'lang::cache.config_manager.cache_page'),(14,'global','cache','cache_country','0',0,10,'lang::cache.config_manager.cache_country'),(15,'','product_config_attribute','product_brand','1',0,0,'lang::product.config_manager.brand'),(16,'','product_config_attribute_required','product_brand_required','1',0,0,''),(17,'','product_config_attribute','product_supplier','1',0,0,'lang::product.config_manager.supplier'),(18,'','product_config_attribute_required','product_supplier_required','1',0,0,''),(19,'','product_config_attribute','product_price','1',0,0,'lang::product.config_manager.price'),(20,'','product_config_attribute_required','product_price_required','1',0,0,''),(21,'','product_config_attribute','product_cost','1',0,0,'lang::product.config_manager.cost'),(22,'','product_config_attribute_required','product_cost_required','1',0,0,''),(23,'','product_config_attribute','product_promotion','1',0,0,'lang::product.config_manager.promotion'),(24,'','product_config_attribute_required','product_promotion_required','1',0,0,''),(25,'','product_config_attribute','product_stock','1',0,0,'lang::product.config_manager.stock'),(26,'','product_config_attribute_required','product_stock_required','1',0,0,''),(27,'','product_config_attribute','product_kind','1',0,0,'lang::product.config_manager.kind'),(28,'','product_config_attribute','product_property','1',0,0,'lang::product.config_manager.property'),(29,'','product_config_attribute_required','product_property_required','1',0,0,''),(30,'','product_config_attribute','product_attribute','1',0,0,'lang::product.config_manager.attribute'),(31,'','product_config_attribute_required','product_attribute_required','1',0,0,''),(32,'','product_config_attribute','product_available','1',0,0,'lang::product.config_manager.available'),(33,'','product_config_attribute_required','product_available_required','1',0,0,''),(34,'','product_config_attribute','product_weight','1',0,0,'lang::product.config_manager.weight'),(35,'','product_config_attribute_required','product_weight_required','1',0,0,''),(36,'','product_config_attribute','product_length','1',0,0,'lang::product.config_manager.length'),(37,'','product_config_attribute_required','product_length_required','1',0,0,''),(38,'','product_config','product_display_out_of_stock','1',0,19,'lang::admin.product_display_out_of_stock'),(39,'','product_config','show_date_available','1',0,21,'lang::admin.show_date_available'),(40,'','product_config','product_tax','1',0,0,'lang::product.config_manager.tax'),(41,'','customer_config_attribute','customer_lastname','1',0,0,'lang::customer.config_manager.lastname'),(42,'','customer_config_attribute_required','customer_lastname_required','1',0,0,''),(43,'','customer_config_attribute','customer_address1','1',0,0,'lang::customer.config_manager.address1'),(44,'','customer_config_attribute_required','customer_address1_required','1',0,0,''),(45,'','customer_config_attribute','customer_address2','1',0,0,'lang::customer.config_manager.address2'),(46,'','customer_config_attribute_required','customer_address2_required','1',0,0,''),(47,'','customer_config_attribute','customer_company','0',0,0,'lang::customer.config_manager.company'),(48,'','customer_config_attribute_required','customer_company_required','0',0,0,''),(49,'','customer_config_attribute','customer_postcode','0',0,0,'lang::customer.config_manager.postcode'),(50,'','customer_config_attribute_required','customer_postcode_required','0',0,0,''),(51,'','customer_config_attribute','customer_country','1',0,0,'lang::customer.config_manager.country'),(52,'','customer_config_attribute_required','customer_country_required','1',0,0,''),(53,'','customer_config_attribute','customer_group','0',0,0,'lang::customer.config_manager.group'),(54,'','customer_config_attribute_required','customer_group_required','0',0,0,''),(55,'','customer_config_attribute','customer_birthday','0',0,0,'lang::customer.config_manager.birthday'),(56,'','customer_config_attribute_required','customer_birthday_required','0',0,0,''),(57,'','customer_config_attribute','customer_sex','0',0,0,'lang::customer.config_manager.sex'),(58,'','customer_config_attribute_required','customer_sex_required','0',0,0,''),(59,'','customer_config_attribute','customer_phone','1',0,1,'lang::customer.config_manager.phone'),(60,'','customer_config_attribute_required','customer_phone_required','1',0,1,''),(61,'','customer_config_attribute','customer_name_kana','0',0,1,'lang::customer.config_manager.name_kana'),(62,'','customer_config_attribute_required','customer_name_kana_required','0',0,1,''),(63,'','admin_config','ADMIN_NAME','SCart System',0,0,'lang::env.ADMIN_NAME'),(64,'','admin_config','ADMIN_TITLE','SCart System',0,0,'lang::env.ADMIN_TITLE'),(65,'','admin_config','ADMIN_LOGO','SCart Admin',0,0,'lang::env.ADMIN_LOGO'),(66,'','admin_config','LOG_SLACK_WEBHOOK_URL','',0,0,'lang::env.LOG_SLACK_WEBHOOK_URL'),(67,'','display_config','product_top','8',0,0,'lang::admin.product_top'),(68,'','display_config','product_list','12',0,0,'lang::admin.list_product'),(69,'','display_config','product_relation','4',0,0,'lang::admin.relation_product'),(70,'','display_config','product_viewed','4',0,0,'lang::admin.viewed_product'),(71,'','display_config','item_list','12',0,0,'lang::admin.item_list'),(72,'','display_config','item_top','8',0,0,'lang::admin.item_top'),(73,'','order_config','shop_allow_guest','1',0,11,'lang::admin.shop_allow_guest'),(74,'','order_config','product_preorder','1',0,18,'lang::admin.product_preorder'),(75,'','order_config','product_buy_out_of_stock','1',0,20,'lang::admin.product_buy_out_of_stock'),(76,'','email_action','email_action_mode','1',0,0,'lang::email.email_action.email_action_mode'),(77,'','email_action','email_action_queue','0',0,1,'lang::email.email_action.email_action_queue'),(78,'','email_action','order_success_to_admin','0',0,1,'lang::email.email_action.order_success_to_admin'),(79,'','email_action','order_success_to_customer','0',0,2,'lang::email.email_action.order_success_to_cutomer'),(80,'','email_action','welcome_customer','0',0,4,'lang::email.email_action.welcome_customer'),(81,'','email_action','contact_to_admin','1',0,6,'lang::email.email_action.contact_to_admin'),(82,'','smtp_config','smtp_host','',0,1,'lang::email.smtp_host'),(83,'','smtp_config','smtp_user','',0,2,'lang::email.smtp_user'),(84,'','smtp_config','smtp_password','',0,3,'lang::email.smtp_password'),(85,'','smtp_config','smtp_security','',0,4,'lang::email.smtp_security'),(86,'','smtp_config','smtp_port','',0,5,'lang::email.smtp_port'),(87,'','url_config','SUFFIX_URL','.html',0,0,'lang::url.SUFFIX_URL'),(88,'','url_config','PREFIX_SHOP','shop',0,0,'lang::env.PREFIX_SHOP'),(89,'','url_config','PREFIX_BRAND','brand',0,0,'lang::env.PREFIX_BRAND'),(90,'','url_config','PREFIX_SUPPLIER','supplier',0,0,'lang::env.PREFIX_SUPPLIER'),(91,'','url_config','PREFIX_CATEGORY','category',0,0,'lang::env.PREFIX_CATEGORY'),(92,'','url_config','PREFIX_PRODUCT','product',0,0,'lang::env.PREFIX_PRODUCT'),(93,'','url_config','PREFIX_SEARCH','search',0,0,'lang::env.PREFIX_SEARCH'),(94,'','url_config','PREFIX_CONTACT','contact',0,0,'lang::env.PREFIX_CONTACT'),(95,'','url_config','PREFIX_NEWS','news',0,0,'lang::env.PREFIX_NEWS'),(96,'','url_config','PREFIX_MEMBER','member',0,0,'lang::env.PREFIX_MEMBER'),(97,'','url_config','PREFIX_MEMBER_ORDER_LIST','order-list',0,0,'lang::env.PREFIX_MEMBER_ORDER_LIST'),(98,'','url_config','PREFIX_MEMBER_CHANGE_PWD','change-password',0,0,'lang::env.PREFIX_MEMBER_CHANGE_PWD'),(99,'','url_config','PREFIX_MEMBER_CHANGE_INFO','change-info',0,0,'lang::env.PREFIX_MEMBER_CHANGE_INFO'),(100,'','url_config','PREFIX_CMS_CATEGORY','cms-category',0,0,'lang::env.PREFIX_CMS_CATEGORY'),(101,'','url_config','PREFIX_CMS_ENTRY','entry',0,0,'lang::env.PREFIX_CMS_ENTRY'),(102,'','url_config','PREFIX_CART_WISHLIST','wishlst',0,0,'lang::env.PREFIX_CART_WISHLIST'),(103,'','url_config','PREFIX_CART_COMPARE','compare',0,0,'lang::env.PREFIX_CART_COMPARE'),(104,'','url_config','PREFIX_CART_DEFAULT','cart',0,0,'lang::env.PREFIX_CART_DEFAULT'),(105,'','url_config','PREFIX_CART_CHECKOUT','checkout',0,0,'lang::env.PREFIX_CART_CHECKOUT'),(106,'','url_config','PREFIX_ORDER_SUCCESS','order-success',0,0,'lang::env.PREFIX_ORDER_SUCCESS'),(107,'','api_config','api_connection_required','0',0,1,'lang::api_connection.api_connection_required');
/*!40000 ALTER TABLE `sc_admin_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_admin_log`
--

DROP TABLE IF EXISTS `sc_admin_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_admin_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `input` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sc_admin_log_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_admin_log`
--

LOCK TABLES `sc_admin_log` WRITE;
/*!40000 ALTER TABLE `sc_admin_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `sc_admin_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_admin_menu`
--

DROP TABLE IF EXISTS `sc_admin_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT 0,
  `key` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_admin_menu_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_admin_menu`
--

LOCK TABLES `sc_admin_menu` WRITE;
/*!40000 ALTER TABLE `sc_admin_menu` DISABLE KEYS */;
INSERT INTO `sc_admin_menu` VALUES (1,6,1,'lang::admin.menu_titles.order_manager','fas fa-cart-arrow-down','',0,'ORDER_MANAGER',NULL,NULL),(2,6,2,'lang::admin.menu_titles.catalog_mamager','fas fa-folder-open','',0,'CATALOG_MANAGER',NULL,NULL),(3,6,3,'lang::admin.menu_titles.customer_manager','fas fa-users','',0,'CUSTOMER_MANAGER',NULL,NULL),(4,8,201,'lang::admin.menu_titles.template_layout','fas fa-object-ungroup','',0,'TEMPLATE',NULL,NULL),(5,9,2,'lang::admin.menu_titles.config_system','fas fa-cogs','',0,'CONFIG_SYSTEM',NULL,NULL),(6,0,10,'lang::admin.ADMIN_SHOP','fas fa-cog','',0,'ADMIN_SHOP',NULL,NULL),(7,0,100,'lang::admin.ADMIN_CONTENT','fas fa-cog','',0,'ADMIN_CONTENT',NULL,NULL),(8,0,200,'lang::admin.ADMIN_EXTENSION','fas fa-cog','',0,'ADMIN_EXTENSION',NULL,NULL),(9,0,300,'lang::admin.ADMIN_SYSTEM','fas fa-cog','',0,'ADMIN_SYSTEM',NULL,NULL),(10,7,102,'lang::page.admin.title','fas fa-clone','admin::page',0,NULL,NULL,NULL),(11,1,6,'lang::shipping_status.admin.title','fas fa-truck','admin::shipping_status',0,NULL,NULL,NULL),(12,1,3,'lang::order.admin.title','fas fa-shopping-cart','admin::order',0,NULL,NULL,NULL),(13,1,4,'lang::order_status.admin.title','fas fa-asterisk','admin::order_status',0,NULL,NULL,NULL),(14,1,5,'lang::payment_status.admin.title','fas fa-recycle','admin::payment_status',0,NULL,NULL,NULL),(15,2,0,'lang::product.admin.title','far fa-file-image','admin::product',0,NULL,NULL,NULL),(16,2,0,'lang::category.admin.title','far fa-folder-open','admin::category',0,NULL,NULL,NULL),(17,2,0,'lang::supplier.admin.title','fas fa-user-secret','admin::supplier',0,NULL,NULL,NULL),(18,2,0,'lang::brand.admin.title','fas fa-university','admin::brand',0,NULL,NULL,NULL),(19,2,0,'lang::attribute_group.admin.title','fas fa-bars','admin::attribute_group',0,NULL,NULL,NULL),(20,3,0,'lang::customer.admin.title','fas fa-user','admin::customer',0,NULL,NULL,NULL),(21,3,0,'lang::subscribe.admin.title','fas fa-user-circle','admin::subscribe',0,NULL,NULL,NULL),(22,4,0,'lang::block_content.admin.title','far fa-newspaper','admin::block_content',0,NULL,NULL,NULL),(23,4,0,'lang::admin.menu_titles.block_link','fab fa-chrome','admin::link',0,NULL,NULL,NULL),(24,4,0,'lang::admin.menu_titles.template_manager','fas fa-columns','admin::template',0,NULL,NULL,NULL),(26,65,1,'lang::store.admin.title','fas fa-h-square','admin::store',0,NULL,NULL,NULL),(27,9,4,'lang::admin.menu_titles.email_setting','fas fa-envelope','',0,NULL,NULL,NULL),(28,27,0,'lang::email.admin.title','fas fa-cog','admin::email',0,NULL,NULL,NULL),(29,27,0,'lang::email_template.admin.title','fas fa-bars','admin::email_template',0,NULL,NULL,NULL),(30,9,5,'lang::admin.menu_titles.localisation','fab fa-shirtsinbulk','',0,NULL,NULL,NULL),(31,30,0,'lang::language.admin.title','fas fa-language','admin::language',0,NULL,NULL,NULL),(32,30,0,'lang::currency.admin.title','far fa-money-bill-alt','admin::currency',0,NULL,NULL,NULL),(33,7,101,'lang::banner.admin.title','fas fa-image','admin::banner',0,NULL,NULL,NULL),(34,5,5,'lang::backup.admin.title','fas fa-save','admin::backup',0,NULL,NULL,NULL),(35,8,202,'lang::admin.menu_titles.plugins','fas fa-puzzle-piece','',0,'PLUGIN',NULL,NULL),(37,6,4,'lang::admin.menu_titles.report_manager','fas fa-chart-pie','',0,'REPORT_MANAGER',NULL,NULL),(38,9,1,'lang::admin.menu_titles.admin','fas fa-users-cog','',0,'ADMIN',NULL,NULL),(39,35,0,'plugin.Payment','far fa-money-bill-alt','admin::plugin/payment',0,NULL,NULL,NULL),(40,35,0,'plugin.Shipping','fas fa-ambulance','admin::plugin/shipping',0,NULL,NULL,NULL),(41,35,0,'plugin.Total','fas fa-cog','admin::plugin/total',0,NULL,NULL,NULL),(42,35,100,'plugin.Other','far fa-circle','admin::plugin/other',0,NULL,NULL,NULL),(43,35,0,'plugin.Cms','fab fa-modx','admin::plugin/cms',0,NULL,NULL,NULL),(46,38,0,'lang::admin.menu_titles.users','fas fa-users','admin::user',0,NULL,NULL,NULL),(47,38,0,'lang::admin.menu_titles.roles','fas fa-user','admin::role',0,NULL,NULL,NULL),(48,38,0,'lang::admin.menu_titles.permission','fas fa-ban','admin::permission',0,NULL,NULL,NULL),(49,38,0,'lang::admin.menu_titles.menu','fas fa-bars','admin::menu',0,NULL,NULL,NULL),(50,38,0,'lang::admin.menu_titles.operation_log','fas fa-history','admin::log',0,NULL,NULL,NULL),(52,7,103,'lang::news.admin.title','far fa-file-powerpoint','admin::news',0,NULL,NULL,NULL),(53,5,3,'lang::config.title','fas fa-tools','admin::config',0,NULL,NULL,NULL),(54,37,0,'lang::admin.menu_titles.report_product','fas fa-bars','admin::report/product',0,NULL,NULL,NULL),(55,2,100,'lang::product.config_manager.title','fas fa fa-cog','admin::product_config',0,NULL,NULL,NULL),(56,3,100,'lang::customer.config_manager.title','fas fa fa-cog','admin::customer_config',0,NULL,NULL,NULL),(57,5,2,'lang::link.config_manager.title','fab fa-gg','admin::url_config',0,NULL,NULL,NULL),(58,5,5,'lang::admin.menu_titles.cache_manager','fab fa-tripadvisor','admin::cache_config',0,NULL,NULL,NULL),(59,9,7,'lang::admin.menu_titles.api_manager','fas fa-plug','',0,'API_MANAGER',NULL,NULL),(60,65,3,'lang::store_maintain.config_manager.title','fas fa-wrench','admin::store_maintain',0,NULL,NULL,NULL),(61,2,4,'lang::tax.admin.admin_title','far fa-calendar-minus','admin::tax',0,NULL,NULL,NULL),(62,2,5,'lang::weight.admin.title','fas fa-balance-scale','admin::weight_unit',0,NULL,NULL,NULL),(63,2,6,'lang::length.admin.title','fas fa-minus','admin::length_unit',0,NULL,NULL,NULL),(64,1,100,'lang::order.admin.config_title','fas fa fa-cog','admin::order_config',0,NULL,NULL,NULL),(65,9,3,'lang::admin.menu_titles.store_manager','fas fa-store-alt','',0,'STORE_MANAGER',NULL,NULL),(66,59,1,'lang::admin.menu_titles.api_config','fas fa fa-cog','admin::api_connection',0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `sc_admin_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_admin_permission`
--

DROP TABLE IF EXISTS `sc_admin_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_admin_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_uri` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_admin_permission_name_unique` (`name`),
  UNIQUE KEY `sc_admin_permission_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_admin_permission`
--

LOCK TABLES `sc_admin_permission` WRITE;
/*!40000 ALTER TABLE `sc_admin_permission` DISABLE KEYS */;
INSERT INTO `sc_admin_permission` VALUES (1,'Admin manager','admin.manager','GET::sc_admin/user,GET::sc_admin/role,GET::sc_admin/permission,ANY::sc_admin/log/*,ANY::sc_admin/menu/*','2020-09-07 15:37:56',NULL),(2,'Dashboard','dashboard','GET::sc_admin','2020-09-07 15:37:56',NULL),(3,'Auth manager','auth.full','ANY::sc_admin/auth/*','2020-09-07 15:37:56',NULL),(4,'Setting manager','config.full','ANY::sc_admin/store/*,ANY::sc_admin/config/*,ANY::sc_admin/url_config/*,ANY::sc_admin/product_config/*,ANY::sc_admin/order_config/*,ANY::sc_admin/customer_config/*,ANY::sc_admin/cache_config/*,ANY::sc_admin/email/*,ANY::sc_admin/email_template/*,ANY::sc_admin/language/*,ANY::sc_admin/currency/*,ANY::sc_admin/backup/*,ANY::sc_admin/api_connection/*,ANY::sc_admin/maintain/*,ANY::sc_admin/tax/*','2020-09-07 15:37:56',NULL),(5,'Upload management','upload.full','ANY::sc_admin/uploads/*','2020-09-07 15:37:56',NULL),(6,'Plugin manager','plugin.full','ANY::sc_admin/plugin/*','2020-09-07 15:37:56',NULL),(8,'CMS manager','cms.full','ANY::sc_admin/page/*,ANY::sc_admin/banner/*,ANY::sc_admin/cms_category/*,ANY::sc_admin/cms_content/*,ANY::sc_admin/news/*','2020-09-07 15:37:56',NULL),(11,'Discount manager','discount.full','ANY::sc_admin/shop_discount/*','2020-09-07 15:37:56',NULL),(14,'Shipping status','shipping_status.full','ANY::sc_admin/shipping_status/*','2020-09-07 15:37:56',NULL),(15,'Payment  status','payment_status.full','ANY::sc_admin/payment_status/*','2020-09-07 15:37:56',NULL),(17,'Customer manager','customer.full','ANY::sc_admin/customer/*,ANY::sc_admin/subscribe/*','2020-09-07 15:37:56',NULL),(18,'Order status','order_status.full','ANY::sc_admin/order_status/*','2020-09-07 15:37:56',NULL),(19,'Product manager','product.full','ANY::sc_admin/category/*,ANY::sc_admin/supplier/*,ANY::sc_admin/brand/*,ANY::sc_admin/attribute_group/*,ANY::sc_admin/product/,ANY::sc_admin/weight_unit/*,ANY::sc_admin/length_unit/*','2020-09-07 15:37:56',NULL),(20,'Order Manager','order.full','ANY::sc_admin/order/*','2020-09-07 15:37:56',NULL),(21,'Report manager','report.full','ANY::sc_admin/report/*','2020-09-07 15:37:56',NULL),(22,'Template manager','template.full','ANY::sc_admin/block_content/*,ANY::sc_admin/link/*,ANY::sc_admin/template/*','2020-09-07 15:37:56',NULL);
/*!40000 ALTER TABLE `sc_admin_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_admin_role`
--

DROP TABLE IF EXISTS `sc_admin_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_admin_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_admin_role_name_unique` (`name`),
  UNIQUE KEY `sc_admin_role_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_admin_role`
--

LOCK TABLES `sc_admin_role` WRITE;
/*!40000 ALTER TABLE `sc_admin_role` DISABLE KEYS */;
INSERT INTO `sc_admin_role` VALUES (1,'Administrator','administrator','2020-09-07 15:37:56',NULL),(2,'Group only View','view.all','2020-09-07 15:37:56',NULL),(3,'Manager','manager','2020-09-07 15:37:56',NULL),(4,'Cms manager','cms','2020-09-07 15:37:56',NULL),(5,'Accountant','accountant','2020-09-07 15:37:56',NULL),(6,'Marketing','maketing','2020-09-07 15:37:56',NULL);
/*!40000 ALTER TABLE `sc_admin_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_admin_role_permission`
--

DROP TABLE IF EXISTS `sc_admin_role_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_admin_role_permission` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `sc_admin_role_permission_role_id_permission_id_index` (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_admin_role_permission`
--

LOCK TABLES `sc_admin_role_permission` WRITE;
/*!40000 ALTER TABLE `sc_admin_role_permission` DISABLE KEYS */;
INSERT INTO `sc_admin_role_permission` VALUES (3,1,'2020-09-07 15:37:56',NULL),(3,2,'2020-09-07 15:37:56',NULL),(3,3,'2020-09-07 15:37:56',NULL),(3,4,'2020-09-07 15:37:56',NULL),(3,5,'2020-09-07 15:37:56',NULL),(3,8,'2020-09-07 15:37:56',NULL),(3,11,'2020-09-07 15:37:56',NULL),(3,14,'2020-09-07 15:37:56',NULL),(3,15,'2020-09-07 15:37:56',NULL),(3,17,'2020-09-07 15:37:56',NULL),(3,18,'2020-09-07 15:37:56',NULL),(3,19,'2020-09-07 15:37:56',NULL),(3,20,'2020-09-07 15:37:56',NULL),(3,21,'2020-09-07 15:37:56',NULL),(3,22,'2020-09-07 15:37:56',NULL),(4,3,'2020-09-07 15:37:56',NULL),(4,5,'2020-09-07 15:37:56',NULL),(4,8,'2020-09-07 15:37:56',NULL),(5,2,'2020-09-07 15:37:56',NULL),(5,3,'2020-09-07 15:37:56',NULL),(5,20,'2020-09-07 15:37:56',NULL),(5,21,'2020-09-07 15:37:56',NULL),(6,2,'2020-09-07 15:37:56',NULL),(6,3,'2020-09-07 15:37:56',NULL),(6,5,'2020-09-07 15:37:56',NULL),(6,8,'2020-09-07 15:37:56',NULL),(6,11,'2020-09-07 15:37:56',NULL),(6,14,'2020-09-07 15:37:56',NULL),(6,15,'2020-09-07 15:37:56',NULL),(6,17,'2020-09-07 15:37:56',NULL),(6,18,'2020-09-07 15:37:56',NULL),(6,19,'2020-09-07 15:37:56',NULL),(6,20,'2020-09-07 15:37:56',NULL),(6,21,'2020-09-07 15:37:56',NULL);
/*!40000 ALTER TABLE `sc_admin_role_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_admin_role_user`
--

DROP TABLE IF EXISTS `sc_admin_role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_admin_role_user` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `sc_admin_role_user_role_id_user_id_index` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_admin_role_user`
--

LOCK TABLES `sc_admin_role_user` WRITE;
/*!40000 ALTER TABLE `sc_admin_role_user` DISABLE KEYS */;
INSERT INTO `sc_admin_role_user` VALUES (1,1,NULL,NULL);
/*!40000 ALTER TABLE `sc_admin_role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_admin_store`
--

DROP TABLE IF EXISTS `sc_admin_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_admin_store` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `long_phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_active` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `office` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domain` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timezone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0:Lock, 1: unlock',
  `active` int(11) NOT NULL DEFAULT 1 COMMENT '0:Maintain, 1: Active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_admin_store_domain_unique` (`domain`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_admin_store`
--

LOCK TABLES `sc_admin_store` WRITE;
/*!40000 ALTER TABLE `sc_admin_store` DISABLE KEYS */;
INSERT INTO `sc_admin_store` VALUES (1,'data/logo/scart-mid.png','0123456789','Support: 0987654321','admin-demo@s-cart.org','','123st - abc - xyz',NULL,NULL,'s-cart-3x','s-cart.local/','en','Asia/Ho_Chi_Minh','USD',1,1);
/*!40000 ALTER TABLE `sc_admin_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_admin_store_description`
--

DROP TABLE IF EXISTS `sc_admin_store_description`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_admin_store_description` (
  `store_id` int(11) NOT NULL,
  `lang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maintain_content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`store_id`,`lang`),
  KEY `sc_admin_store_description_lang_index` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_admin_store_description`
--

LOCK TABLES `sc_admin_store_description` WRITE;
/*!40000 ALTER TABLE `sc_admin_store_description` DISABLE KEYS */;
INSERT INTO `sc_admin_store_description` VALUES (1,'en','Demo SCart : Free Laravel eCommerce','Free website shopping cart for business','','<center><img src=\"/images/maintenance.png\" />\r\n    <h3><span style=\"color:#e74c3c;\"><strong>Sorry! We are currently doing site maintenance!</strong></span></h3>\r\n    </center>'),(1,'vi','Demo SCart: Mã nguồn website thương mại điện tử miễn phí','Laravel shopping cart for business','','<center><img src=\"/images/maintenance.png\" />\r\n    <h3><span style=\"color:#e74c3c;\"><strong>Xin lỗi! Hiện tại website đang bảo trì!</strong></span></h3>\r\n    </center>');
/*!40000 ALTER TABLE `sc_admin_store_description` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_admin_user`
--

DROP TABLE IF EXISTS `sc_admin_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_admin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_admin_user_username_unique` (`username`),
  UNIQUE KEY `sc_admin_user_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_admin_user`
--

LOCK TABLES `sc_admin_user` WRITE;
/*!40000 ALTER TABLE `sc_admin_user` DISABLE KEYS */;
INSERT INTO `sc_admin_user` VALUES (1,'admin','$2y$10$ZkdyNRIpnMKfOUnAk9yPR.JI4rrHlcCnICpbbzZthQB9BxOCK9d16','Administrator','admin-demo@s-cart.org','/admin/avatar/user.jpg',NULL,NULL,'2020-09-07 15:37:56',NULL);
/*!40000 ALTER TABLE `sc_admin_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_admin_user_permission`
--

DROP TABLE IF EXISTS `sc_admin_user_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_admin_user_permission` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `sc_admin_user_permission_user_id_permission_id_index` (`user_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_admin_user_permission`
--

LOCK TABLES `sc_admin_user_permission` WRITE;
/*!40000 ALTER TABLE `sc_admin_user_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `sc_admin_user_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_api_connection`
--

DROP TABLE IF EXISTS `sc_api_connection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_api_connection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apiconnection` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apikey` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire` date DEFAULT NULL,
  `last_active` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_api_connection_apiconnection_unique` (`apiconnection`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_api_connection`
--

LOCK TABLES `sc_api_connection` WRITE;
/*!40000 ALTER TABLE `sc_api_connection` DISABLE KEYS */;
INSERT INTO `sc_api_connection` VALUES (1,'Demo api connection','appmobile','5f5653d54176d',NULL,NULL,1);
/*!40000 ALTER TABLE `sc_api_connection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_attribute_group`
--

DROP TABLE IF EXISTS `sc_shop_attribute_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_attribute_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'radio,select,checkbox',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_attribute_group`
--

LOCK TABLES `sc_shop_attribute_group` WRITE;
/*!40000 ALTER TABLE `sc_shop_attribute_group` DISABLE KEYS */;
INSERT INTO `sc_shop_attribute_group` VALUES (1,'Color',1,1,'radio'),(2,'Size',1,2,'select');
/*!40000 ALTER TABLE `sc_shop_attribute_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_banner`
--

DROP TABLE IF EXISTS `sc_shop_banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_banner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `html` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  `click` int(11) NOT NULL DEFAULT 0,
  `type` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_banner`
--

LOCK TABLES `sc_shop_banner` WRITE;
/*!40000 ALTER TABLE `sc_shop_banner` DISABLE KEYS */;
INSERT INTO `sc_shop_banner` VALUES (1,'/data/banner/Main-banner-1-1903x600.jpg',NULL,'_self','',1,0,0,0,NULL,NULL),(2,'/data/banner/Main-banner-3-1903x600.jpg',NULL,'_self','',1,0,0,0,NULL,NULL),(3,'/data/banner/bgbr.jpg',NULL,'_self','',1,0,0,2,NULL,NULL);
/*!40000 ALTER TABLE `sc_shop_banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_banner_store`
--

DROP TABLE IF EXISTS `sc_shop_banner_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_banner_store` (
  `banner_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`banner_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_banner_store`
--

LOCK TABLES `sc_shop_banner_store` WRITE;
/*!40000 ALTER TABLE `sc_shop_banner_store` DISABLE KEYS */;
INSERT INTO `sc_shop_banner_store` VALUES (1,0),(2,0),(3,0);
/*!40000 ALTER TABLE `sc_shop_banner_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_block_content`
--

DROP TABLE IF EXISTS `sc_shop_block_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_block_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_block_content`
--

LOCK TABLES `sc_shop_block_content` WRITE;
/*!40000 ALTER TABLE `sc_shop_block_content` DISABLE KEYS */;
INSERT INTO `sc_shop_block_content` VALUES (1,'Facebook code','top','*','html','<div id=\"fb-root\"></div>\r\n    <script>(function(d, s, id) {\r\n    var js, fjs = d.getElementsByTagName(s)[0];\r\n    if (d.getElementById(id)) return;\r\n    js = d.createElement(s); js.id = id;\r\n    js.src = \'//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=934208239994473\';\r\n    fjs.parentNode.insertBefore(js, fjs);\r\n    }(document, \'script\', \'facebook-jssdk\'));\r\n    </script>',1,0),(2,'Google Analytics','header','*','html','<!-- Global site tag (gtag.js) - Google Analytics -->\r\n    <script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-128658138-1\"></script>\r\n    <script>\r\n    window.dataLayer = window.dataLayer || [];\r\n    function gtag(){dataLayer.push(arguments);}\r\n    gtag(\'js\', new Date());\r\n    gtag(\'config\', \'UA-128658138-1\');\r\n    </script>',1,0),(3,'Product special','left','*','view','product_special',1,1),(4,'Brands','left','*','view','brands_left',1,3),(5,'Banner home','banner_top','shop_home','view','banner_image',1,0),(6,'Categories','left','*','view','categories',1,4),(7,'Product last view','left','*','view','product_lastview',1,0);
/*!40000 ALTER TABLE `sc_shop_block_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_brand`
--

DROP TABLE IF EXISTS `sc_shop_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_brand` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_shop_brand_alias_unique` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_brand`
--

LOCK TABLES `sc_shop_brand` WRITE;
/*!40000 ALTER TABLE `sc_shop_brand` DISABLE KEYS */;
INSERT INTO `sc_shop_brand` VALUES (1,'Husq','husq','/data/brand/01-181x52.png','',1,0),(2,'Ideal','ideal','/data/brand/02-181x52.png','',1,0),(3,'Apex','apex','/data/brand/03-181x52.png','',1,0),(4,'CST','cst','/data/brand/04-181x52.png','',1,0),(5,'Klein','klein','/data/brand/05-181x52.png','',1,0),(6,'Metabo','metabo','/data/brand/06-181x52.png','',1,0),(7,'Avatar','avatar','/data/brand/07-181x52.png','',1,0),(8,'Brand KA','brand-ka','/data/brand/08-181x52.png','',1,0);
/*!40000 ALTER TABLE `sc_shop_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_category`
--

DROP TABLE IF EXISTS `sc_shop_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `top` int(11) DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_shop_category_alias_unique` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_category`
--

LOCK TABLES `sc_shop_category` WRITE;
/*!40000 ALTER TABLE `sc_shop_category` DISABLE KEYS */;
INSERT INTO `sc_shop_category` VALUES (1,'/data/category/img-40.jpg','electronics',0,1,1,0),(2,'/data/category/img-44.jpg','clothing-wears',0,1,1,0),(3,'/data/category/img-42.jpg','mobile',1,1,1,0),(4,'/data/category/img-18.jpg','accessaries-extras',0,1,1,0),(5,'/data/category/img-14.jpg','computers',1,1,1,0),(6,'/data/category/img-14.jpg','tablets',1,0,1,0),(7,'/data/category/img-40.jpg','appliances',1,0,1,0),(8,'/data/category/img-14.jpg','men-clothing',2,0,1,0),(9,'/data/category/img-18.jpg','women-clothing',2,1,1,0),(10,'/data/category/img-14.jpg','kid-wear',2,0,1,0),(11,'/data/category/img-40.jpg','mobile-accessaries',4,0,1,0),(12,'/data/category/img-42.jpg','women-accessaries',4,0,1,3),(13,'/data/category/img-40.jpg','men-accessaries',4,0,1,3);
/*!40000 ALTER TABLE `sc_shop_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_category_description`
--

DROP TABLE IF EXISTS `sc_shop_category_description`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_category_description` (
  `category_id` int(11) NOT NULL,
  `lang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`category_id`,`lang`),
  KEY `sc_shop_category_description_lang_index` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_category_description`
--

LOCK TABLES `sc_shop_category_description` WRITE;
/*!40000 ALTER TABLE `sc_shop_category_description` DISABLE KEYS */;
INSERT INTO `sc_shop_category_description` VALUES (1,'en','Electronics','',''),(1,'vi','Thiết bị điện tử','',''),(2,'en','Clothing & Wears','',''),(2,'vi','Quần áo','',''),(3,'en','Mobile','',''),(3,'vi','Điện thoại','',''),(4,'en','Accessaries & Extras','',''),(4,'vi','Phụ kiện ','',''),(5,'en','Computers','',''),(5,'vi','Máy tính','',''),(6,'en','Tablets','',''),(6,'vi','Máy tính bảng','',''),(7,'en','Appliances','',''),(7,'vi','Thiết bị','',''),(8,'en','Men\'s Clothing','',''),(8,'vi','Quần áo nam','',''),(9,'en','Women\'s Clothing','',''),(9,'vi','Quần áo nữ','',''),(10,'en','Kid\'s Wear','',''),(10,'vi','Đồ trẻ em','',''),(11,'en','Mobile Accessaries','',''),(11,'vi','Phụ kiện điện thoại','',''),(12,'en','Women\'s Accessaries','',''),(12,'vi','Phụ kiện nữ','',''),(13,'en','Men\'s Accessaries','',''),(13,'vi','Phụ kiện nam','','');
/*!40000 ALTER TABLE `sc_shop_category_description` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_category_store`
--

DROP TABLE IF EXISTS `sc_shop_category_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_category_store` (
  `category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_category_store`
--

LOCK TABLES `sc_shop_category_store` WRITE;
/*!40000 ALTER TABLE `sc_shop_category_store` DISABLE KEYS */;
INSERT INTO `sc_shop_category_store` VALUES (1,0),(2,0),(3,0),(4,0),(5,0),(6,0),(7,0),(8,0),(9,0),(10,0),(11,0),(12,0),(13,0);
/*!40000 ALTER TABLE `sc_shop_category_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_country`
--

DROP TABLE IF EXISTS `sc_shop_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_country` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_shop_country_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_country`
--

LOCK TABLES `sc_shop_country` WRITE;
/*!40000 ALTER TABLE `sc_shop_country` DISABLE KEYS */;
INSERT INTO `sc_shop_country` VALUES (1,'AL','Albania'),(2,'DZ','Algeria'),(3,'DS','American Samoa'),(4,'AD','Andorra'),(5,'AO','Angola'),(6,'AI','Anguilla'),(7,'AQ','Antarctica'),(8,'AG','Antigua and Barbuda'),(9,'AR','Argentina'),(10,'AM','Armenia'),(11,'AW','Aruba'),(12,'AU','Australia'),(13,'AT','Austria'),(14,'AZ','Azerbaijan'),(15,'BS','Bahamas'),(16,'BH','Bahrain'),(17,'BD','Bangladesh'),(18,'BB','Barbados'),(19,'BY','Belarus'),(20,'BE','Belgium'),(21,'BZ','Belize'),(22,'BJ','Benin'),(23,'BM','Bermuda'),(24,'BT','Bhutan'),(25,'BO','Bolivia'),(26,'BA','Bosnia and Herzegovina'),(27,'BW','Botswana'),(28,'BV','Bouvet Island'),(29,'BR','Brazil'),(30,'IO','British Indian Ocean Territory'),(31,'BN','Brunei Darussalam'),(32,'BG','Bulgaria'),(33,'BF','Burkina Faso'),(34,'BI','Burundi'),(35,'KH','Cambodia'),(36,'CM','Cameroon'),(37,'CA','Canada'),(38,'CV','Cape Verde'),(39,'KY','Cayman Islands'),(40,'CF','Central African Republic'),(41,'TD','Chad'),(42,'CL','Chile'),(43,'CN','China'),(44,'CX','Christmas Island'),(45,'CC','Cocos (Keeling) Islands'),(46,'CO','Colombia'),(47,'KM','Comoros'),(48,'CG','Congo'),(49,'CK','Cook Islands'),(50,'CR','Costa Rica'),(51,'HR','Croatia (Hrvatska)'),(52,'CU','Cuba'),(53,'CY','Cyprus'),(54,'CZ','Czech Republic'),(55,'DK','Denmark'),(56,'DJ','Djibouti'),(57,'DM','Dominica'),(58,'DO','Dominican Republic'),(59,'TP','East Timor'),(60,'EC','Ecuador'),(61,'EG','Egypt'),(62,'SV','El Salvador'),(63,'GQ','Equatorial Guinea'),(64,'ER','Eritrea'),(65,'EE','Estonia'),(66,'ET','Ethiopia'),(67,'FK','Falkland Islands (Malvinas)'),(68,'FO','Faroe Islands'),(69,'FJ','Fiji'),(70,'FI','Finland'),(71,'FR','France'),(72,'FX','France, Metropolitan'),(73,'GF','French Guiana'),(74,'PF','French Polynesia'),(75,'TF','French Southern Territories'),(76,'GA','Gabon'),(77,'GM','Gambia'),(78,'GE','Georgia'),(79,'DE','Germany'),(80,'GH','Ghana'),(81,'GI','Gibraltar'),(82,'GK','Guernsey'),(83,'GR','Greece'),(84,'GL','Greenland'),(85,'GD','Grenada'),(86,'GP','Guadeloupe'),(87,'GU','Guam'),(88,'GT','Guatemala'),(89,'GN','Guinea'),(90,'GW','Guinea-Bissau'),(91,'GY','Guyana'),(92,'HT','Haiti'),(93,'HM','Heard and Mc Donald Islands'),(94,'HN','Honduras'),(95,'HK','Hong Kong'),(96,'HU','Hungary'),(97,'IS','Iceland'),(98,'IN','India'),(99,'IM','Isle of Man'),(100,'ID','Indonesia'),(101,'IR','Iran (Islamic Republic of)'),(102,'IQ','Iraq'),(103,'IE','Ireland'),(104,'IL','Israel'),(105,'IT','Italy'),(106,'CI','Ivory Coast'),(107,'JE','Jersey'),(108,'JM','Jamaica'),(109,'JP','Japan'),(110,'JO','Jordan'),(111,'KZ','Kazakhstan'),(112,'KE','Kenya'),(113,'KI','Kiribati'),(114,'KP','Korea,Democratic People\'s Republic of'),(115,'KR','Korea, Republic of'),(116,'XK','Kosovo'),(117,'KW','Kuwait'),(118,'KG','Kyrgyzstan'),(119,'LA','Lao People\'s Democratic Republic'),(120,'LV','Latvia'),(121,'LB','Lebanon'),(122,'LS','Lesotho'),(123,'LR','Liberia'),(124,'LY','Libyan Arab Jamahiriya'),(125,'LI','Liechtenstein'),(126,'LT','Lithuania'),(127,'LU','Luxembourg'),(128,'MO','Macau'),(129,'MK','Macedonia'),(130,'MG','Madagascar'),(131,'MW','Malawi'),(132,'MY','Malaysia'),(133,'MV','Maldives'),(134,'ML','Mali'),(135,'MT','Malta'),(136,'MH','Marshall Islands'),(137,'MQ','Martinique'),(138,'MR','Mauritania'),(139,'MU','Mauritius'),(140,'TY','Mayotte'),(141,'MX','Mexico'),(142,'FM','Micronesia, Federated States of'),(143,'MD','Moldova, Republic of'),(144,'MC','Monaco'),(145,'MN','Mongolia'),(146,'ME','Montenegro'),(147,'MS','Montserrat'),(148,'MA','Morocco'),(149,'MZ','Mozambique'),(150,'MM','Myanmar'),(151,'NA','Namibia'),(152,'NR','Nauru'),(153,'NP','Nepal'),(154,'NL','Netherlands'),(155,'AN','Netherlands Antilles'),(156,'NC','New Caledonia'),(157,'NZ','New Zealand'),(158,'NI','Nicaragua'),(159,'NE','Niger'),(160,'NG','Nigeria'),(161,'NU','Niue'),(162,'NF','Norfolk Island'),(163,'MP','Northern Mariana Islands'),(164,'NO','Norway'),(165,'OM','Oman'),(166,'PK','Pakistan'),(167,'PW','Palau'),(168,'PS','Palestine'),(169,'PA','Panama'),(170,'PG','Papua New Guinea'),(171,'PY','Paraguay'),(172,'PE','Peru'),(173,'PH','Philippines'),(174,'PN','Pitcairn'),(175,'PL','Poland'),(176,'PT','Portugal'),(177,'PR','Puerto Rico'),(178,'QA','Qatar'),(179,'RE','Reunion'),(180,'RO','Romania'),(181,'RU','Russian Federation'),(182,'RW','Rwanda'),(183,'KN','Saint Kitts and Nevis'),(184,'LC','Saint Lucia'),(185,'VC','Saint Vincent and the Grenadines'),(186,'WS','Samoa'),(187,'SM','San Marino'),(188,'ST','Sao Tome and Principe'),(189,'SA','Saudi Arabia'),(190,'SN','Senegal'),(191,'RS','Serbia'),(192,'SC','Seychelles'),(193,'SL','Sierra Leone'),(194,'SG','Singapore'),(195,'SK','Slovakia'),(196,'SI','Slovenia'),(197,'SB','Solomon Islands'),(198,'SO','Somalia'),(199,'ZA','South Africa'),(200,'GS','South Georgia South Sandwich Islands'),(201,'SS','South Sudan'),(202,'ES','Spain'),(203,'LK','Sri Lanka'),(204,'SH','St. Helena'),(205,'PM','St. Pierre and Miquelon'),(206,'SD','Sudan'),(207,'SR','Suriname'),(208,'SJ','Svalbard and Jan Mayen Islands'),(209,'SZ','Swaziland'),(210,'SE','Sweden'),(211,'CH','Switzerland'),(212,'SY','Syrian Arab Republic'),(213,'TW','Taiwan'),(214,'TJ','Tajikistan'),(215,'TZ','Tanzania, United Republic of'),(216,'TH','Thailand'),(217,'TG','Togo'),(218,'TK','Tokelau'),(219,'TO','Tonga'),(220,'TT','Trinidad and Tobago'),(221,'TN','Tunisia'),(222,'TR','Turkey'),(223,'TM','Turkmenistan'),(224,'TC','Turks and Caicos Islands'),(225,'TV','Tuvalu'),(226,'UG','Uganda'),(227,'UA','Ukraine'),(228,'AE','United Arab Emirates'),(229,'GB','United Kingdom'),(230,'US','United States'),(231,'UM','United States minor outlying islands'),(232,'UY','Uruguay'),(233,'UZ','Uzbekistan'),(234,'VU','Vanuatu'),(235,'VA','Vatican City State'),(236,'VE','Venezuela'),(237,'VN','Vietnam'),(238,'VG','Virgin Islands (British)'),(239,'VI','Virgin Islands (U.S.)'),(240,'WF','Wallis and Futuna Islands'),(241,'EH','Western Sahara'),(242,'YE','Yemen'),(243,'ZR','Zaire'),(244,'ZM','Zambia'),(245,'ZW','Zimbabwe');
/*!40000 ALTER TABLE `sc_shop_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_currency`
--

DROP TABLE IF EXISTS `sc_shop_currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_currency` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` double(8,2) NOT NULL,
  `precision` tinyint(4) NOT NULL DEFAULT 2,
  `symbol_first` tinyint(4) NOT NULL DEFAULT 0,
  `thousands` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ',',
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_shop_currency_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_currency`
--

LOCK TABLES `sc_shop_currency` WRITE;
/*!40000 ALTER TABLE `sc_shop_currency` DISABLE KEYS */;
INSERT INTO `sc_shop_currency` VALUES (1,'USD Dola','USD','$',1.00,0,1,',',1,0),(2,'VietNam Dong','VND','₫',20.00,0,0,',',1,1);
/*!40000 ALTER TABLE `sc_shop_currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_email_template`
--

DROP TABLE IF EXISTS `sc_shop_email_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_email_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_email_template`
--

LOCK TABLES `sc_shop_email_template` WRITE;
/*!40000 ALTER TABLE `sc_shop_email_template` DISABLE KEYS */;
INSERT INTO `sc_shop_email_template` VALUES (1,'Reset password','forgot_password','<h1 style=\"font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left\">{{$title}}</h1>\r\n    <p style=\"font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left\">{{$reason_sendmail}}</p>\r\n                        <table class=\"action\" align=\"center\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:30px auto;padding:0;text-align:center;width:100%\">\r\n                        <tbody><tr>\r\n                            <td align=\"center\" style=\"font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box\">\r\n                            <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box\">\r\n                                <tbody><tr>\r\n                                <td align=\"center\" style=\"font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box\">\r\n                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box\">\r\n                                    <tbody><tr>\r\n                                        <td style=\"font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box\">\r\n                                        <a href=\"{{$reset_link}}\" class=\"button button-primary\" style=\"font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-radius:3px;color:#fff;display:inline-block;text-decoration:none;background-color:#3097d1;border-top:10px solid #3097d1;border-right:18px solid #3097d1;border-bottom:10px solid #3097d1;border-left:18px solid #3097d1\" target=\"_blank\">{{$reset_button}}</a>\r\n                                        </td>\r\n                                    </tr>\r\n                                    </tbody>\r\n                                </table>\r\n                                </td>\r\n                                </tr>\r\n                            </tbody>\r\n                            </table>\r\n                            </td>\r\n                        </tr>\r\n                        </tbody>\r\n                    </table>\r\n                        <p style=\"font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left\">\r\n                        {{$note_sendmail}}\r\n                        </p>\r\n                        <table class=\"subcopy\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-top:1px solid #edeff2;margin-top:25px;padding-top:25px\">\r\n                        <tbody><tr>\r\n                        <td style=\"font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box\">\r\n                            <p style=\"font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;line-height:1.5em;margin-top:0;text-align:left;font-size:12px\">{{$note_access_link}}: <a href=\"{{$reset_link}}\" style=\"font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#3869d4\" target=\"_blank\">{{$reset_link}}</a></p>\r\n                            </td>\r\n                            </tr>\r\n                        </tbody>\r\n                        </table>',1),(2,'Welcome new customer','welcome_customer','<h1 style=\"font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:center\">{{$title}}</h1>\r\n    <p style=\"text-align:center;\">Welcome to my site!</p>',1),(3,'Send form contact to admin','contact_to_admin','<table class=\"inner-body\" align=\"center\" width=\"570\" cellpadding=\"0\" cellspacing=\"0\">\r\n        <tr>\r\n            <td>\r\n                <b>Name</b>: {{$name}}<br>\r\n                <b>Email</b>: {{$email}}<br>\r\n                <b>Phone</b>: {{$phone}}<br>\r\n            </td>\r\n        </tr>\r\n    </table>\r\n    <hr>\r\n    <p style=\"text-align: center;\">Content:<br>\r\n    <table class=\"inner-body\" align=\"center\" width=\"570\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\r\n        <tr>\r\n            <td>{{$content}}</td>\r\n        </tr>\r\n    </table>',1),(4,'New order to admin','order_success_to_admin','<table class=\"inner-body\" align=\"center\" width=\"570\" cellpadding=\"0\" cellspacing=\"0\">\r\n                            <tr>\r\n                                <td>\r\n                                    <b>Order ID</b>: {{$orderID}}<br>\r\n                                    <b>Customer name</b>: {{$toname}}<br>\r\n                                    <b>Email</b>: {{$email}}<br>\r\n                                    <b>Address</b>: {{$address}}<br>\r\n                                    <b>Phone</b>: {{$phone}}<br>\r\n                                    <b>Order note</b>: {{$comment}}\r\n                                </td>\r\n                            </tr>\r\n                        </table>\r\n                        <hr>\r\n                        <p style=\"text-align: center;\">Order detail:<br>\r\n                        ===================================<br></p>\r\n                        <table class=\"inner-body\" align=\"center\" width=\"570\" cellpadding=\"0\" cellspacing=\"0\" border=\"1\">\r\n                            {{$orderDetail}}\r\n                            <tr>\r\n                                <td colspan=\"2\"></td>\r\n                                <td colspan=\"2\" style=\"font-weight: bold;\">Sub total</td>\r\n                                <td colspan=\"2\" align=\"right\">{{$subtotal}}</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td colspan=\"2\"></td>\r\n                                <td colspan=\"2\" style=\"font-weight: bold;\">Shipping fee</td>\r\n                                <td colspan=\"2\" align=\"right\">{{$shipping}}</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td colspan=\"2\"></td>\r\n                                <td colspan=\"2\" style=\"font-weight: bold;\">Discount</td>\r\n                                <td colspan=\"2\" align=\"right\">{{$discount}}</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td colspan=\"2\"></td>\r\n                                <td colspan=\"2\" style=\"font-weight: bold;\">Total</td>\r\n                                <td colspan=\"2\" align=\"right\">{{$total}}</td>\r\n                            </tr>\r\n                        </table>',1),(5,'New order to customr','order_success_to_customer','<table class=\"inner-body\" align=\"center\" width=\"570\" cellpadding=\"0\" cellspacing=\"0\">\r\n                            <tr>\r\n                                <td>\r\n                                    <b>Order ID</b>: {{$orderID}}<br>\r\n                                    <b>Customer name</b>: {{$toname}}<br>\r\n                                    <b>Address</b>: {{$address}}<br>\r\n                                    <b>Phone</b>: {{$phone}}<br>\r\n                                    <b>Order note</b>: {{$comment}}\r\n                                </td>\r\n                            </tr>\r\n                        </table>\r\n                        <hr>\r\n                        <p style=\"text-align: center;\">Order detail:<br>\r\n                        ===================================<br></p>\r\n                        <table class=\"inner-body\" align=\"center\" width=\"570\" cellpadding=\"0\" cellspacing=\"0\" border=\"1\">\r\n                            {{$orderDetail}}\r\n                            <tr>\r\n                                <td colspan=\"2\"></td>\r\n                                <td colspan=\"2\" style=\"font-weight: bold;\">Sub total</td>\r\n                                <td colspan=\"2\" align=\"right\">{{$subtotal}}</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td colspan=\"2\"></td>\r\n                                <td colspan=\"2\" style=\"font-weight: bold;\">Shipping fee</td>\r\n                                <td colspan=\"2\" align=\"right\">{{$shipping}}</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td colspan=\"2\"></td>\r\n                                <td colspan=\"2\" style=\"font-weight: bold;\">Discount</td>\r\n                                <td colspan=\"2\" align=\"right\">{{$discount}}</td>\r\n                            </tr>\r\n                            <tr>\r\n                                <td colspan=\"2\"></td>\r\n                                <td colspan=\"2\" style=\"font-weight: bold;\">Total</td>\r\n                                <td colspan=\"2\" align=\"right\">{{$total}}</td>\r\n                            </tr>\r\n                        </table>',1);
/*!40000 ALTER TABLE `sc_shop_email_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_language`
--

DROP TABLE IF EXISTS `sc_shop_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_language` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `rtl` tinyint(4) DEFAULT 0 COMMENT 'Layout RTL',
  `sort` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_shop_language_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_language`
--

LOCK TABLES `sc_shop_language` WRITE;
/*!40000 ALTER TABLE `sc_shop_language` DISABLE KEYS */;
INSERT INTO `sc_shop_language` VALUES (1,'English','en','/data/language/flag_uk.png',1,0,1),(2,'Tiếng Việt','vi','/data/language/flag_vn.png',1,0,1);
/*!40000 ALTER TABLE `sc_shop_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_layout_page`
--

DROP TABLE IF EXISTS `sc_shop_layout_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_layout_page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_shop_layout_page_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_layout_page`
--

LOCK TABLES `sc_shop_layout_page` WRITE;
/*!40000 ALTER TABLE `sc_shop_layout_page` DISABLE KEYS */;
INSERT INTO `sc_shop_layout_page` VALUES (1,'home','lang::layout.page_position.home'),(2,'shop_home','lang::layout.page_position.shop_home'),(3,'product_list','lang::layout.page_position.product_list'),(4,'product_detail','lang::layout.page_position.product_detail'),(5,'shop_cart','lang::layout.page_position.shop_cart'),(6,'item_list','lang::layout.page_position.item_list'),(7,'item_detail','lang::layout.page_position.item_detail'),(8,'news_list','lang::layout.page_position.news_list'),(9,'news_detail','lang::layout.page_position.news_detail'),(10,'shop_auth','lang::layout.page_position.shop_auth'),(11,'shop_profile','lang::layout.page_position.shop_profile'),(12,'shop_page','lang::layout.page_position.shop_page'),(13,'shop_contact','lang::layout.page_position.shop_contact'),(14,'content_list','lang::layout.page_position.content_list'),(15,'content_detail','lang::layout.page_position.content_detail');
/*!40000 ALTER TABLE `sc_shop_layout_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_layout_position`
--

DROP TABLE IF EXISTS `sc_shop_layout_position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_layout_position` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_shop_layout_position_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_layout_position`
--

LOCK TABLES `sc_shop_layout_position` WRITE;
/*!40000 ALTER TABLE `sc_shop_layout_position` DISABLE KEYS */;
INSERT INTO `sc_shop_layout_position` VALUES (1,'meta','lang::layout.page_block.meta'),(2,'header','lang::layout.page_block.header'),(3,'top','lang::layout.page_block.top'),(4,'bottom','lang::layout.page_block.bottom'),(5,'left','lang::layout.page_block.left'),(6,'right','lang::layout.page_block.right'),(7,'banner_top','lang::layout.page_block.banner_top');
/*!40000 ALTER TABLE `sc_shop_layout_position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_length`
--

DROP TABLE IF EXISTS `sc_shop_length`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_length` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_shop_length_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_length`
--

LOCK TABLES `sc_shop_length` WRITE;
/*!40000 ALTER TABLE `sc_shop_length` DISABLE KEYS */;
INSERT INTO `sc_shop_length` VALUES (1,'mm','Millimeter'),(2,'cm','Centimeter'),(3,'m','Meter'),(4,'in','Inch');
/*!40000 ALTER TABLE `sc_shop_length` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_link`
--

DROP TABLE IF EXISTS `sc_shop_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_link`
--

LOCK TABLES `sc_shop_link` WRITE;
/*!40000 ALTER TABLE `sc_shop_link` DISABLE KEYS */;
INSERT INTO `sc_shop_link` VALUES (1,'lang::front.contact','route::page.detail::contact','_self','menu','',1,3),(2,'lang::front.about','route::page.detail::about','_self','menu','',1,4),(3,'lang::front.my_profile','/member/login.html','_self','footer','',1,5),(4,'lang::front.compare_page','/compare.html','_self','footer','',1,4),(5,'lang::front.wishlist_page','route::wishlist','_self','footer','',1,3);
/*!40000 ALTER TABLE `sc_shop_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_news`
--

DROP TABLE IF EXISTS `sc_shop_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sc_shop_news_alias_index` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_news`
--

LOCK TABLES `sc_shop_news` WRITE;
/*!40000 ALTER TABLE `sc_shop_news` DISABLE KEYS */;
INSERT INTO `sc_shop_news` VALUES (1,'/data/content/blog-1.jpg','demo-alias-blog-1',0,1,'2020-09-06 17:00:00',NULL),(2,'/data/content/blog-2.jpg','demo-alias-blog-2',0,1,'2020-09-06 17:00:00',NULL),(3,'/data/content/blog-3.jpg','demo-alias-blog-3',0,1,'2020-09-06 17:00:00',NULL),(4,'/data/content/blog-4.jpg','demo-alias-blog-4',0,1,'2020-09-06 17:00:00',NULL),(5,'/data/content/blog-5.jpg','demo-alias-blog-5',0,1,'2020-09-06 17:00:00',NULL),(6,'/data/content/blog-6.jpg','demo-alias-blog-6',0,1,'2020-09-06 17:00:00',NULL);
/*!40000 ALTER TABLE `sc_shop_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_news_description`
--

DROP TABLE IF EXISTS `sc_shop_news_description`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_news_description` (
  `news_id` int(11) NOT NULL,
  `lang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`news_id`,`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_news_description`
--

LOCK TABLES `sc_shop_news_description` WRITE;
/*!40000 ALTER TABLE `sc_shop_news_description` DISABLE KEYS */;
INSERT INTO `sc_shop_news_description` VALUES (1,'en','Easy Polo Black Edition 1','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(1,'vi','Easy Polo Black Edition 1','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(2,'en','Easy Polo Black Edition 2','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(2,'vi','Easy Polo Black Edition 2','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(3,'en','Easy Polo Black Edition 3','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(3,'vi','Easy Polo Black Edition 3','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(4,'en','Easy Polo Black Edition 4','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(4,'vi','Easy Polo Black Edition 4','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(5,'en','Easy Polo Black Edition 5','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(5,'vi','Easy Polo Black Edition 5','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(6,'en','Easy Polo Black Edition 6','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(6,'vi','Easy Polo Black Edition 6','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>');
/*!40000 ALTER TABLE `sc_shop_news_description` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_news_store`
--

DROP TABLE IF EXISTS `sc_shop_news_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_news_store` (
  `news_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`news_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_news_store`
--

LOCK TABLES `sc_shop_news_store` WRITE;
/*!40000 ALTER TABLE `sc_shop_news_store` DISABLE KEYS */;
INSERT INTO `sc_shop_news_store` VALUES (1,0),(2,0),(3,0),(4,0),(5,0),(6,0);
/*!40000 ALTER TABLE `sc_shop_news_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_order`
--

DROP TABLE IF EXISTS `sc_shop_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT 1,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtotal` int(11) DEFAULT 0,
  `shipping` int(11) DEFAULT 0,
  `discount` int(11) DEFAULT 0,
  `payment_status` int(11) NOT NULL DEFAULT 1,
  `shipping_status` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 0,
  `tax` int(11) DEFAULT 0,
  `total` int(11) DEFAULT 0,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` double(8,2) DEFAULT NULL,
  `received` int(11) DEFAULT 0,
  `balance` int(11) DEFAULT 0,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name_kana` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name_kana` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'VN',
  `company` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_method` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_order`
--

LOCK TABLES `sc_shop_order` WRITE;
/*!40000 ALTER TABLE `sc_shop_order` DISABLE KEYS */;
INSERT INTO `sc_shop_order` VALUES (1,1,1,NULL,5000,2000,0,1,1,1,0,7000,'USD',1.00,0,7000,'Naruto','Kun',NULL,NULL,'ADDRESS 1','ADDRESS 2','VN',NULL,NULL,'667151172','test@test.com','ok','Cash','ShippingStandard',NULL,NULL,NULL,'2020-09-07 15:37:57',NULL);
/*!40000 ALTER TABLE `sc_shop_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_order_detail`
--

DROP TABLE IF EXISTS `sc_shop_order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_order_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `qty` int(11) NOT NULL DEFAULT 0,
  `total_price` int(11) NOT NULL DEFAULT 0,
  `tax` int(11) NOT NULL DEFAULT 0,
  `sku` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` double(8,2) DEFAULT NULL,
  `attribute` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_order_detail`
--

LOCK TABLES `sc_shop_order_detail` WRITE;
/*!40000 ALTER TABLE `sc_shop_order_detail` DISABLE KEYS */;
INSERT INTO `sc_shop_order_detail` VALUES (1,1,1,'Easy Polo Black Edition 1',5000,1,5000,0,'ABCZZ','USD',1.00,'[]',NULL,NULL);
/*!40000 ALTER TABLE `sc_shop_order_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_order_history`
--

DROP TABLE IF EXISTS `sc_shop_order_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_order_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `content` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `order_status_id` int(11) NOT NULL DEFAULT 0,
  `add_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_order_history`
--

LOCK TABLES `sc_shop_order_history` WRITE;
/*!40000 ALTER TABLE `sc_shop_order_history` DISABLE KEYS */;
INSERT INTO `sc_shop_order_history` VALUES (1,1,'New order',0,1,1,'2020-09-07 22:37:57');
/*!40000 ALTER TABLE `sc_shop_order_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_order_status`
--

DROP TABLE IF EXISTS `sc_shop_order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_order_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_order_status`
--

LOCK TABLES `sc_shop_order_status` WRITE;
/*!40000 ALTER TABLE `sc_shop_order_status` DISABLE KEYS */;
INSERT INTO `sc_shop_order_status` VALUES (1,'New'),(2,'Processing'),(3,'Hold'),(4,'Canceled'),(5,'Done'),(6,'Failed');
/*!40000 ALTER TABLE `sc_shop_order_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_order_total`
--

DROP TABLE IF EXISTS `sc_shop_order_total`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_order_total` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` int(11) NOT NULL DEFAULT 0,
  `text` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_order_total`
--

LOCK TABLES `sc_shop_order_total` WRITE;
/*!40000 ALTER TABLE `sc_shop_order_total` DISABLE KEYS */;
INSERT INTO `sc_shop_order_total` VALUES (1,1,'Subtotal','subtotal',5000,NULL,1,NULL,NULL),(2,1,'Shipping','shipping',2000,NULL,10,NULL,NULL),(3,1,'Discount','discount',0,NULL,20,NULL,NULL),(4,1,'Total','total',7000,NULL,100,NULL,NULL),(5,1,'Received','received',0,NULL,200,NULL,NULL);
/*!40000 ALTER TABLE `sc_shop_order_total` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_page`
--

DROP TABLE IF EXISTS `sc_shop_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `sc_shop_page_alias_index` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_page`
--

LOCK TABLES `sc_shop_page` WRITE;
/*!40000 ALTER TABLE `sc_shop_page` DISABLE KEYS */;
INSERT INTO `sc_shop_page` VALUES (1,'','about',1);
/*!40000 ALTER TABLE `sc_shop_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_page_description`
--

DROP TABLE IF EXISTS `sc_shop_page_description`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_page_description` (
  `page_id` int(11) NOT NULL,
  `lang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`page_id`,`lang`),
  KEY `sc_shop_page_description_lang_index` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_page_description`
--

LOCK TABLES `sc_shop_page_description` WRITE;
/*!40000 ALTER TABLE `sc_shop_page_description` DISABLE KEYS */;
INSERT INTO `sc_shop_page_description` VALUES (1,'en','About','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-2.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>\r\n    '),(1,'vi','Giới thiệu','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-2.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>\r\n    ');
/*!40000 ALTER TABLE `sc_shop_page_description` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_page_store`
--

DROP TABLE IF EXISTS `sc_shop_page_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_page_store` (
  `page_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`page_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_page_store`
--

LOCK TABLES `sc_shop_page_store` WRITE;
/*!40000 ALTER TABLE `sc_shop_page_store` DISABLE KEYS */;
INSERT INTO `sc_shop_page_store` VALUES (1,0);
/*!40000 ALTER TABLE `sc_shop_page_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_password_resets`
--

DROP TABLE IF EXISTS `sc_shop_password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_password_resets` (
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  KEY `sc_shop_password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_password_resets`
--

LOCK TABLES `sc_shop_password_resets` WRITE;
/*!40000 ALTER TABLE `sc_shop_password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `sc_shop_password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_payment_status`
--

DROP TABLE IF EXISTS `sc_shop_payment_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_payment_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_payment_status`
--

LOCK TABLES `sc_shop_payment_status` WRITE;
/*!40000 ALTER TABLE `sc_shop_payment_status` DISABLE KEYS */;
INSERT INTO `sc_shop_payment_status` VALUES (1,'Unpaid'),(2,'Partial payment'),(3,'Paid'),(4,'Refurn');
/*!40000 ALTER TABLE `sc_shop_payment_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_product`
--

DROP TABLE IF EXISTS `sc_shop_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sku` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upc` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'upc code',
  `ean` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ean code',
  `jan` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'jan code',
  `isbn` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'isbn code',
  `mpn` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'mpn code',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_id` int(11) DEFAULT 0,
  `supplier_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int(11) DEFAULT 0,
  `cost` int(11) DEFAULT 0,
  `stock` int(11) DEFAULT 0,
  `sold` int(11) DEFAULT 0,
  `minimum` int(11) DEFAULT 0,
  `weight_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` int(11) DEFAULT 0,
  `length_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `length` int(11) DEFAULT 0,
  `width` int(11) DEFAULT 0,
  `height` int(11) DEFAULT 0,
  `kind` tinyint(4) DEFAULT 0 COMMENT '0:single, 1:bundle, 2:group',
  `property` tinyint(4) DEFAULT 0 COMMENT '0:physical, 1:download, 2:only view, 3: Service',
  `tax_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '0' COMMENT '0:No-tax, auto: Use tax default',
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  `view` int(11) NOT NULL DEFAULT 0,
  `alias` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_lastview` datetime DEFAULT NULL,
  `date_available` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_shop_product_sku_unique` (`sku`),
  UNIQUE KEY `sc_shop_product_alias_unique` (`alias`),
  KEY `sc_shop_product_brand_id_index` (`brand_id`),
  KEY `sc_shop_product_supplier_id_index` (`supplier_id`),
  KEY `sc_shop_product_kind_index` (`kind`),
  KEY `sc_shop_product_property_index` (`property`),
  KEY `sc_shop_product_tax_id_index` (`tax_id`),
  KEY `sc_shop_product_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_product`
--

LOCK TABLES `sc_shop_product` WRITE;
/*!40000 ALTER TABLE `sc_shop_product` DISABLE KEYS */;
INSERT INTO `sc_shop_product` VALUES (1,'ABCZZ',NULL,NULL,NULL,NULL,NULL,'/data/product/product-1.png',1,'1',15000,10000,99,1,0,NULL,0,NULL,0,0,0,0,0,'auto',1,0,0,'demo-alias-name-product-1',NULL,'2020-10-07',NULL,NULL),(2,'LEDFAN1',NULL,NULL,NULL,NULL,NULL,'/data/product/product-2.png',1,'1',15000,10000,100,0,0,NULL,0,NULL,0,0,0,0,0,'auto',1,0,0,'demo-alias-name-product-2',NULL,NULL,NULL,NULL),(3,'CLOCKFAN1',NULL,NULL,NULL,NULL,NULL,'/data/product/product-3.png',2,'1',15000,10000,100,0,0,NULL,0,NULL,0,0,0,0,0,'auto',1,0,0,'demo-alias-name-product-3',NULL,NULL,NULL,NULL),(4,'CLOCKFAN2',NULL,NULL,NULL,NULL,NULL,'/data/product/product-4.png',3,'1',15000,10000,100,0,10,NULL,0,NULL,0,0,0,0,0,'auto',1,0,0,'demo-alias-name-product-4',NULL,NULL,NULL,NULL),(5,'CLOCKFAN3',NULL,NULL,NULL,NULL,NULL,'/data/product/product-5.png',1,'1',15000,10000,100,0,0,NULL,0,NULL,0,0,0,0,0,'auto',1,0,0,'demo-alias-name-product-5',NULL,NULL,NULL,NULL),(6,'TMC2208',NULL,NULL,NULL,NULL,NULL,'/data/product/product-6.png',1,'1',15000,10000,100,0,0,NULL,0,NULL,0,0,0,0,0,'auto',1,0,0,'demo-alias-name-product-6',NULL,NULL,NULL,NULL),(7,'FILAMENT',NULL,NULL,NULL,NULL,NULL,'/data/product/product-7.png',2,'1',15000,10000,100,0,0,NULL,0,NULL,0,0,0,0,0,'auto',1,0,0,'demo-alias-name-product-7',NULL,NULL,NULL,NULL),(8,'A4988',NULL,NULL,NULL,NULL,NULL,'/data/product/product-8.png',2,'1',15000,10000,100,0,0,NULL,0,NULL,0,0,0,0,0,'auto',1,0,0,'demo-alias-name-product-8',NULL,NULL,NULL,NULL),(9,'ANYCUBIC-P',NULL,NULL,NULL,NULL,NULL,'/data/product/product-9.png',2,'1',15000,10000,100,0,0,NULL,0,NULL,0,0,0,0,0,'auto',1,0,0,'demo-alias-name-product-9',NULL,NULL,NULL,NULL),(10,'3DHLFD-P',NULL,NULL,NULL,NULL,NULL,'/data/product/product-10.png',4,'1',15000,10000,100,0,0,NULL,0,NULL,0,0,0,0,0,'auto',1,0,0,'demo-alias-name-product-10',NULL,NULL,NULL,NULL),(11,'SS495A',NULL,NULL,NULL,NULL,NULL,'/data/product/product-11.png',2,'1',15000,10000,100,0,0,NULL,0,NULL,0,0,0,0,0,'auto',1,0,0,'demo-alias-name-product-11',NULL,NULL,NULL,NULL),(12,'3D-CARBON175',NULL,NULL,NULL,NULL,NULL,'/data/product/product-12.png',2,'1',15000,10000,100,0,5,NULL,0,NULL,0,0,0,0,0,'auto',1,0,0,'demo-alias-name-product-12',NULL,NULL,NULL,NULL),(13,'3D-GOLD175',NULL,NULL,NULL,NULL,NULL,'/data/product/product-13.png',3,'1',10000,5000,0,0,0,NULL,0,NULL,0,0,0,0,0,'auto',1,0,0,'demo-alias-name-product-13',NULL,NULL,NULL,NULL),(14,'LCD12864-3D',NULL,NULL,NULL,NULL,NULL,'/data/product/product-14.png',3,'1',15000,10000,100,0,0,NULL,0,NULL,0,0,0,0,0,'auto',1,0,0,'demo-alias-name-product-14',NULL,NULL,NULL,NULL),(15,'LCD2004-3D',NULL,NULL,NULL,NULL,NULL,'/data/product/product-15.png',3,'1',15000,10000,100,0,10,NULL,0,NULL,0,0,0,1,0,'auto',1,0,0,'demo-alias-name-product-15',NULL,NULL,NULL,NULL),(16,'RAMPS15-3D',NULL,NULL,NULL,NULL,NULL,'/data/product/product-16.png',2,'1',0,0,0,0,0,NULL,0,NULL,0,0,0,2,0,'auto',1,0,0,'demo-alias-name-product-16',NULL,NULL,NULL,NULL),(17,'ALOKK1-AY',NULL,NULL,NULL,NULL,NULL,'/data/product/product-10.png',3,'1',15000,10000,100,0,5,NULL,0,NULL,0,0,0,0,0,'auto',1,0,0,'demo-alias-name-product-17',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `sc_shop_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_product_attribute`
--

DROP TABLE IF EXISTS `sc_shop_product_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_product_attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute_group_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `add_price` int(11) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `sc_shop_product_attribute_product_id_attribute_group_id_index` (`product_id`,`attribute_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_product_attribute`
--

LOCK TABLES `sc_shop_product_attribute` WRITE;
/*!40000 ALTER TABLE `sc_shop_product_attribute` DISABLE KEYS */;
INSERT INTO `sc_shop_product_attribute` VALUES (1,'Blue',1,17,50,0,1),(2,'White',1,17,0,0,1),(3,'S',2,17,20,0,1),(4,'XL',2,17,30,0,1),(5,'Blue',1,10,150,0,1),(6,'Red',1,10,0,0,1),(7,'S',2,10,0,0,1),(8,'M',2,10,0,0,1);
/*!40000 ALTER TABLE `sc_shop_product_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_product_build`
--

DROP TABLE IF EXISTS `sc_shop_product_build`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_product_build` (
  `build_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`build_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_product_build`
--

LOCK TABLES `sc_shop_product_build` WRITE;
/*!40000 ALTER TABLE `sc_shop_product_build` DISABLE KEYS */;
INSERT INTO `sc_shop_product_build` VALUES (15,6,1),(15,7,2);
/*!40000 ALTER TABLE `sc_shop_product_build` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_product_category`
--

DROP TABLE IF EXISTS `sc_shop_product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_product_category`
--

LOCK TABLES `sc_shop_product_category` WRITE;
/*!40000 ALTER TABLE `sc_shop_product_category` DISABLE KEYS */;
INSERT INTO `sc_shop_product_category` VALUES (1,6),(1,10),(1,13),(2,13),(3,11),(4,11),(5,11),(6,11),(7,12),(8,10),(9,6),(10,11),(11,10),(12,9),(13,5),(14,11),(15,6),(16,9),(17,9);
/*!40000 ALTER TABLE `sc_shop_product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_product_description`
--

DROP TABLE IF EXISTS `sc_shop_product_description`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_product_description` (
  `product_id` int(11) NOT NULL,
  `lang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keyword` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`product_id`,`lang`),
  KEY `sc_shop_product_description_lang_index` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_product_description`
--

LOCK TABLES `sc_shop_product_description` WRITE;
/*!40000 ALTER TABLE `sc_shop_product_description` DISABLE KEYS */;
INSERT INTO `sc_shop_product_description` VALUES (1,'en','Easy Polo Black Edition 1','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(1,'vi','Easy Polo Black Edition 1','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(2,'en','Easy Polo Black Edition 2','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(2,'vi','Easy Polo Black Edition 2','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(3,'en','Easy Polo Black Edition 3','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(3,'vi','Easy Polo Black Edition 3','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(4,'en','Easy Polo Black Edition 4','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(4,'vi','Easy Polo Black Edition 4','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(5,'en','Easy Polo Black Edition 5','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(5,'vi','Easy Polo Black Edition 5','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(6,'en','Easy Polo Black Edition 6','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(6,'vi','Easy Polo Black Edition 6','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(7,'en','Easy Polo Black Edition 7','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(7,'vi','Easy Polo Black Edition 7','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(8,'en','Easy Polo Black Edition 8','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(8,'vi','Easy Polo Black Edition 8','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(9,'en','Easy Polo Black Edition 9','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(9,'vi','Easy Polo Black Edition 9','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(10,'en','Easy Polo Black Edition 10','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(10,'vi','Easy Polo Black Edition 10','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(11,'en','Easy Polo Black Edition 11','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(11,'vi','Easy Polo Black Edition 11','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(12,'en','Easy Polo Black Edition 12','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(12,'vi','Easy Polo Black Edition 12','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(13,'en','Easy Polo Black Edition 13','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(13,'vi','Easy Polo Black Edition 13','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(14,'en','Easy Polo Black Edition 14','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(14,'vi','Easy Polo Black Edition 14','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(15,'en','Easy Polo Black Edition 15','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(15,'vi','Easy Polo Black Edition 15','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(16,'en','Easy Polo Black Edition 16','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(16,'vi','Easy Polo Black Edition 16','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(17,'en','Easy Polo Black Edition 17','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'),(17,'vi','Easy Polo Black Edition 17','','','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<img alt=\"\" src=\"/data/product/product-10.png\" style=\"width: 262px; height: 262px; float: right; margin: 10px;\" /></p>\r\n    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>');
/*!40000 ALTER TABLE `sc_shop_product_description` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_product_group`
--

DROP TABLE IF EXISTS `sc_shop_product_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_product_group` (
  `group_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_product_group`
--

LOCK TABLES `sc_shop_product_group` WRITE;
/*!40000 ALTER TABLE `sc_shop_product_group` DISABLE KEYS */;
INSERT INTO `sc_shop_product_group` VALUES (16,1),(16,2);
/*!40000 ALTER TABLE `sc_shop_product_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_product_image`
--

DROP TABLE IF EXISTS `sc_shop_product_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_product_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `sc_shop_product_image_product_id_index` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_product_image`
--

LOCK TABLES `sc_shop_product_image` WRITE;
/*!40000 ALTER TABLE `sc_shop_product_image` DISABLE KEYS */;
INSERT INTO `sc_shop_product_image` VALUES (1,'/data/product/product-2.png',1),(2,'/data/product/product-11.png',1),(3,'/data/product/product-8.png',11),(4,'/data/product/product-6.png',2),(5,'/data/product/product-13.png',11),(6,'/data/product/product-12.png',5),(7,'/data/product/product-6.png',5),(8,'/data/product/product-1.png',2),(9,'/data/product/product-15.png',2),(10,'/data/product/product-5.png',9),(11,'/data/product/product-8.png',8),(12,'/data/product/product-2.png',7),(13,'/data/product/product-6.png',7),(14,'/data/product/product-11.png',5),(15,'/data/product/product-13.png',4),(16,'/data/product/product-13.png',15),(17,'/data/product/product-6.png',15),(18,'/data/product/product-12.png',17),(19,'/data/product/product-6.png',17),(20,'/data/product/product-2.png',17);
/*!40000 ALTER TABLE `sc_shop_product_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_product_promotion`
--

DROP TABLE IF EXISTS `sc_shop_product_promotion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_product_promotion` (
  `product_id` int(11) NOT NULL,
  `price_promotion` int(11) NOT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `status_promotion` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_product_promotion`
--

LOCK TABLES `sc_shop_product_promotion` WRITE;
/*!40000 ALTER TABLE `sc_shop_product_promotion` DISABLE KEYS */;
INSERT INTO `sc_shop_product_promotion` VALUES (1,5000,NULL,NULL,1,NULL,NULL),(2,3000,NULL,NULL,1,NULL,NULL),(11,600,NULL,NULL,1,NULL,NULL),(13,4000,NULL,NULL,1,NULL,NULL);
/*!40000 ALTER TABLE `sc_shop_product_promotion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_product_store`
--

DROP TABLE IF EXISTS `sc_shop_product_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_product_store` (
  `product_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_product_store`
--

LOCK TABLES `sc_shop_product_store` WRITE;
/*!40000 ALTER TABLE `sc_shop_product_store` DISABLE KEYS */;
INSERT INTO `sc_shop_product_store` VALUES (1,0),(2,0),(3,0),(4,0),(5,0),(6,0),(7,0),(8,0),(9,0),(10,0),(11,0),(12,0),(13,0),(14,0),(15,0),(16,0),(17,0);
/*!40000 ALTER TABLE `sc_shop_product_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_sessions`
--

DROP TABLE IF EXISTS `sc_shop_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_sessions` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sc_shop_sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_sessions`
--

LOCK TABLES `sc_shop_sessions` WRITE;
/*!40000 ALTER TABLE `sc_shop_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sc_shop_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_shipping_standard`
--

DROP TABLE IF EXISTS `sc_shop_shipping_standard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_shipping_standard` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fee` int(11) NOT NULL,
  `shipping_free` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_shipping_standard`
--

LOCK TABLES `sc_shop_shipping_standard` WRITE;
/*!40000 ALTER TABLE `sc_shop_shipping_standard` DISABLE KEYS */;
INSERT INTO `sc_shop_shipping_standard` VALUES (1,20,10000);
/*!40000 ALTER TABLE `sc_shop_shipping_standard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_shipping_status`
--

DROP TABLE IF EXISTS `sc_shop_shipping_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_shipping_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_shipping_status`
--

LOCK TABLES `sc_shop_shipping_status` WRITE;
/*!40000 ALTER TABLE `sc_shop_shipping_status` DISABLE KEYS */;
INSERT INTO `sc_shop_shipping_status` VALUES (1,'Not sent'),(2,'Sending'),(3,'Shipping done');
/*!40000 ALTER TABLE `sc_shop_shipping_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_shoppingcart`
--

DROP TABLE IF EXISTS `sc_shop_shoppingcart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_shoppingcart` (
  `identifier` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instance` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `sc_shop_shoppingcart_identifier_instance_index` (`identifier`,`instance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_shoppingcart`
--

LOCK TABLES `sc_shop_shoppingcart` WRITE;
/*!40000 ALTER TABLE `sc_shop_shoppingcart` DISABLE KEYS */;
/*!40000 ALTER TABLE `sc_shop_shoppingcart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_subscribe`
--

DROP TABLE IF EXISTS `sc_shop_subscribe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_subscribe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_shop_subscribe_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_subscribe`
--

LOCK TABLES `sc_shop_subscribe` WRITE;
/*!40000 ALTER TABLE `sc_shop_subscribe` DISABLE KEYS */;
/*!40000 ALTER TABLE `sc_shop_subscribe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_supplier`
--

DROP TABLE IF EXISTS `sc_shop_supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_supplier` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `sort` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_shop_supplier_alias_unique` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_supplier`
--

LOCK TABLES `sc_shop_supplier` WRITE;
/*!40000 ALTER TABLE `sc_shop_supplier` DISABLE KEYS */;
INSERT INTO `sc_shop_supplier` VALUES (1,'ABC distributor','abc-distributor','abc@abc.com','012496657567','/data/supplier/supplier.png','','',1,0),(2,'XYZ distributor','xyz-distributor','xyz@xyz.com','012496657567','/data/supplier/supplier.png','','',1,0);
/*!40000 ALTER TABLE `sc_shop_supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_tax`
--

DROP TABLE IF EXISTS `sc_shop_tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_tax` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_tax`
--

LOCK TABLES `sc_shop_tax` WRITE;
/*!40000 ALTER TABLE `sc_shop_tax` DISABLE KEYS */;
INSERT INTO `sc_shop_tax` VALUES (1,'Tax default (10%)',10);
/*!40000 ALTER TABLE `sc_shop_tax` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_user`
--

DROP TABLE IF EXISTS `sc_shop_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name_kana` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name_kana` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` tinyint(4) DEFAULT NULL COMMENT '0:women, 1:men',
  `birthday` date DEFAULT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_id` int(11) NOT NULL DEFAULT 0,
  `postcode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'VN',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `group` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `provider` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_shop_user_email_provider_provider_id_unique` (`email`,`provider`,`provider_id`),
  KEY `sc_shop_user_address_id_index` (`address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_user`
--

LOCK TABLES `sc_shop_user` WRITE;
/*!40000 ALTER TABLE `sc_shop_user` DISABLE KEYS */;
INSERT INTO `sc_shop_user` VALUES (1,'Naruto','Kun',NULL,NULL,'test@test.com',NULL,NULL,'$2y$10$rf2/V01OSWT5VxQEsIXX2eo6FbruOiE0v5bM8SADJnvxEkT4SUP.S',0,'70000','HCM','HCM city','KTC','VN','0667151172',NULL,1,1,'2020-09-07 15:37:57',NULL,NULL,NULL);
/*!40000 ALTER TABLE `sc_shop_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_user_address`
--

DROP TABLE IF EXISTS `sc_shop_user_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_user_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name_kana` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name_kana` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'VN',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_user_address`
--

LOCK TABLES `sc_shop_user_address` WRITE;
/*!40000 ALTER TABLE `sc_shop_user_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `sc_shop_user_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sc_shop_weight`
--

DROP TABLE IF EXISTS `sc_shop_weight`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sc_shop_weight` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sc_shop_weight_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sc_shop_weight`
--

LOCK TABLES `sc_shop_weight` WRITE;
/*!40000 ALTER TABLE `sc_shop_weight` DISABLE KEYS */;
INSERT INTO `sc_shop_weight` VALUES (1,'g','Gram'),(2,'kg','Kilogram'),(3,'lb','Pound '),(4,'oz','Ounce ');
/*!40000 ALTER TABLE `sc_shop_weight` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-09-07 22:39:55
