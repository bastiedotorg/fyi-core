<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */

const PAGE_CONFIGURATION = array(
    "withdraw_limit" => 10,
    "withdraw_subject" => "Auszahlung",
    "withdraw_subject_revert" => "Rückbuchung Auszahlung",
);

const HOOK_CONFIGURATION = array(
    ['point' => 'BOOK_FROM', 'class' => 'PluginAP'],
);

const CUNEROS_CONFIGURATION = array(
    "api_key" => "",
    "project_id" => 0,
);

const DB_CONFIGURATION = array();
