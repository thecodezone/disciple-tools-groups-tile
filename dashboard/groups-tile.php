<?php

/**
 * Your custom tile class
 */
class DT_Groups_Dashboard_Tile extends DT_Dashboard_Tile {
    public function __construct( $handle, $label, $params = [] ) {
        parent::__construct( $handle, $label, $params );
        add_filter( 'script_loader_tag', [ $this, 'defer_alpine' ], 10, 3 );
    }

    /**
     * Register any assets the tile needs or do anything else needed on registration.
     * @return mixed
     */
    public function setup() {
        wp_enqueue_script( 'alpine.js', 'https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js', [], '3.10.2', true );
        wp_enqueue_script( 'groups-tile-health-circle', plugin_dir_url( __FILE__ ) . '../src/health-circle.js', [], filemtime( plugin_dir_path( __FILE__ ) . '../src/health-circle.js' ) );
        wp_localize_script( 'groups-tile-health-circle', 'churchHealthSettings', [
            'post_settings' => DT_Posts::get_post_settings( 'groups' ),
        ] );
        wp_enqueue_script( 'groups-tile', plugin_dir_url( __FILE__ ) . '../src/groups-tile.js', [ 'alpine.js', 'groups-tile-health-circle' ], filemtime( plugin_dir_path( __FILE__ ) . '../src/groups-tile.js' ) );
        wp_enqueue_style( 'groups-tile', plugin_dir_url( __FILE__ ) . '../src/groups-tile.css', [], filemtime( plugin_dir_path( __FILE__ ) . '../src/groups-tile.css' ) );
    }

    public function defer_alpine( $tag, $handle ) {

        if ( $handle !== 'alpine.js' ) {
            return $tag;
        }

        return str_replace( ' src', ' defer src', $tag );
    }

    /**
     * Render the tile
     */
    public function render() {
        //We only want to list 6 groups.
        $groups = DT_Posts::list_posts( 'groups', [], true );
        $groups['posts'] = array_slice( $groups['posts'], 0, 6 );

        //Post type labels
        $group_label = DT_Posts::get_label_for_post_type( 'groups', true );
        $user_label = DT_Posts::get_label_for_post_type( 'users', true );
        $groups_label = DT_Posts::get_label_for_post_type( 'groups' );
        $leaders_label = DT_Posts::get_post_field_settings( 'groups' )['leaders']['name'];

        $user = [
            'ID'   => get_current_user_id(),
            'name' => dt_get_user_display_name( get_current_user_id() ),
        ];
        $leader_label = DT_Posts::get_post_field_settings( 'groups' )['leaders']['name'];

        //The tile data
        $tile = $this;

        require( plugin_dir_path( __FILE__ ) . '../templates/groups-tile.php' );
    }
}

if ( current_user_can( 'access_groups' ) ) {
    DT_Dashboard_Plugin_Tiles::instance()->register(
        new DT_Groups_Dashboard_Tile( 'groups', __( 'Groups', 'disciple-tools-groups-tile' ), [ 'priority' => 1, 'span' => 1 ] )
    );
}
