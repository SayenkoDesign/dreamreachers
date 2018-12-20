<?php

function psc_map_get_markers() {
    $map = new \PSC\Map;  
    return $map->get_markers();
}

function psc_map_current_marker_id() {
    $map = new \PSC\Map;  
    return $map->current_marker_ID;
}

function psc_map_get_legend() {
    $map = new \PSC\Map;  
    return $map->get_legend();
}

function psc_get_locations() {
    $map = new \PSC\Locations;   
    return $map->get_locations(); 
}

function psc_get_locations_menu() {
    $map = new \PSC\Locations;   
    return $map->get_menu(); 
}