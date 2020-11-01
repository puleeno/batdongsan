<?php
use WordLand\PostTypes;

class Datdongsan_Legal_Status {
    const LEGAL_NAME = 'property_status';

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
        register_taxonomy(static::LEGAL_NAME, PostTypes::get(), apply_filters(
            'batdongsan_legal_args',
            $args
        ));
    }
}

new Datdongsan_Legal_Status();
