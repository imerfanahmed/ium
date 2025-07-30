<?php
/**
 * phpMyAdmin configuration for IUM development environment
 */

declare(strict_types=1);

/**
 * Servers configuration
 */
$i = 0;

/**
 * First server (MariaDB)
 */
$i++;
$cfg['Servers'][$i]['auth_type'] = 'config';
$cfg['Servers'][$i]['host'] = 'mariadb';
$cfg['Servers'][$i]['port'] = '3306';
$cfg['Servers'][$i]['user'] = 'root';
$cfg['Servers'][$i]['password'] = 'root';
$cfg['Servers'][$i]['compress'] = false;
$cfg['Servers'][$i]['AllowNoPassword'] = true;

/**
 * Global configuration
 */
$cfg['blowfish_secret'] = 'ium-development-secret-key-change-in-production';
$cfg['DefaultLang'] = 'en';
$cfg['ServerDefault'] = 1;
$cfg['UploadDir'] = '';
$cfg['SaveDir'] = '';

/**
 * UI Configuration
 */
$cfg['MaxRows'] = 25;
$cfg['ProtectBinary'] = false;
$cfg['DefaultTabServer'] = 'welcome';
$cfg['DefaultTabDatabase'] = 'structure';
$cfg['DefaultTabTable'] = 'browse';
$cfg['LoginCookieValidity'] = 3600;
$cfg['ShowPhpInfo'] = true;
$cfg['ShowServerInfo'] = true;
$cfg['ShowDbStructureCharset'] = false;
$cfg['ShowDbStructureComment'] = false;
$cfg['ShowDbStructureCreation'] = false;
$cfg['ShowDbStructureLastUpdate'] = false;
$cfg['ShowDbStructureLastCheck'] = false;

/**
 * Import/Export configuration
 */
$cfg['Import']['allow_interrupt'] = true;
$cfg['Export']['asfile'] = true;
$cfg['Export']['charset'] = 'utf-8';
$cfg['Export']['compression'] = 'none';
$cfg['Export']['format'] = 'sql';

/**
 * Theme
 */
$cfg['ThemeDefault'] = 'pmahomme';

/**
 * Session configuration
 */
$cfg['SessionSavePath'] = '/tmp';

/**
 * Disable version check
 */
$cfg['VersionCheck'] = false;

/**
 * Console configuration
 */
$cfg['Console']['StartHistory'] = true;
$cfg['Console']['AlwaysExpand'] = false;
$cfg['Console']['CurrentQuery'] = true;

/**
 * SQL configuration
 */
$cfg['SQLQuery']['Edit'] = true;
$cfg['SQLQuery']['Explain'] = true;
$cfg['SQLQuery']['ShowAsPHP'] = true;
$cfg['SQLQuery']['Validate'] = false;
$cfg['SQLQuery']['Refresh'] = true;
