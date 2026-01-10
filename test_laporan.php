<?php
// Test script untuk halaman laporan
echo "Testing halaman laporan...\n\n";

$ch = curl_init('http://localhost:8082/laporan');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
$error = curl_error($ch);

curl_close($ch);

echo "HTTP Status Code: $httpCode\n";
echo "Content Type: $contentType\n";
echo "Error: $error\n\n";

if ($httpCode == 200) {
    echo "✅ SUCCESS: Halaman berhasil dimuat!\n";
    echo "Response Length: " . strlen($response) . " characters\n";
    echo "First 300 chars:\n";
    echo substr($response, 0, 300) . "\n...\n";
} else {
    echo "❌ ERROR: Halaman gagal dimuat\n";
    echo "Response:\n$response\n";
}
?>
