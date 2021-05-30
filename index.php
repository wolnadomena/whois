<?php
/*
 * https://whois.wolnadomena.pl/index.php?domain=softreck.com
 * http://localhost:8080/index.php?domain=softreck.com
 */
require("post.php");
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Whois.WolnaDomena.pl - Check Your domains list</title>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="style.css" rel="stylesheet"/>

</head>
<body>
<div class="container box">

    <h2 class="center">Whois.WolnaDomena.pl</h2>
    <p class="center">More Than WHOIS...</p>
    <hr>
    <form method="post">
        <div class="form-group">
            <label>Enter domain names, line by line</label>
            <br>
            <textarea name="domains" cols="55" rows="20"><?php echo $_POST["domains"] ?></textarea>
        </div>
        <br/>
        <input type="submit" name="whois" value="WHOIS" class="btn btn-info btn-lg"/>
    </form>
    <br/>
    <?php
    global $html;
    echo $html;
    ?>
</div>
<div style="clear:both"></div>
<br/>
<hr>
<div class="center">

    <div>
        DEV:
        <a href="https://github.com/wolnadomena/www" target='_blank'>source code</a>
        |
        <a href="https://whois.wolnadomena.pl/index.php?domains=softreck.com" target='_blank'> production </a>
        |
        <a href="http://localhost:8080/index.php?domains=softreck.com" target='_blank'> localhost </a>

    </div>

    <div>
        Supported by:
        <a href="https://softreck.com" target='_blank'>softreck.com</a>
        |
        <a href="https://softreck.pl" target='_blank'>softreck.pl</a>
        |
        <a href="https://www.webstream.dev" target='_blank'>webstream.dev</a>
        |
        <a href="https://www.apifunc.com" target='_blank'>apifunc.com</a>

    </div>
</div>



<script>
    $('a.whois').each(function () {
        var atext = $(this);
        var url = atext.attr('href');
        var jqxhr = $.ajax(url)
            .done(function (result) {
                var info = result.whois.domain;
                console.log(info);
                // var whois = Object.keys(info).join(',');
                var whois = '';
                if ("undefined" !== typeof result.whois.domain.name) whois += result.whois.domain.name + '<br>';
                if ("undefined" !== typeof result.whois.domain.expires) whois += result.whois.domain.expires + '<br>';
                if ("undefined" !== typeof result.whois.domain.created) whois += result.whois.domain.created + '<br>';
                if ("undefined" !== typeof result.whois.domain.status) whois += Object.values(result.whois.domain.status).join('<br>');
                if ("undefined" !== typeof result.whois.domain.sponsor)  whois += Object.values(result.whois.domain.sponsor).join('<br>');
                console.log(whois);

                atext.addClass("active");
                atext.html(whois);
            });
    });
</script>

</body>
</html>
