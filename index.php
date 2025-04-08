<?php
date_default_timezone_set('UTC');

$secrets = [
	//['name' => 'conta1', 'secret' => '12345678'],
	['name' => 'Google joao@gmail.com', 'secret' => 'SEGREDO04321']
];

function base32_decode($b32) {
	$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
	$b32 = strtoupper(preg_replace('/[^A-Z2-7]/', '', $b32));
	$binary = '';
	foreach (str_split($b32) as $char) {
		$val = strpos($alphabet, $char);
		$binary .= str_pad(decbin($val), 5, '0', STR_PAD_LEFT);
	}
	$bytes = '';
	foreach (str_split($binary, 8) as $byte) {
		if (strlen($byte) === 8) {
			$bytes .= chr(bindec($byte));
		}
	}
	return $bytes;
}

function hotp($secret, $counter, $digits = 6) {
	$bin_counter = pack('N*', 0) . pack('N*', $counter);
	$hash = hash_hmac('sha1', $bin_counter, $secret, true);
	$offset = ord($hash[19]) & 0x0F;
	$part = substr($hash, $offset, 4);
	$value = unpack("N", $part)[1] & 0x7FFFFFFF;
	return str_pad($value % pow(10, $digits), $digits, '0', STR_PAD_LEFT);
}

function totp($secret, $timeStep = 30, $digits = 6) {
	$counter = floor(time() / $timeStep);
	return hotp($secret, $counter, $digits);
}

$timeStep = 30;
$secondsRemaining = $timeStep - (time() % $timeStep);

$codes = array_map(function($entry) {
	$secret_bin = base32_decode($entry['secret']);
	return [
		'name' => $entry['name'],
		'code' => totp($secret_bin)
	];
}, $secrets);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Codes</title>
	<style>
		html, body {
			margin: 0;
			padding: 0;
			height: 100%;
			background-color: #000;
			color: #fff;
			font-family: monospace;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			text-align: center;
		}
		.entry {
			margin: 20px 0;
		}
		.name {
			font-size: 1.5em;
		}
		.code {
			font-size: 3em;
			margin-top: 10px;
		}
		.timer {
			font-size: 0.9em;
			color: #aaa;
			margin-left: 10px;
		}
	</style>
</head>
<body>
	<?php foreach ($codes as $entry): ?>
		<div class="entry">
			<div class="name">
				<?= htmlspecialchars($entry['name']) ?>
				<span class="timer" id="timer">(<?= $secondsRemaining ?>s)</span>
			</div>
			<div class="code"><?= $entry['code'] ?></div>
		</div>
	<?php endforeach; ?>

	<script>
		let seconds = <?= $secondsRemaining ?>;
		const timerEl = document.getElementById('timer');
		const update = () => {
			seconds--;
			if (seconds <= 0) {
				location.reload();
			} else {
				timerEl.textContent = `(${seconds}s)`;
			}
		};
		setInterval(update, 1000);
	</script>
</body>
</html>
