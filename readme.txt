=== Quick Developer Insights ===
Plugin Name: Quick Developer Insights
Contributors: Joseph Reilly
Tags: phpinfo(), php information, WordPress options, server settings, utility
Requires at least: 3.1
Tested up to: 4.1
Stable tag: 0.1
License: GPLv2 or later

Quick Developer Insights allows for quick access to PHP, server, and WordPress information.

== Description ==

Adds 3 useful pages to your admin menu: PHPINFO, SHORTCODES, and SET WP OPTIONS. 
PHPINFO -- Contains a tables of the information related to the sites PHP configuration.
SET WP OPTIONS -- Contains a table of information containing the values of WordPress options set.
SHORTCODES -- Contains the shortcodes and their corresponding functions. 

Shortcodes:
[qdi_cpu] which runs getrusage(), [qdi_funct] which runs get_defined_functions(), [qdi_class] which runs get_declared_classes(), and [qdi_mem] which runs memory_get_usage().
Tested on WordPress 4.1.1.

== Installation ==

1. Download, unzip and upload the `quick-dev-insights` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the `Plugins` menu in WordPress.
3. navigate to information pages under "Quick Developer Insights" in the admin menu.

== Frequently Asked Questions ==

= What are the shortcodes? =
Shortcodes:
[qdi_cpu] which runs getrusage(), [qdi_funct] which runs get_defined_functions(), [qdi_class] which runs get_declared_classes(), and [qdi_mem] which runs memory_get_usage().

= What do the shortcodes do? =
RTFM...look up the functions.

= Is it risky to leave this installed? =
Maybe. Some information this plugin gives you access to is sensitive.

== Screenshots ==
1. The Main Plugin Page.
2. The PHP info page.
3. The WordPress options page.
4. The Shortcodes page.
== Changelog ==
Version 0.1
== Upgrade Notice ==
Upgrades will be release when needed.
