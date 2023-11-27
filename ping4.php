<?php
    $status = '';
    $host = '';

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
            } else {
                $status = "Offline";
                $statusColor = "red";
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
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5); /
        }

        form {
            display: flex;
            flex-direction: column;
            justify-content: left;
            margin-bottom: 15px;
            width: 98%;
            padding: 10px;
        }
        label{
            text-align: left;
            font-weight: bold; 
            font-size: 20px;
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
            background-color: #f2f2f2;
        }

        td {
            word-break: break-all;
        }
        input{
            padding: 10px;
            margin-bottom: 20px;
            font-size: 18px;
        }
        h1{
            text-align: center;
            color: green;
        }
        .button{
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ping Status Checker</h1>

        <form method="post" action="">
            <label>Enter Host/IP:</label>
            <input type="text" placeholder="enter host or ip i.e 192.168.1.2"name="host" value="<?= htmlspecialchars($host) ?>">
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
            }
        ?>
    </div>
</body>
</html>
