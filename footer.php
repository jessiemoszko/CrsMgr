<script>
    function toggleHamburger(x) {
        x.classList.toggle("change");
        const link = document.getElementById("header-link");
        link.style.display = (link.style.display === "block") ? "none" : "block";
        link.style.textAlign = "center";
    }
</script>