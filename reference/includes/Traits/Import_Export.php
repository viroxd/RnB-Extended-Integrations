<?php

namespace REDQ_RnB\Traits;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

trait Import_Export {
    public function export_products() {
        $products = get_posts([
            'post_type' => 'product',
            'posts_per_page' => -1,
        ]);
    }
    public function get_all_rnb_settings(){
        $options = wp_load_alloptions(true);
        $rnb_options = array_filter(
            $options,
            static function ($key) {
                return strpos($key, 'rnb') === 0;
            },
            ARRAY_FILTER_USE_KEY
        );
        return $rnb_options;
    }
    public function export_settings_json(){
        $rnb_options = $this->get_all_rnb_settings();
        $json_data = json_encode($rnb_options);
        return $json_data;
    }
}