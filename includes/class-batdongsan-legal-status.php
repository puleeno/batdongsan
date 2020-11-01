<?php
use WordLand\PostTypes;

class Datdongsan_Legal_Status {
    const LEGAL_NAME = 'property_status';

    public function __construct() {
        add_action('init', array($this, 'registerTaxonomies'));
        add_filter(
            'wordland_property_supported_json_fields',
            array($this, 'appendLegalJsonToProperty'),
            10,
            2
        );
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

    public function appendLegalToProperty($data, $property) {
        if (isset($property->legal_status)) {
            $data['legal_status'] = $property->legal_status;
        }
        return $data;
    }
}

new Datdongsan_Legal_Status();
