<?php
add_action("naver_search", function () {
    ?>
    <meta name="naver-site-verification" content="66beb8ead4acfddf953df368f02eb217e6d25fea" />
    <script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
    <script type="text/javascript">
        if(!wcs_add) var wcs_add = {};
        wcs_add["wa"] = "7217951aa82ea4";
        if(window.wcs) {
            wcs_do();
        }
    </script>
<?php
}, 0);
