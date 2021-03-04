<?php
class Batdongsan_Integration_Spreadsheet_Importer {
    public function __construct() {
        add_action('wordland_spreadsheet_importer_init', array($this, 'create_batdongsan_import_data'));
    }


    public function create_batdongsan_import_data() {
        add_filter('wordland_spreadsheet_importer_set_legal_status_data', array($this, 'clone_value'), 10, 3);
        add_action('wordland_spreadsheet_import_property', array($this, 'save_batdongsan_data'), 10, 2);
    }

    public function clone_value($pre, $value, $current_row) {
        return trim($value);
    }

    public function save_batdongsan_data($property_id, $property_data) {
        $legal_status = apply_filters(
            'batdongsan_spreadsheet_importer_legal_status',
            $property_data->legal_status,
            $property_data
        );

        if ($legal_status) {
            $legal_term = term_exists($legal_status, Datdongsan_Legal_Status::LEGAL_NAME);
            if (!$legal_term) {
                $legal_term = wp_insert_term($legal_status, Datdongsan_Legal_Status::LEGAL_NAME);
            }

            if (!is_wp_error($legal_term) && $legal_term) {
                wp_set_post_terms(
                    $property_id,
                    array(intval($legal_term['term_id'])),
                    Datdongsan_Legal_Status::LEGAL_NAME,
                    false
                );
            }
        }
    }
}

new Batdongsan_Integration_Spreadsheet_Importer();
