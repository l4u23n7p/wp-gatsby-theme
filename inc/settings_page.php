<?php
if ( ! current_user_can('manage_options') ) {
    return;
}

if ( isset( $_GET['settings-updated'] ) ) {
    add_settings_error( 'wp_gatsby_theme_messages', 'wp_gatsby_theme_settings_update', __( 'Settings Saved', 'wp-gatsby-theme' ), 'updated' );
}
?>
<div>
    <h2>WP Gatsby Theme - Settings</h2>
    <?php
    settings_errors( 'wp_gatsby_theme_messages' );
    
    $status_img = get_option( 'wp_gatsby_theme_deploy_settings' )['status_image'];
    $status_link = get_option( 'wp_gatsby_theme_deploy_settings' )['status_link'];
    ?>
    <?php if ( isset( $status_img ) ): ?>
        <div>
            <h3>Site Status</h3>
            <?php if ( isset( $status_link ) ): ?>
                <a href="<?php echo $status_link; ?>"
                    target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo $status_img; ?>" />
                </a>
            <?php else: ?>
                    <img src="<?php echo $status_img; ?>" />
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <form action="options.php" method="post">
        <?php
        settings_fields( 'theme-settings' );
        do_settings_sections( 'theme-settings' );
        submit_button();
        ?>
    </form>
</div>

<script type="text/javascript">
    function trigger_manual_deploy() {
        var data = {
            action: 'deploy-theme',
            _nonce: '<?php echo wp_create_nonce( "manual-deploy" ); ?>'
        };

        jQuery.post(ajaxurl, data, function(response) {
            console.log(response);
            <?php
            if ( ! WP_DEBUG ) {
                echo "location.reload();";
            }
            ?>
        });
    }
</script>