const { __ } = wp.i18n;

document.addEventListener( 'DOMContentLoaded', () => {
    const saveBtn = document.getElementById( 'otgs-fb-save' );

    saveBtn.addEventListener( 'click', e => {
        if ( ! confirm( __( 'Saving will reset the active time count.', 'otgs-fb' ) ) ) {
            e.preventDefault();
        }
    } );
} )