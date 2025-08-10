<?php
    ob_start();
?>
<title>Browsing The Website</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<style>
.container {
    max-width: 100%;
    width: 1000px;
    margin: 20px auto;

}

.submit {
    margin-top: 10px;
}

.main h1 {
    font-weight: 500;
}
</style>
<?php
    require "./nav.php";
?>
<div class="container">
    <h2 align="center">Welcome in Our Website, Browsing Section</h2>
</div>
<?php
    ob_end_flush();
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
</script>