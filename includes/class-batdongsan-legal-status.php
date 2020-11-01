<?php
use WordLand\PostTypes;

class Datdongsan_Legal_Status {
    public function __construct() {
        add_action('init', array($this, 'registerTaxonomies'));
    }

    public function registerTaxonomies() {
        $labels= array(
            'name' => __('Pháp lý', 'batdongsan'),
        );
        $args = array(
            'labels' => $labels,
        );
        register_taxonomy('property_status', PostTypes::get(), apply_filters(
            'batdongsan_legal_args',
            $args
        ));
    }
}

new Datdongsan_Legal_Status();
