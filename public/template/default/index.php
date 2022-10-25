<html lang="en">

<head>
    <link rel="icon" href="<?php echo $this->_dirImg ?>favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo $this->_dirImg ?>favicon.png" type="image/x-icon">
    <base href="/">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@500&display=swap" rel="stylesheet">

    <?php echo $this->_metaHTTP; ?>
    <?php echo $this->_metaName; ?>
    <?php echo $this->_title; ?>
    <?php echo $this->_cssFiles; ?>
</head>

<body style="overflow: auto;">

    <!-- header start -->
    <?php require_once 'html/header.php' ?>
    <!-- header end -->

    <!-- Home slider -->

    <!-- Home slider end -->

    <!-- Top Collection -->
    <!-- Title-->
    <!-- Product slider -->
    <?php
    require_once APPLICATION_PATH . $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php';
    ?>
    <!-- footer -->

    <?php require_once 'html/footer.php' ?>
    <!-- tap to top end -->



    <?php echo $this->_jsFiles; ?>

    <script>
        function openSearch() {
            document.getElementById("search-overlay").style.display = "block";
            document.getElementById("search-input").focus();
        }

        function closeSearch() {
            document.getElementById("search-overlay").style.display = "none";
        }
    </script>


</body>

</html>