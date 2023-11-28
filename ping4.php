<?php
$status = '';
$host = '';
$pingResults = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form submitted, process the input
    $host = isset($_POST['host']) ? $_POST['host'] : '';

    if ($host !== '') {
        $port = 80;
        $waitTimeoutInSeconds = 1;

        $fp = @fsockopen($host, $port, $errCode, $errStr, $waitTimeoutInSeconds);

        if ($fp) {
            $status = "Online";
            $statusColor = "green";
            fclose($fp);

            // Get ping results
            exec("C:\\Windows\\System32\\ping.exe -n 4 " . $host, $pingOutput, $pingReturnVar);
            $pingResults = implode("<br>", $pingOutput);
        } else {
            $status = "Offline";
            $statusColor = "red";
            exec("C:\\Windows\\System32\\ping.exe -n 4 " . $host, $pingOutput, $pingReturnVar);
            $pingResults = implode("<br>", $pingOutput);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ping Status Checker</title>
    <style>
        body {
            font-family: 'Calibri', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 500px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
        }

        form {
            /*display: flex;
            flex-direction: column;
            justify-content: left;
            margin-bottom: 15px;
            width: 98%;
            padding: 10px;*/
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        label {
            text-align: left;
            font-weight: bold;
            font-size: 17px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: rgba(0, 255, 0, 0.2);
            text-align: center;
        }

        td {
            word-break: break-all;
            text-align: center;

        }

        input {
            padding: 10px;
            margin-bottom: 20px;
            font-size: 18px;
            border-radius: 5px;
        }

        h1 {
            text-align: center;
            color: green;
        }

        .button {
            font-weight: bold;
            border:none;
            width: 50%;
            font-size: 15px;
            background-color: rgba(0, 255, 0, 0.2);
            /border: 1px solid rgba(0, 255, 0, 0.5);/
            transition: 1s ease;
        }
        .button:hover {
            background-color: rgba(0, 255, 0, 0.5);
            transition: 1s ease;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
        }

        /* New styling for ping results */
        h2 {
            color: #333;
        }

        pre {
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ping Status Checker</h1>

        <form method="post" action="">
            <label>Enter Host/IP:</label>
            <input type="text" placeholder="enter host or ip i.e 192.168.1.2" name="host" required=""value="<?= htmlspecialchars($host) ?>">
            <input type="submit" class="button" value="Check Status">
        </form>
        
        <?php
        if ($status !== '') {
            echo "<table>";
            echo "<tr><th>Host</th><th>Status</th></tr>";
            echo "<tr>";
            echo "<td>$host</td>";
            echo "<td style='color: $statusColor;'>$status</td>";
            echo "</tr>";
            echo "</table>";

            // Display ping results in a new row
            echo "<div>";
            echo "<h3>Ping Results</h3>";
            echo "<pre>$pingResults</pre>";  // Use <pre> to preserve line breaks
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>