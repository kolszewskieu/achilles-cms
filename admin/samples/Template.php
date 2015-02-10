<?php
include_once 'Sample_Header.php';

// New Word document
echo date('H:i:s') , " Create new PhpWord object" , EOL;
$phpWord = new \PhpOffice\PhpWord\PhpWord();

$document = $phpWord->loadTemplate('resources/Template.docx');

// Variables on different parts of document
$document->setValue('weekday', date('l')); // On section/content
$document->setValue('day', date('d.m.y.')); // On footer
//$document->setValue('serverName', realpath(__DIR__)); // On header


$name = 'Template.docx';
echo date('H:i:s'), " Write to Word2007 format", EOL;
$document->saveAs($name);
rename($name, "results/{$name}");

echo getEndingNotes(array('Word2007' => 'docx'));
if (!CLI) {
    include_once 'Sample_Footer.php';
}
