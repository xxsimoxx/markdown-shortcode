<?php

/**
 * -----------------------------------------------------------------------------
 * Plugin Name: Markdown shortcode
 * Description: Render GitHub-Flavored Markdown inside [md][/md] shortcode.
 * Version: 1.0.0
 * Requires PHP: 7.4
 * Requires CP: 2.0
 * Author: Simone Fioravanti
 * Author URI: https://software.gieffeedizioni.it
 * Plugin URI: https://software.gieffeedizioni.it
 * Domain Path: /languages
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * -----------------------------------------------------------------------------
 * This is free software released under the terms of the General Public License,
 * version 2, or later. It is distributed WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. Full
 * text of the license is available at https://www.gnu.org/licenses/gpl-2.0.txt.
 * -----------------------------------------------------------------------------
 */

namespace XXSimoXX\MarkdownShortcode;

require_once 'vendor/autoload.php';
use League\CommonMark\GithubFlavoredMarkdownConverter;

class MarkdownShortcode {

	const COMMONMARK_SETTINGS = [
		'html_input'         => 'strip',
		'allow_unsafe_links' => false,
	];

	public function __construct() {
		add_shortcode('md', [$this, 'process_shortcode']);
		remove_filter('the_content', 'do_shortcode');
		add_filter('the_content', 'do_shortcode', 5);
	}


	public function process_shortcode($atts, $content = '') {
		/**
		 * Filters the Markdown parser settings.
		 * See https://github.com/thephpleague/commonmark
		 *
		 * @since 1.0.0
		 *
		 * @param string $settings Settings array for league/commonmark PHP Markdown parser.
		 */
		$settings = apply_filters('markdownshortcode_converter_setting', self::COMMONMARK_SETTINGS);

		$converter = new \League\CommonMark\GithubFlavoredMarkdownConverter($settings);
		return $converter->convert($content);
	}

}

new MarkdownShortcode();
