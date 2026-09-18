<?php
/**
 * Global site footer.
 *
 * @package Tora_Tora
 */
?>
    <footer class="footer-strip">
        <span><?php echo esc_html(get_theme_mod('tora_footer', 'Reborn Consultancy © ' . gmdate('Y'))); ?></span>
    </footer>
</div>
<?php if (is_front_page() && is_user_logged_in() && current_user_can('edit_posts')) : ?>
<script type="application/json" id="tora-tora-panel-edits"><?php echo wp_json_encode(tora_tora_panel_edit_targets()); ?></script>
<?php endif; ?>
<?php tora_tora_render_document_footer(); ?>
</body>
</html>

