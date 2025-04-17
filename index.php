<?php

// Secrets List
$pairs = [
    ['secret' => 'JBSWY3DPEHPK3PXP', 'name' => 'Google Account'],
    ['secret' => 'NB2W45DFOIZA====', 'name' => 'Outlook Account']
];

function base32_decode($b32) {
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    $b32 = strtoupper($b32);
    $b32 = preg_replace('/[^A-Z2-7]/', '', $b32);
    $binary = '';
    foreach (str_split($b32) as $char) {
        $binary .= str_pad(base_convert(strpos($alphabet, $char), 10, 2), 5, '0', STR_PAD_LEFT);
    }
    $bytes = '';
    foreach (str_split($binary, 8) as $byte) {
        if (strlen($byte) === 8) {
            $bytes .= chr(bindec($byte));
        }
    }
    return $bytes;
}

function generate_totp($secret, $timeStep = 30, $digits = 6) {
    $counter = floor(time() / $timeStep);
    $binary_counter = pack('N*', 0) . pack('N*', $counter);

    $key = base32_decode($secret);
    $hash = hash_hmac('sha1', $binary_counter, $key, true);

    $offset = ord(substr($hash, -1)) & 0x0F;
    $part = substr($hash, $offset, 4);

    $value = unpack('N', $part)[1];
    $value = $value & 0x7FFFFFFF;
    $modulo = pow(10, $digits);

    return str_pad($value % $modulo, $digits, '0', STR_PAD_LEFT);
}

// Adding GET parameters
if (isset($_GET['secret']) && isset($_GET['name'])) {
    $secrets = (array) $_GET['secret'];
    $names = (array) $_GET['name'];
    foreach ($secrets as $i => $secret) {
        $pairs[] = [
            'secret' => $secret,
            'name' => $names[$i] ?? 'NoName'
        ];
    }
}

// Calculates the 30s cycles
$now = time();
$timeStep = 30;
$secondsRemaining = $timeStep - ($now % $timeStep);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TOTP Codes</title>
    <meta http-equiv="refresh" content="<?php echo $secondsRemaining; ?>">
    <style>
        body {
            background-color: #111;
            color: #0f0;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .totp-block {
            background: #222;
            border: 1px solid #0f0;
            padding: 10px;
            margin: 10px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            font-size: 1.5em;
            font-family: monospace;
            border-radius: 10px;
        }
        h1 {
            margin-bottom: 30px;
        }
    </style>
</head>
	
<body>
<h1>Codes</h1>
<?php foreach ($pairs as $pair): ?>
    <div class="totp-block">
        <div><strong><?php echo htmlspecialchars($pair['name']); ?></strong></div>
        <div><?php echo generate_totp($pair['secret']); ?></div>
    </div>
<?php endforeach; ?>
</body>
</html>
