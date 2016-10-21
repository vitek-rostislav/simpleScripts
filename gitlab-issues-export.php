<?php
$xml = simplexml_load_file('setting.xml');
$token = $xml->token;
$ch = curl_init('http://gitlab/api/v3/projects/34/issues?milestone=New%20infrastructure&private_token=' . $token . '&per_page=100');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
$issues = json_decode($output, true);
$file = fopen('issues.csv', 'w');
fputcsv($file, ['id', 'Název', 'Popis', 'Přiřazeno k', 'Stav']);
foreach ($issues as $issue) {
	$data = [
		$issue['iid'],
		$issue['title'],
		$issue['description'],
		$issue['assignee']['name'],
		$issue['state'],
	];
	fputcsv($file, $data);
}
fclose($file);
curl_close($ch);