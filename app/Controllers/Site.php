<?php namespace App\Controllers;

// use App\Models\DownloadModel;
// use App\Models\StatsModel;

class Site extends BaseController {

    // private $download;
    // private $stats;

    // function __construct() {
    //     $this->download = new DownloadModel();
    //     $this->stats    = new StatsModel();
    // }

/**
 * Frontpage
 */

public function index() {
    $data = array_merge($this->data, [
        'nav_style' => 'dynamic'
    ]);

	echo view('site/front', $data);
}

} // END Class
