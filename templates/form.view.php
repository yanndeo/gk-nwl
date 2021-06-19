<form id="nwl-form" method="post" novalidate data-action="<?php echo \App\shortcode\Index::WP_PHP_AJAX_ACTION ;?>" >
    <label>Inscrivez-vous à notre newsletter (short code) </label>
    <div class="nwl-form">
        <div class="form-group nwl-form-input-area elt">
            <input required="required" id="nwl-email-input" name="email" type="email" placeholder="Votre e-mail" class="nwl-form-input">
        </div>
        <div class="nwl-form-btn-area elt">
            <button id="nwl-form-btn" class="nwl-form-btn" type="submit">je m'inscris</button>
        </div>
    </div>
    <small id="nwl-validation-form-message"></small>
</form>
