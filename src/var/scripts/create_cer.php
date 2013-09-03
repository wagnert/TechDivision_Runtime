<?php
// Fill in data for the distinguished name to be used in the cert
// You must change the values of these keys to match your name and
// company, or more precisely, the name and company of the person/site
// that you are generating the certificate for.
// For SSL certificates, the commonName is usually the domain name of
// that will be using the certificate, but for S/MIME certificates,
// the commonName will be the name of the individual who will use the
// certificate.
$dn = array(
    "countryName" => "DE",
    "stateOrProvinceName" => "Bavaria",
    "localityName" => "Kolbermoor",
    "organizationName" => "TechDivision GmbH",
    "organizationalUnitName" => "Development",
    "commonName" => "localhost",
    "emailAddress" => "admin@localhost"
);


$configargs = array(
    'config' => '/System/Library/OpenSSL/openssl.cnf',
    // 'digest_alg' => 'md5',
    // 'x509_extensions' => 'v3_ca',
    // 'req_extensions'   => 'v3_req',
    // 'private_key_bits' => 666,
    // 'private_key_type' => OPENSSL_KEYTYPE_RSA,
    // 'encrypt_key' => false,
);

// Generate a new private (and public) key pair
$privkey = openssl_pkey_new();

// Generate a certificate signing request
$csr = openssl_csr_new($dn, $privkey, $configargs);

// You will usually want to create a self-signed certificate at this
// point until your CA fulfills your request.
// This creates a self-signed cert that is valid for 365 days
$sscert = openssl_csr_sign($csr, null, $privkey, 365);

// Now you will want to preserve your private key, CSR and self-signed
// cert so that they can be installed into your web server, mail server
// or mail client (depending on the intended use of the certificate).
// This example shows how to get those things into variables, but you
// can also store them directly into files.
// Typically, you will send the CSR on to your CA who will then issue
// you with the "real" certificate.

/*
openssl_csr_export_to_file($csr, $csrout = 'server.csr');
openssl_pkey_export_to_file($privkey, $pkeyout = 'server.key');
*/

openssl_x509_export($sscert, $certout);
openssl_pkey_export($privkey, $pkeyout);

file_put_contents('etc/server.pem', $certout . $pkeyout);

// Show any errors that occurred here
while (($e = openssl_error_string()) !== false) {
    echo $e . PHP_EOL;
}