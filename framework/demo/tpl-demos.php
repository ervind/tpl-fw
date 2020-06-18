<?php // Instances of all options for testing purposes


// Register a settings page first
require_once TPL_ROOT_DIR . 'demo/primary/settings-pages.php';

// Then connect at least 1 section to it
require_once TPL_ROOT_DIR . 'demo/primary/sections.php';

// Then add options to these sections
require_once TPL_ROOT_DIR . 'demo/primary/simple-options.php';
require_once TPL_ROOT_DIR . 'demo/primary/repeater-options.php';
require_once TPL_ROOT_DIR . 'demo/primary/combined-options.php';
require_once TPL_ROOT_DIR . 'demo/primary/combined-repeater-options.php';
require_once TPL_ROOT_DIR . 'demo/primary/conditions.php';


// Handling post sections (1 section = 1 metabox)
require_once TPL_ROOT_DIR . 'demo/metabox/metabox-sections.php';

// Adding options to them
require_once TPL_ROOT_DIR . 'demo/metabox/metabox-simple-options.php';
require_once TPL_ROOT_DIR . 'demo/metabox/metabox-repeater-options.php';
require_once TPL_ROOT_DIR . 'demo/metabox/metabox-combined-options.php';
require_once TPL_ROOT_DIR . 'demo/metabox/metabox-combined-repeater-options.php';
require_once TPL_ROOT_DIR . 'demo/metabox/conditions.php';


// Tesing error handling
// require_once TPL_ROOT_DIR . 'demo/primary/sections-error.php';
// require_once TPL_ROOT_DIR . 'demo/primary/options-error.php';


// Shortcodes for testing in the front end
require_once TPL_ROOT_DIR . 'demo/demo-shortcodes.php';
