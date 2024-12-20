<?php
use App\Libraries\SystemCore;
use App\Libraries\SystemDb;

/**
 * Path Helpers
 */

if(!function_exists('path_css')) {
	function path_css() {
		return base_url(). 'css/';
	}
}

if(!function_exists('path_gfx')) {
	function path_gfx() {
		return base_url(). 'gfx/';
	}
}

if(!function_exists('path_img')) {
	function path_img() {
		return base_url(). 'images/';
	}
}

if(!function_exists('path_img_tn')) {
	function path_img_tn() {
		return base_url(). 'images/tn/';
	}
}

if(!function_exists('path_img_xs')) {
	function path_img_xs() {
		return base_url(). 'images/xs/';
	}
}

if(!function_exists('path_blocks')) {
	function path_blocks() {
		return base_url(). 'images/blocks/';
	}
}

if(!function_exists('path_blocks_tn')) {
	function path_blocks_tn() {
		return base_url(). 'images/blocks/tn/';
	}
}

if(!function_exists('path_avatar')) {
	function path_avatar() {
		return base_url(). 'images/avatars/';
	}
}

if(!function_exists('path_assets')) {
	function path_assets() {
		return base_url(). 'assets/';
	}
}

if(!function_exists('path_js')) {
	function path_js() {
		return base_url(). 'js/';
	}
}

if(!function_exists('svg')) {
	function svg($id) {
		return base_url().'assets/verdin-icons/verdin-icons.svg?v'.setting('version').'#'.$id;
	}
}

/**
 * Users & Settings
 */

if(!function_exists('tier')) {
	function tier() {
		if ( session('tier') ) {
			return session('tier');
		} else {
			return 0;
		}
	}
}

if(!function_exists('logged_user')) {
	function logged_user() {
		if ( session('firstname') && session('lastname') ) {
			return session('firstname') . ' ' . session('lastname');
		} else {
			return 0;
		}
	}
}

if (!function_exists('setting')) {
    function setting($key) {
        $config = new \Config\Settings();
        return $config->getSetting($key);
    }
}

/**
 * Formatting
 */

if(!function_exists('nf')) {
	function nf($number) {
		return number_format($number,0,'.',',');
	}
}

if(!function_exists('read_time')) {
    function read_time($words) {
        if (is_numeric($words)) {
            return number_format($words/150,1,'.',',');
		} else {
            return 0;
		}

	}
}

if(!function_exists('limit_text')) {
	function limit_text($text, $limit) {
        $core = new SystemCore();
        return $core->limit_text($text, $limit);
	}
}

/**
 * Route & URL Helpers
 */

if(!function_exists('get_route')) {
	function get_route() {
        $uri = service('uri', base_url());
        return $uri->getRoutePath();
	}
}

if(!function_exists('get_controller')) {
	function get_controller() {
		$router = service('router');
		$controller_str = $router->controllerName();
        $controller = str_replace('\\App\\Controllers\\', '', $controller_str);
		return strtolower($controller);
	}
}

if(!function_exists('get_method')) {
	function get_method() {
		$router = service('router');
		return $router->methodName();
	}
}

if ( ! function_exists('body_class')) {
    function body_class() {
		$router = service('router');
        $method = $router->methodName();
		$controller_str = $router->controllerName();
		$controller = str_replace('\\App\\Controllers\\', '', $controller_str);
		return strtolower($controller . '-' . $method);
    }
}

if ( ! function_exists('get_domain')) {
    function get_domain() {
        $core = new SystemCore();
        return $core->get_domain();
    }
}

/**
 * Database Timestamp
 */

if(!function_exists('db_now')) {
	function db_now() {
		$core_db = new SystemDb();
		return $core_db->db_now();
	}
}

/**
 * Sanitize String
 */

if(!function_exists('sanitize')) {
	function sanitize($str) {
		$core = new SystemCore();
		return $core->sanitize($str);
	}
}

/**
 * Blocks
 */

if(!function_exists('block')) {
    function block($arr, $group, $alias, $element) {

        if( !empty( $arr[$group][$alias][0][$element] ) ) {
            return $arr[$group][$alias][0][$element];
        } else {
            return '';
        }
    }
}

/**
 * Is Mobile
 */

if(!function_exists('is_mobile')) {
	function is_mobile() {
        $request = service('request');
        $agent   = $request->getUserAgent();
		return $agent->isMobile();
	}
}

/**
 * Empty Image
 */

if(!function_exists('empty_img')) {
	function empty_img() {
		return 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=';
	}
}

/**
 * Module Exists
 */

if(!function_exists('module_exists')) {
	function module_exists($module) {
        return file_exists(APPPATH.'Views/modules/'.$module.'.php');
	}
}

/**
 * QR Code Exists
 */

if (!function_exists('qr_code_exists')) {
    function qr_code_exists($postId) {
        $filePath = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'qrcodes' . DIRECTORY_SEPARATOR . 'post_' . $postId . '.svg';
        return file_exists($filePath);
    }
}