<footer id="footer">
        Version <?php echo DB_VERSION ?>
</footer>

<script type="text/javascript">
    // Überlappung vom Body mit Footer verhindern
    document.getElementById("dbaf-main-div").style.marginBottom = document.getElementById("footer").clientHeight + "px";
</script>