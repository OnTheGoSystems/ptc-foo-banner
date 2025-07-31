document.addEventListener( 'DOMContentLoaded', () => {
    const saveBtn = document.getElementById( 'otgs-fb-save' );

    saveBtn.addEventListener( 'click', e => {
        if ( ! confirm( 'Saving will reset the active time count.' ) ) {
            e.preventDefault();
        }
    } );
} )