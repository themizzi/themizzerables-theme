<?php
$color_scheme = twentyfifteen_get_color_scheme();
$default_color_hex = $color_scheme[4];
$default_color = twentyfifteen_hex2rgb( $default_color_hex );
$default_color_rgb = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.1)', $default_color );
$border_color_hex = get_theme_mod( 'sidebar_textcolor', $default_color_hex );
$border_color = twentyfifteen_hex2rgb( $border_color_hex );
$border_color_rgb = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.1)', $border_color );
$css = <<<CSS
ul.gigpress-listing {
    list-style-type: none;
    margin-left: 0;
}

aside ul.gigpress-listing li {
    border-top: 1px solid {$default_color_rgb};
    margin-bottom: .25em;
    padding-top: .25em;
}

aside ul.gigpress-listing {
    border-bottom: 1px solid {$default_color_rgb};
}

@media screen and (min-width: 59.6875em) {
    aside ul.gigpress-listing li {
        border-top: 1px solid {$border_color_rgb};
    }

    aside ul.gigpress-listing {
        border-bottom: 1px solid {$border_color_rgb};
    }
}
CSS;
return $css;