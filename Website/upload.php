<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $curl = curl_init();
    $cfile = new CURLFile($_FILES['image']['tmp_name'], $_FILES['image']['type'], $_FILES['image']['name']);
    $data = array("image" => $cfile);

    curl_setopt($curl, CURLOPT_URL, 'http://localhost:5000/predict');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    $response = json_decode($response, true);
    curl_close($curl);

    echo "Result: " . ($response['eczema'] ? 'Eczema detected' : 'No eczema detected');
}
?>
