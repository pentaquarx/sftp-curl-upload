<?php

/*
 * @file uploadFile.php
 *
 * @brief 
 */

function uploadFile($sftpServer, $sftpPort, $username, $password = NULL, $filename) {
    $errors = array();

    $folderId = ltrim($folderId, '/');
    $folderId = rtrim($folderId, '/');

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_UPLOAD, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);

    assert(is_readable($filename));
    $fh = fopen($filename, 'rb');

    curl_setopt($curl, CURLOPT_URL, $sftpServer . $folderId . '/'. basename($filename));
    curl_setopt($curl, CURLOPT_PORT, $sftpPort);
    curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($curl, CURLOPT_INFILESIZE, filesize($filename));
    curl_setopt($curl, CURLOPT_INFILE, $fh);

    $response = curl_exec($curl);

    $curlError = curl_error($curl);
    curl_close($curl);
    fclose($fh);

    return true;
}

// Get credentials from command line arguments
$sftpServer = argv[1];
$sftpPort = argv[2];
$username = $argv[3];
$password = $argv[4];
$filename = $argv[5];

uploadFile($sftpServer, $sftpPort, $username, $password, $filename)

