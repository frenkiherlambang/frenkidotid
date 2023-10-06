<html>

<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">

    <title>QZ Tray Sample Page</title>
</head>

<!-- Required scripts -->
<script type="text/javascript" src="/print/js/qz-tray.js"></script>

<!-- Pollyfills -->
<script type="text/javascript" src="/print/js/sample/promise-polyfill-8.1.3.min.js"></script>
<script type="text/javascript" src="/print/js/sample/whatwg-fetch-3.0.0.min.js"></script>

<!-- Page styling -->
<script type="text/javascript" src="/print/js/sample/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="/print/js/sample/bootstrap.min.js"></script>
<link rel="stylesheet" href="/print/css/font-awesome.min.css" />
<link rel="stylesheet" href="/print/css/bootstrap.min.css" />
<link rel="stylesheet" href="/print/css/style.css" />
<link rel="stylesheet" href="/print/css/gh-fork-ribbon.min.css" />
<script src="https://cdn.rawgit.com/kjur/jsrsasign/c057d3447b194fa0a3fdcea110579454898e093d/jsrsasign-all-min.js">
</script>
<script src="print/js/signing-message.js"></script>

<body>
    <button id="cetak">Print</button>
    <script type="text/javascript">
        qz.security.setCertificatePromise(function(resolve, reject) {
            //Preferred method - from server
            //        fetch("assets/signing/digital-certificate.txt", {cache: 'no-store', headers: {'Content-Type': 'text/plain'}})
            //          .then(function(data) { data.ok ? resolve(data.text()) : reject(data.text()); });

            //Alternate method 1 - anonymous
            //        resolve();  // remove this line in live environment

            //Alternate method 2 - direct
            resolve("-----BEGIN CERTIFICATE-----\n" +
                "MIIECzCCAvOgAwIBAgIUBpYZOYLxgUQC/c4d+nxoI1/NkS0wDQYJKoZIhvcNAQEL\n" +
                "BQAwgZQxCzAJBgNVBAYTAklEMRMwEQYDVQQIDApZb2d5YWthcnRhMRMwEQYDVQQH\n" +
                "DApZb2d5YWthcnRhMRQwEgYDVQQKDAtUZWtub2R1a2FzaTEMMAoGA1UECwwDUE9T\n" +
                "MQwwCgYDVQQDDANBUFAxKTAnBgkqhkiG9w0BCQEWGmZyZW5raWhlcmxhbWJhbmdA\n" +
                "Z21haWwuY29tMB4XDTIzMTAwNjEyMjcyN1oXDTMzMTAwMzEyMjcyN1owgZQxCzAJ\n" +
                "BgNVBAYTAklEMRMwEQYDVQQIDApZb2d5YWthcnRhMRMwEQYDVQQHDApZb2d5YWth\n" +
                "cnRhMRQwEgYDVQQKDAtUZWtub2R1a2FzaTEMMAoGA1UECwwDUE9TMQwwCgYDVQQD\n" +
                "DANBUFAxKTAnBgkqhkiG9w0BCQEWGmZyZW5raWhlcmxhbWJhbmdAZ21haWwuY29t\n" +
                "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAryhW5I5046ciIRgzPaeY\n" +
                "Z5EFjVPV2SBuR/8shdHjmnnrC/+FNmmCu03XrjW9c5w2epivPdAFYZ/v26paS/LP\n" +
                "Fbq4frQ68q8IMxCWDl2fQJXmMgya4Lm1NvQP6nfEPkf92fqMLGbrvH7b/H4GqHse\n" +
                "dS+d/rTjAb6vsQJ7GtsZXe0lbk7J8mEe16H5poBvfDmGU0so0bMqtCDDPsKgKY1+\n" +
                "DDYv1HzI3+Q/KPRb02GmwkDzU5q9KtX+21EIo90B5Oj29ttd7jiirSb56731rThG\n" +
                "Buk6d3WEbjvQ3wzOJqIBTD0LOAc3CtKdhbuhlPIxFIN5Zu1WGjscXfODtUuouEXx\n" +
                "1QIDAQABo1MwUTAdBgNVHQ4EFgQUdjXto+KOZvmN/mBsdpu55SkZdM8wHwYDVR0j\n" +
                "BBgwFoAUdjXto+KOZvmN/mBsdpu55SkZdM8wDwYDVR0TAQH/BAUwAwEB/zANBgkq\n" +
                "hkiG9w0BAQsFAAOCAQEAIkH+2k2K41HEwY/BemwOyTtpQHpcTnu9T2oGn35D4kRN\n" +
                "LnmR5+f7cKtHYg2+xzjALzUV2alqoliikrqKmRFHbGQVsONdnQ8ukNnOGFm5ELgq\n" +
                "MgbyDmn789mu8b5tx81mjWrEmNpjS3Ewlztg+t1OpJfzhUXMFSgzPm6MbGY8FEIV\n" +
                "v3hSDKD8b/snmvmgMOhHBc9rxufDT6WavxAHxUIs2JpNgvTw0sWQQl0VDftNowOr\n" +
                "t4PCiUlWYWZpALVAZYwa0LLLRAwHkdYVtFMBjjYgOtV3kJxJo09vunEvNzZFUFeW\n" +
                "YFja6+ZFVyY/9Nz4PoceW55Rn/0nn2CwHOD/Z5QrTw==\n" +
                "-----END CERTIFICATE-----\n"
            );
        });

        // qz.security.setSignatureAlgorithm("SHA512"); // Since 2.1
        // qz.security.setSignaturePromise(function(toSign) {
        //     return function(resolve, reject) {
        //         //Preferred method - from server
        //         //            fetch("/secure/url/for/sign-message?request=" + toSign, {cache: 'no-store', headers: {'Content-Type': 'text/plain'}})
        //         //              .then(function(data) { data.ok ? resolve(data.text()) : reject(data.text()); });

        //         //Alternate method - unsigned
        //         resolve(); // remove this line in live environment
        //     };
        // });
        function printOnPaper(leftString, rightString) {
            const paperWidth = 32;
            const maxLeftWidth = Math.floor((paperWidth - rightString.length));
            const formattedLeftString = leftString.slice(0, maxLeftWidth).padEnd(maxLeftWidth);

            const output = formattedLeftString + rightString;
            return output.slice(0, paperWidth);
        }
        var data = [
            '\x1B' + '\x40', // init
            '\x1B' + '\x61' + '\x31', // center align
            {
                type: 'raw',
                format: 'image',
                flavor: 'file',
                data: 'print/altari.jpg',
                options: {
                    language: "ESCPOS",
                    dotDensity: 'double',
                }
            },
            '\x1B' + '\x45' + '\x0D', // bold on
            'Altari Sports' + '\x0A',
            '\x1B' + '\x45' + '\x0A', // bold off
            '\x0A', // line break
            'www.altari.id' + '\x0A', // text and line break
            '\x0A', // line break
            'May 18, 2016 10:30 AM' + '\x0A',
            '\x0A', // line break
            'Transaction # 123456 Register: 3' + '\x0A',
            '\x0A',
            '\x1B' + '\x61' + '\x30', // left align

            printOnPaper('Size:42 x 1', 'Rp1.000.000'),
            // 'Baklava (Qty 4)       9.00' + '\x1B' + '\x74' + '\x13' + '\xAA', //print special char symbol after numeric
            // '\x0A',
            // 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX' + '\x0A',
            // '\x1B' + '\x45' + '\x0D', // bold on
            // 'Here\'s some bold text!',
            // '\x1B' + '\x45' + '\x0A', // bold off
            // '\x0A' + '\x0A',
            // '\x1B' + '\x61' + '\x32', // right align
            // '\x1B' + '\x21' + '\x30', // em mode on
            // 'DRINK ME',
            // '\x1B' + '\x21' + '\x0A' + '\x1B' + '\x45' + '\x0A', // em mode off
            // '\x0A' + '\x0A',
            '\x1B' + '\x61' + '\x30', // left align
            '-------------------------------' + '\x0A',
            // '\x1B' + '\x4D' + '\x31', // small text
            'EAT ME' + '\x0A',
            // '\x1B' + '\x4D' + '\x30', // normal text
            '------------------------------' + '\x0A',
            'normal text',
            '\x1B' + '\x61' + '\x30', // left align
            '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A' + '\x0A',
            // '\x1B' + '\x69', // cut paper (old syntax)
            // '\x1D' + '\x56'  + '\x00' // full cut (new syntax)
            // '\x1D' + '\x56'  + '\x30' // full cut (new syntax)
            // '\x1D' + '\x56'  + '\x01' // partial cut (new syntax)
            // '\x1D' + '\x56'  + '\x31' // partial cut (new syntax)
            '\x10' + '\x14' + '\x01' + '\x00' + '\x05', // Generate Pulse to kick-out cash drawer**
            // **for legacy drawer cable CD-005A.  Research before using.
            // Star TSP100-series kick-out ONLY
            // '\x1B' + '\x70' + '\x00' /* drawer 1 */ + '\xC8' + '\xC8' + '\x1B' + '\x1F' + '\x70' + '\x03' + '\x00',
            // '\x1B' + '\x70' + '\x01' /* drawer 2 */ + '\xC8' + '\xC8' + '\x1B' + '\x1F' + '\x70' + '\x03' + '\x00',
        ];



        document.addEventListener('DOMContentLoaded', function() {
            qz.websocket.connect().then(function() {
                alert("Connected!");
            });

            var config = qz.configs.create("POS58");

            document.getElementById("cetak").addEventListener("click", function(e) {

                qz.print(config, data).catch(function(e) {
                    console.error(e);
                });

            });

        });
    </script>
</body>



</html>
