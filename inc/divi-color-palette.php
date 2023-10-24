<?php 

if (!defined('ABSPATH')) {
    return;
}

add_action('wp_head', function() {
    $divi_colors = get_option('et_divi');

    if (!$divi_colors) {
        return;
    }
    
    $colors = $divi_colors["divi_color_palette"];
    
    $colors = explode("|", $colors);
    $css = ":root {";
    foreach ($colors as $key => $color) {
        $color_key = $key + 1;
        $css .= "--wp-preset-divi-color-$color_key: $color;";
    }

    $css .= "}";

    echo "<style>";
    echo $css;
    echo "</style>";
});