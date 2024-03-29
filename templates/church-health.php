<?php
$group_preferences = dt_get_option( 'group_preferences' );
$fields = DT_Posts::get_post_field_settings( 'groups' );
$group_label = esc_html( DT_Posts::get_label_for_post_type( 'groups', true ) );

//<!-- Health Metrics-->
if ( empty( $group_preferences['church_metrics'] ) ) {
    return;
}
?>
<div class="group__church-health">
    <h3><?php echo esc_html( $group_label  . __( ' Health', 'disciple_tools_groups_tile' ) ); ?></h3>

    <div class="grid-x">
        <div style="margin-right:auto; margin-left:auto;min-height:225px">
            <div class="health-circle"
                 id="health-items-container">
                <div class="health-grid">
                    <?php $fields = DT_Posts::get_post_field_settings( 'groups' );
                    if ( !empty( $fields['health_metrics']['default'] ) ): ?>
                        <?php foreach ( $fields['health_metrics']['default'] as $key => $option ) : ?>
                            <?php if ( $key !== 'church_commitment' ) : ?>
                                <?php
                                if ( empty( $option['icon'] ) || !isset( $option['icon'] ) ) {
                                    $option['icon'] = get_template_directory_uri() . '/dt-assets/images/groups/missing.svg';
                                }
                                if ( !isset( $option['description'] ) ) {
                                    $option['description'] = '';
                                }
                                ?>
                                <div class="health-item"
                                     id="icon_<?php echo esc_attr( strtolower( $key ) ) ?>"
                                     title="<?php echo esc_attr( $option['description'] ); ?>">
                                    <img src="<?php echo esc_attr( $option['icon'] ); ?>">
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

