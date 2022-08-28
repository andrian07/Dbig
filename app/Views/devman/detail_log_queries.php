<html>

<head>
    <title>Detail Log Queries</title>
    <!-- highlight.js -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/styles/agate.min.css">
    <style>
        * {
            padding: 0px;
            margin: 0px;
        }

        .container {
            width: 100%;
        }
    </style>
</head>

<body>
    <?php
    $logs = '';
    $num = 1;
    foreach ($details as $row) {
        $logs .= "-- QUERY :  $num  \r\n" . $row['query_text'] . "\r\n\r\n";
        $num++;
    }
    ?>
    <div class="container">
        <pre><code class="language-sql"><?= $logs ?></code></pre>
    </div>
    <!-- highlight.js -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/highlight.min.js"></script>
    <script>
        hljs.highlightAll();
    </script>
</body>

</html>