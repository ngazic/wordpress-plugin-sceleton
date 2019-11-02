<h1>CPT manager</h1>
<?php settings_errors(); ?>
<?php
        settings_fields('pm_plugin_cpt_settings');
        do_settings_sections('pm_cpt');
        submit_button();
        ?>
    </form>