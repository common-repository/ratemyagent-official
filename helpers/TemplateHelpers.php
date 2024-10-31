<?php

namespace Rma\Helpers;

function build_url(array $elements)
{
	$e = $elements;
	return (isset($e['host']) ? (
			(isset($e['scheme']) ? "$e[scheme]://" : '//') .
			(isset($e['user']) ? $e['user'] . (isset($e['pass']) ? ":$e[pass]" : '') . '@' : '') .
			$e['host'] .
			(isset($e['port']) ? ":$e[port]" : '')
		) : '') .
		(isset($e['path']) ? $e['path'] : '/') .
		(isset($e['query']) ? '?' . (is_array($e['query']) ? http_build_query($e['query'], '', '&') : $e['query']) : '') .
		(isset($e['fragment']) ? "#$e[fragment]" : '');
}

class TemplateHelpers
{
	static function render_partial(string $path, array $vars = []): string
	{
		extract($vars);

		ob_start();
		include($path);
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

	static function render_shortcode(string $shortcodeName, array $properties = []): string
	{
		$props = array_map(function ($v, $k) {
			return $k . '="' . $v . '"';
		}, array_values($properties), array_keys($properties));
		$propString = implode(' ', $props);

		$shortCode = '[' . $shortcodeName . ' ' . $propString . ']';
		ob_start();
		echo do_shortcode($shortCode);
		$html = ob_get_contents();
		ob_get_clean();

		return $html;
	}

	static function notification(string $type, string $message, bool $dismissible = true)
	{
		ob_start(); ?>
		<div class="notice notice-<?php echo esc_attr($type) ?> <?php echo $dismissible ? 'is-dismissible' : '' ?>">
			<p><strong> <?php echo esc_textarea($message) ?></strong></p>
		</div>
		<?php
		ob_get_contents();

		return ob_get_clean();
	}

	static function trixelImg(string $url = '', string $category = 'Unknown')
	{
		if ($url === '') {
			$trixelUrl = 'https://trixels.ratemyagent.com.au/trixel/init';
		} else {
			$parts = parse_url($url);

			$params = [];
			parse_str($parts['query'], $params);
			$params['c'] = "RateMyAgent:WordpressPlugin:" . ucwords($category);
			$parts['query'] = $params;
			$trixelUrl = build_url($parts);
		}

		ob_start(); ?>

		<img src="<?php echo esc_url($trixelUrl) ?>" style="position:relative; height:0; width:0;" loading="lazy"/>
		<?php
		ob_get_contents();

		return ob_get_clean();
	}


	static function pluginVersion()
	{
		ob_start(); ?>
		<span style="display:none; line-height: 0" >RMA plugin version: <?php echo RMA_PLUGIN_VERSION ?></span>
		<?php
		ob_get_contents();
		return ob_get_clean();
	}

	static function card_header()
	{
		ob_start(); ?>
		<header class="rma-block-header">
			<span class="rma-block-header-logo"><?php _e('RateMyAgent', 'ratemyagent-official') ?></span>
		</header>
		<?php
		ob_get_contents();

		return ob_get_clean();
	}

	static function generate_id($length = 6, $prefix = ''): string
	{
		$random = '';
		for ($i = 0; $i < $length; $i++) {
			$random .= chr(rand(ord('a'), ord('z')));
		}

		return $prefix . $random;
	}

	static function allowed_html(): array
	{
		return [
			"header" => ["class" => []],
			"span" => ["class" => []],
			"a" => [
				"href" => [],
				"title" => []
			],
			"form" => [
				"id" => [],
				"action" => [],
				"method" => []
			],
			"br" => [],
			"em" => [],
			"strong" => [],
			"div" => ["class" => []],
			"table" => [
				"class" => [],
				"role" => ["presentation"]
			],
			"tbody" => [],
			"tr" => [],
			"td" => [],
			"th" => ["scope" => ["row"]],
			"label" => ["for"],
			"select" => [
				"id" => [],
				"name" => [],
				"class" => [],
			],
			"option" => [
				"value" => [],
				"selected" => []
			],
			"input" => [
				"type" => [],
				"id" => [],
				"name" => [],
				"required" => [],
				"value" => [],
				"class" => [],
			],
			"p" => [
				"class" => ""
			],
			"button" => ["type" => ["submit", "button"], "id" => [], "class" => []]
		];
	}
}
