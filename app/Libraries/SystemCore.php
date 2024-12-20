<?php namespace App\Libraries;

class SystemCore {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

/**
 * Group Arrays
 */

public function array_group_by(array $arr, $key): array {
    // https://github.com/jakezatecky/array_group_by

    if (!is_string($key) && !is_int($key) && !is_float($key) && !is_callable($key)) {
        trigger_error('array_group_by(): The key should be a string, an integer, a float, or a function', E_USER_ERROR);
    }
    $isFunction = !is_string($key) && is_callable($key);

    // Load the new array, splitting by the target key
    $grouped = [];
    foreach ($arr as $value) {
        $groupKey = null;
        if ($isFunction) {
            $groupKey = $key($value);
        } else if (is_object($value)) {
            $groupKey = $value->{$key};
        } else {
            $groupKey = $value[$key];
        }
        $grouped[$groupKey][] = $value;
    }

    // Recursively build a nested grouping if more parameters are supplied
    // Each grouped array value is grouped according to the next sequential key
    if (func_num_args() > 2) {
        $args = func_get_args();
        foreach ($grouped as $groupKey => $value) {
            $params = array_merge([$value], array_slice($args, 2, func_num_args()));
            $grouped[$groupKey] = call_user_func_array(array($this, 'array_group_by'), $params);
        }
    }
    return $grouped;
}

/**
 * Sort by Column
 */

public function sort_array(array $arr, $column, $desc = FALSE): array {
    $col = array_column($arr, $column);

    if ( $desc ) {
        array_multisort($col, SORT_DESC, $arr);
    } else {
        array_multisort($col, SORT_ASC, $arr);
    }
    return $arr;
}

/**
 * Resize Image to WebP
 *
 *      $sizes = [
 *          0 => ['width'  => 1920,'height' => 1080],
 *          1 => ['subdir' => 'md','width'=> 1024],
 *          2 => ['subdir' => 'tn','width'=>  512]
 *      ];
 */

public function img_resize($source, $sizes, $destination='images') {

    // Create $img
    $extension = strtolower(pathinfo($source, PATHINFO_EXTENSION));
    $bare_name = pathinfo($source, PATHINFO_FILENAME);
    $base_path = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . $destination . DIRECTORY_SEPARATOR;
    $exif      = @exif_read_data($source);

    switch($extension){
        case 'bmp' : $img = imagecreatefromwbmp($source); break;
        case 'gif' : $img = imagecreatefromgif($source);  break;
        case 'jpg' : $img = imagecreatefromjpeg($source); break;
        case 'jpeg': $img = imagecreatefromjpeg($source); break;
        case 'png' : $img = imagecreatefrompng($source);  break;
        case 'webp': $img = imagecreatefromwebp($source); break;
        default : return "Unsupported picture type!";
    }

    // Fix Orientation
    if( $exif && isset($exif['Orientation']) ) {
        $orientation = $exif['Orientation'];
        switch ($orientation) {
            case 3  : $deg = 180; break;
            case 6  : $deg = 270; break;
            case 8  : $deg = 90;  break;
            default : $deg = 0;   break;
        }
        if ( $deg != 0 ) {$img = imagerotate($img, $deg, 0);}
    }

    // Resize & Save First
    $width  = $sizes[0]['width'];
    $height = $sizes[0]['height'];
    $destination = $base_path . $bare_name . '.webp';

    if ( $width == 'auto' || $height == 'auto') {
        copy($source, $destination);
    } else {
        $img = $this->resizeCropImage($img, $width, $height);
        imagewebp($img, $destination, 75);
    }

    // Resize & Save Smaller Sizes
    unset($sizes[0]);

    foreach ($sizes as $size) {
        $destination = $base_path . $size['subdir'] . DIRECTORY_SEPARATOR . $bare_name . '.webp';

        if ( isset($size['height']) ) {
            $img = $this->resizeCropImage($img, $size['width'], $size['height']); // Changes Aspect Ratio
        } else {
            $img = imagescale($img, $size['width']); // Preserves Aspect Ratio
        }
        imagewebp($img, $destination, 75);
    }

    // Destroy and Return
    imagedestroy($img);

    return $bare_name;
}

/**
 * Resize and Crop image
 */

private function resizeCropImage($img, $width, $height) {
    $source_ratio  = imagesx($img) / imagesy($img);
    $new_ratio     = $width / $height;

    if( $source_ratio <= $new_ratio ) {
        $img    = imagescale($img, $width);
        $crop_y = round((imagesy($img) - $height) / 2);
        $img    = imagecrop($img, ['x' => 0, 'y' => $crop_y, 'width' => $width, 'height' => $height]);
    } else {
        $new_width = round($height * $source_ratio);
        $img       = imagescale($img, $new_width, $height);
        $crop_x    = round((imagesx($img) - $width) / 2);
        $img       = imagecrop($img, ['x' => $crop_x, 'y' => 0, 'width' => $width, 'height' => $height]);
    }
    return $img;
}

/**
 * Get Bare Domain
 */

public function get_domain() {
    return parse_url(base_url())['host'];
}

/**
 * Get Files in Folder (Not Recursively)
 */

public function getfilesInFolder($folder, $sorted = TRUE) {
    $fileList = glob($folder . '/*');

    if ($sorted) {
        usort($fileList, function($a,$b){
            return filemtime($b) - filemtime($a);
        });
    }

    $files = array();

    foreach($fileList as $filename){
        if(is_file($filename)){
            array_push($files, basename($filename));
        }
    }
    return $files;
}

/**
 * Give Array Keys
 */

public function giveArrayKeys($arr, $key1, $key2) {
    $new_array = [];

    foreach ($arr as $key => $value) {
        $item = [$key1 => $key, $key2 => $value];
        array_push($new_array,$item);
    }

    return $new_array;
}

/**
 * Find Photos in HTML Code
 */

public function findPicsInHTML($html) {
    $img_array = array();
    $doc = new \DOMDocument();
    @$doc->loadHTML($html);
    $tags = $doc->getElementsByTagName('img');

    foreach ($tags as $tag) {
       $path = $tag->getAttribute('src');
       array_push($img_array,basename($path));
    }
    return $img_array;
}

/**
 * Generate Random Name withour Extension
 */

public function getRandomName() {
    return time() . '_' . bin2hex(random_bytes(10));
}

/**
 * Generate Random String
 */

function generateRandomString($length = 8) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

/**
 * Sanitize String
 */

public function sanitize($str) {
    $dict = '<>()[]{}^_.,:;!?=~/\&%$€§"\'#*^°´`²³';
    $str  = trim($str);
    $str  = strip_tags($str);
    $str  = str_replace(mb_str_split($dict), '', $str);
    return $str;
}

/**
 * Limit text (Words)
 */

public function limit_text($text, $limit) {
    $words = str_word_count($text, 2);

    if (count($words) <= $limit) {
        return $text;
    }

    $words_limited = array_slice($words, 0, $limit);
    $result = implode(' ', $words_limited);

    // Trim punctuation
    $result = rtrim($result, '.,;:?!') . ' ...';

    return $result;
}
/**
 * Generate CSV File from Array
 */

public function genCsvFile($arr, $divider=';') {
    if( empty($arr) ) {return;}

    $filename = $this->getRandomName() . '.csv';
    $path = FCPATH . 'exports' . DIRECTORY_SEPARATOR . $filename;

    $f = fopen($path, "w");

    // add BOM to fix UTF-8 in Excel
    fputs($f, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

    // Add keys as Header
    $keys = array_keys($arr[0]);
    fputcsv($f, $keys, $divider);

    foreach ($arr as $row) {
        fputcsv($f, $row, $divider);
    }
    return $filename;
}

} // END Class