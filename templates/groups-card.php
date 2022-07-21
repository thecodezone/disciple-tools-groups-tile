<?php
$props = wp_json_encode( [
    'user' => $user,
    'groups' => $groups,
    'card'   => $card,
], JSON_HEX_APOS );
?>


<div class="card-header">
    <?php echo esc_html( $card->label ) ?>
    <a href="/groups/new" title="<?php echo __( 'New ', 'disciple_tools_groups_card' ) . esc_html( $group_label ) ?>">
        <span class="add-group"> + </span>
    </a>
</div>

<div class="card-body card-body--scroll"
     x-data='groups_card(<?php echo $props ?>)'>

    <?php include( 'groups.php' ); ?>
    <?php include( 'group.php' ); ?>
</div>
