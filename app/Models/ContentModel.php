<?php namespace App\Models;

use CodeIgniter\Model;
use Config\Settings;
use App\Libraries\SystemCore;

class ContentModel extends Model {

    protected $db;
    protected $lang;

    public function __construct() {
        $this->db   = \Config\Database::connect();
        $this->lang = $this->setting('lang_code');
    }

/**
 * Custom function to get setting value
 * --- Usage:  $this->setting('lang_code')
 */

private function setting($key) {
    $config = new Settings();
    return $config->getSetting($key);
}

/**
 * Custom function to get Tier
 */

private function getTier() {
    $session = \Config\Services::session();
    return $session->has('tier') ? $session->get('tier') : 0;
}

/**
 * Get Posts
 */

public function getPosts(
    int $amount = PHP_INT_MAX,
    int $topic_id = 0,
    int $user_id = 0,
    int $page = 1,
    int $exclude = 0,
    bool $pagination = true,
    bool $rand = false,
    bool $featured = false,
    bool $unlisted = false
) {
    $tier = $this->getTier();
    $builder = $this->db->table('posts');

    // Select fields
    $builder->select('id, title, subtitle, photo');
    $builder->select('DATE_FORMAT(created, "%b %d, %Y", "'.$this->lang.'") AS f_created', false);

    // Where conditions
    $builder->where('status', 1)
            ->where('accessibility <=', $tier);

    if ( !empty($topic_id) ) {
        $builder->where('topic_id', $topic_id);
    }
    if ( !empty($user_id) ) {
        $builder->where('user_id', $user_id);
    }
    if ( !empty($exclude) ) {
        $builder->where('id !=', $exclude);
    }
    if ($featured) {
        $builder->where('featured', 1);
    }
    if ($unlisted) {
        $builder->where('unlisted !=', 1);
    }

    // Builder for pagination
    $totalRecordsQuery = $pagination ? clone $builder : null;

    // Order by conditions
    if ( $rand ) {
        $builder->orderBy('RAND()');
    } else {
        $builder->orderBy('created', 'DESC');
    }

    // Limit
    $offset = ($page - 1) * $amount;
    $builder->limit($amount, $offset);

    $postData['posts'] = $builder->get()->getResultArray();

    // Pagination
    if ( $pagination ) {
        $totalRecords = $totalRecordsQuery->countAllResults();

        // Prepare response data
        $postData = array_merge($postData, [
            'post_cur_min' => min(($page - 1) * $amount + 1, $totalRecords),
            'post_cur_max' => min($page * $amount, $totalRecords),
            'post_max'     => $totalRecords,
            'page_cur'     => $page,
            'page_max'     => max(ceil($totalRecords / $amount), 1),
            'prev'         => $page - 1,
            'next'         => $page + 1
        ]);
    }

    return $postData;
}

/**
 * Get Single Post
 */

public function getSinglePost($id) {
    $tier = $this->getTier();

    $q = "  SELECT
                p.*,
                DATE_FORMAT(p.created, '%b %d, %Y', '$this->lang') as f_created,
                u.first_name as author,
                t.id as topic_id,
                t.title as topic,
                t.slug as topic_slug,
                u.author as user_handle
            FROM posts p
            INNER JOIN users u On p.user_id = u.id
            INNER JOIN topics t On p.topic_id = t.id
            WHERE
                p.id = $id
                AND p.accessibility <= $tier
    ";
    $result = $this->db->query($q)->getRowArray();
    return $result;
}

/**
 * Get Ranking Posts
 */

public function getRankingPosts(
    int $amount = PHP_INT_MAX,
    string $type = 'popular',
    int $page = 1,
    bool $pagination = true
) {
    $tier = $this->getTier();
    $builder = $this->db->table('posts p');

    // Select fields
    $builder->select('p.id, p.title, p.subtitle, p.photo');
    $builder->select('DATE_FORMAT(p.created, "%b %d, %Y", "'.$this->lang.'") AS f_created', false);

    // Where conditions
    $builder->where('status', 1)
            ->where('accessibility <=', $tier);

    // Types
    switch ($type) {
        case 'popular':
            $builder->join('stats_popular s', 's.post_id = p.id', 'inner');
            $totalRecordsQuery = $pagination ? clone $builder : null;
            $builder->orderBy('s.hits_per_day', 'DESC');
            break;
        case 'trending':
            $hours = $this->setting('trending_range');
            $builder->join('stats_trending s', 's.post_id = p.id', 'inner');
            $builder->where('s.created >=', 'DATE_SUB(NOW(), INTERVAL ' . $hours . ' HOUR)', false);
            $builder->groupBy('s.post_id');
            $totalRecordsQuery = $pagination ? clone $builder : null;
            $builder->orderBy('COUNT(s.id)', 'DESC');
            break;
    }

    // Limit
    $offset = ($page - 1) * $amount;
    $builder->limit($amount, $offset);

    $postData['posts'] = $builder->get()->getResultArray();

    // Pagination
    if ( $pagination ) {
        $totalRecords = $totalRecordsQuery->countAllResults();

        // Prepare response data
        $postData = array_merge($postData, [
            'post_cur_min' => min(($page - 1) * $amount + 1, $totalRecords),
            'post_cur_max' => min($page * $amount, $totalRecords),
            'post_max'     => $totalRecords,
            'page_cur'     => $page,
            'page_max'     => max(ceil($totalRecords / $amount), 1),
            'prev'         => $page - 1,
            'next'         => $page + 1
        ]);
    }

    return $postData;
}

/**
 * Get Pages List
 */

public function getPagesList() {
    $tier = $this->getTier();
    $results = $this->db->table('pages p')
                        ->select('s.title AS section, s.slug AS s_slug, p.label, p.slug, p.icon')
                        ->join('sections s', 's.id = p.section_id', 'inner')
                        ->where('p.status', 1)
                        ->where('p.accessibility', 0)
                        ->where('s.id !=', 1)
                        ->orderBy('s.position ASC, p.position ASC')
                        ->get()->getResultArray();
    $core = new SystemCore();
    $grouped_results =  $core->array_group_by($results, 'section');

    // Define the new entries to be inserted in the corresponding sections
    // $append = [
    //     [
    //         'section' => 'Πληροφορίες',
    //         'label'   => 'Blog',
    //         'slug'    => 'blog',
    //         'url'     => site_url('blog'),
    //         'icon'    => 'blog',
    //         'position'=> 1
    //     ],
    //     [
    //         'section' => 'Βιβλιοθήκη',
    //         'label'   => 'Downloads',
    //         'slug'    => 'downloads',
    //         'url'     => site_url('downloads'),
    //         'icon'    => 'download',
    //         'position'=> 1
    //     ]
    // ];

    // // Use array_map to apply the addition of new entries to each section
    // $addNewEntries = function ($section) use ($append) {
    //     foreach ($append as $item) {
    //         if ($section[0]['section'] === $item['section']) {
    //             array_splice($section, $item['position'], 0, [$item]);
    //         }
    //     }
    //     return $section;
    // };

    // // Use array_map to apply the callback function to each section
    // $grouped_results = array_map($addNewEntries, $grouped_results);
    return $grouped_results;
}

/**
 * Get Pages
 */

public function getPages(
    bool $featured = false,
    string $section = null,
    int $section_id = 0,
    int $amount = PHP_INT_MAX,
    int $exclude = 0
) {

    // Select fields
    $builder = $this->db->table('pages p');
    $builder->select('p.title, p.subtitle, p.photo, p.label, p.slug, s.slug AS s_slug');
    $builder->select('DATE_FORMAT(p.created, "%b %d, %Y", "'.$this->lang.'") AS f_created', false);
    $builder->join('sections s', 's.id = p.section_id', 'inner');

    // Where conditions
    $builder->where('p.status', 1)
            ->where('p.accessibility', 0)
            ->where('s.id !=', 1);

    if (!empty($section)) {
        $builder->where('s.slug', $section);
    }

    if (!empty($section_id)) {
        $builder->where('s.id', $section_id);
    }

    if (!empty($exclude)) {
        $builder->where('p.id !=', $exclude);
    }
    if ($featured) {
        $builder->where('p.featured', 1);
        $builder->orderBy('p.position ASC');
    }

    // Order & Limit
    $builder->orderBy('p.created', 'DESC');
    $builder->limit($amount);

    $results = $builder->get()->getResultArray();
    return $results;
}

/**
 * Get Single Page
 */

public function getSinglePage($slug) {
    $id = $this->getIdFromSlug($slug, 'pages');

    if ( empty($id) ) {
        return null;
    }

    $q = "  SELECT
                p.*,
                DATE_FORMAT(p.created, '%b %d, %Y', '$this->lang') as formatted_date,
                u.first_name as author,
                s.title as section,
                s.id as section_id,
                s.slug as s_slug
            FROM pages p
            INNER JOIN users u On u.id = p.user_id
            INNER JOIN sections s On s.id = p.section_id
            WHERE p.id = $id
    ";
    $result = $this->db->query($q)->getRowArray();
    return $result;
}

/**
 * Get Id from Slug
 */

public function getIdFromSlug($slug, $table) {
    $seekData = $this->db->table($table)
                         ->select('id')
                         ->where('slug', $slug)
                         ->get()
                         ->getRow();
    return $seekData ? $seekData->id : null;
}

/**
 * Get Title from id
 */

public function getTitleFromId($id, $table) {
    $seekData = $this->db->table($table)
                         ->select('title')
                         ->where('id', $id)
                         ->get()
                         ->getRow();
    return $seekData ? $seekData->title : null;
}

/**
 * Get User id from Handle
 */

public function getIdFromHandle($handle) {
    $seekData = $this->db->table('users')
                         ->select('id')
                         ->where('author', $handle)
                         ->get()
                         ->getRow();
    return $seekData ? $seekData->id : null;
}

/**
 * Get Full Name from User id
 */

public function getFullnameFromId($user_id) {
    $seekData = $this->db->table('users')
                         // ->select('CONCAT(first_name, " ", last_name) as fullname')
                         ->select('first_name as fullname')
                         ->where('id', $user_id)
                         ->get()
                         ->getRow();
    return $seekData ? $seekData->fullname : null;
}

/**
 * Search Results
 */

public function getSearchResults($term) {
    $tier = $this->getTier();

    // Validate and sanitize the term input
    if ( mb_strlen($term) < 4 ) {
        return ['posts' => []];
    }

    $q = "  (
                SELECT
                    p.id,
                    p.title,
                    p.subtitle,
                    p.photo,
                    NULL AS slug,
                    NULL AS s_slug,
                    DATE_FORMAT(p.created, '%b %d, %Y', '$this->lang') AS f_created,
                    MATCH (p.title, p.subtitle, p.body) AGAINST ('$term') AS relevance,
                    'post' AS content
                FROM posts p
                WHERE
                    p.status = 1
                    AND p.accessibility <= $tier
                    AND MATCH (p.title, p.subtitle, p.body) AGAINST ('$term')
            ) UNION (
                SELECT
                    pg.id,
                    pg.title,
                    pg.subtitle,
                    pg.photo,
                    pg.slug,
                    s.slug AS s_slug,
                    DATE_FORMAT(pg.created, '%b %d, %Y', '$this->lang') AS f_created,
                    MATCH (pg.title, pg.subtitle, pg.body) AGAINST ('$term') AS relevance,
                    'page' AS content
                FROM pages pg
                INNER JOIN sections s ON s.id = pg.section_id
                WHERE
                    pg.status = 1
                    AND pg.accessibility <= $tier
                    AND MATCH (pg.title, pg.subtitle, pg.body) AGAINST ('$term')
            )
            ORDER BY relevance DESC
            LIMIT 100";

    $postData['posts'] = $this->db->query($q)->getResultArray();
    return $postData;
}

/**
 * Get Block Group
 */

public function getBlocks($groups = []) {
    $in_groups = "'" . implode("','", $groups) . "'";
    $core = new SystemCore();

    $q = "  SELECT *
            FROM blocks
            WHERE block_group IN($in_groups)
            ORDER BY block_group ASC, alias ASC
    ";

    $results = $this->db->query($q)->getResultArray();
    $grouped = $core->array_group_by($results, 'block_group', 'alias');
    return $grouped;
}

/**
 * Get Socials List
 */

public function getSocialsList() {
    $results = $this->db->table('settings')
                        ->select('setting, value')
                        ->where('setting_group', 'social_media')
                        ->where('value !=', '')
                        ->orderBy('position', 'ASC')
                        ->get()
                        ->getResultArray();

    // Add Contact Icon
    $results[] = [
        'setting' => 'contact',
        'value'   => site_url('info/contact')
    ];

    return $results;
 }

 /**
 * Get Socials List
 */

public function getTopicsList() {
    $results = $this->db->table('topics')
                        ->select('title, slug, posts')
                        ->where('id !=', 1)
                        ->where('posts !=', 0)
                        ->orderBy('posts', 'DESC')
                        ->get()
                        ->getResultArray();
    return $results;
}


} // END Class