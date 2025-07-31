<!-- Modal Portal - wird immer am Ende des body gerendert -->
<div id="modal-portal" style="position: relative; z-index: 2147483647;"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Stelle sicher, dass das Modal-Portal am Ende des body ist
    const portal = document.getElementById('modal-portal');
    if (portal && portal.parentNode !== document.body) {
        document.body.appendChild(portal);
    }
});
</script>
