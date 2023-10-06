/*
 * JavaScript client-side example using jsrsasign
 */

// #########################################################
// #             WARNING   WARNING   WARNING               #
// #########################################################
// #                                                       #
// # This file is intended for demonstration purposes      #
// # only.                                                 #
// #                                                       #
// # It is the SOLE responsibility of YOU, the programmer  #
// # to prevent against unauthorized access to any signing #
// # functions.                                            #
// #                                                       #
// # Organizations that do not protect against un-         #
// # authorized signing will be black-listed to prevent    #
// # software piracy.                                      #
// #                                                       #
// # -QZ Industries, LLC                                   #
// #                                                       #
// #########################################################

/**
 * Depends:
 *     - jsrsasign-latest-all-min.js
 *     - qz-tray.js
 *
 * Steps:
 *
 *     1. Include jsrsasign 8.0.4 into your web page
 *        <script src="https://cdn.rawgit.com/kjur/jsrsasign/c057d3447b194fa0a3fdcea110579454898e093d/jsrsasign-all-min.js"></script>
 *
 *     2. Update the privateKey below with contents from private-key.pem
 *
 *     3. Include this script into your web page
 *        <script src="path/to/sign-message.js"></script>
 *
 *     4. Remove or comment out any other references to "setSignaturePromise"
 */
var privateKey = "-----BEGIN PRIVATE KEY-----\n" +
    "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCvKFbkjnTjpyIh\n" +
    "GDM9p5hnkQWNU9XZIG5H/yyF0eOaeesL/4U2aYK7TdeuNb1znDZ6mK890AVhn+/b\n" +
    "qlpL8s8Vurh+tDryrwgzEJYOXZ9AleYyDJrgubU29A/qd8Q+R/3Z+owsZuu8ftv8\n" +
    "fgaoex51L53+tOMBvq+xAnsa2xld7SVuTsnyYR7XofmmgG98OYZTSyjRsyq0IMM+\n" +
    "wqApjX4MNi/UfMjf5D8o9FvTYabCQPNTmr0q1f7bUQij3QHk6Pb2213uOKKtJvnr\n" +
    "vfWtOEYG6Tp3dYRuO9DfDM4mogFMPQs4BzcK0p2Fu6GU8jEUg3lm7VYaOxxd84O1\n" +
    "S6i4RfHVAgMBAAECggEBAKYEYR+u2qGwF0ww6NhmUrDPJukGbimncH+zH9sSzlzr\n" +
    "c9pibTvek7e+l1AaxZ+fj49xyp+W3JLkie61r3JPCPL6kMYfQ8QkHGxyKxggqsIH\n" +
    "kjEb+2xG+LjGaZN9wzaY+8WwkU3Am22E/DN8rAji8UJ3SJRTlNphh5sJ0+7nfkqj\n" +
    "2tbqmMJkKT+G1UuQQYAJVRSWlO9XjUNfa2l6iLr4jLwA6X1hLmLabbTLo4Y9DhYt\n" +
    "zjNwyd9Ddv+5uXrTo/BwJGiZ3raeO9d2Gw11sbdGDYWTu7jGaI7LsZc/Xz1hh3ZH\n" +
    "hQQQ/HHKFOvtvE37olj+c7Gdr2s10gf/oaBj7+yf3YECgYEA3JnTMF40Jd7e7/Kk\n" +
    "iuUmqRwKlbFrYjjLwM/RO0GxIq3HDH40CfldjQ3dIU60VenLfQyH/4aUV3svb5gB\n" +
    "M6KVmGEw72r6PBXCqn1w2S/cSyb/EbxCyTXM5Vn0A9MI5IKok3uwxiETtVYGkgi7\n" +
    "XiARz7fCtH8C5NQzWb/BXnRK2PUCgYEAy0O53ooxvxcJSRHBX1UPY7FVXUHqhEJC\n" +
    "E8z+jGCDc0YlGP/u0AlZ/XuPRWxyHeOudAr7Mdxdr31OhuPR8+b9dVsKLOZ4r44q\n" +
    "IN7nN3ajc53Zk/wcjKMWEXoW0HKYUmKYD2uRvVz/ovhHHfcLq0TJ54C23GeaoJ1G\n" +
    "QB+HgtXwqWECgYAaNiDUz2ysz0V4B0GryzyDvXQ4gyM6QXtcRpUa0FxmvXU4M8ql\n" +
    "IL8P4oTSz1I4HxZxnkqOfwQjPNzPCqWh6ACUYX/6AqEHAKLntQ3ykHBBcbm+9rqM\n" +
    "w9q7qauHxMx6slerZngDoqx/0F/pfCYfMfpLzw7QeYLzg48ya8ljGrhF/QKBgGlG\n" +
    "Z4L6Ai/dZ4K/vm54qKLSmsrVM/hSNNT6jC/6YLqYbuhWzcJTxZcCor6rHyOZ46XY\n" +
    "didp4d/dP4mffwMa9NUOVOPSbllGgU1LBWf1e0yLScBaiBLS+MAOgrhtUbUBuY3r\n" +
    "Aa2Y+BHZE0RSymlnFEdho9PdmPls25Ckg9PgqGehAoGAKPaIg/OV/h1z0kZfV+9T\n" +
    "IzotBfeGWOiqd6bzY3WXJHgotdD3RVw4t40+YL3/jnD1EN+MNrboTOlX1ubvZ64E\n" +
    "/m3zClGJIVHfiSrcm0NfhVMxNpEiFaoyrcjWGr/8cryhnvikkpHWudyxv4rx47Kq\n" +
    "tMncGoTh/Nxaaf+et+EZL/0=\n" +
    "-----END PRIVATE KEY-----";

qz.security.setSignatureAlgorithm("SHA512"); // Since 2.1
qz.security.setSignaturePromise(function (toSign) {
    return function (resolve, reject) {
        try {
            var pk = KEYUTIL.getKey(privateKey);
            var sig = new KJUR.crypto.Signature({ "alg": "SHA512withRSA" });  // Use "SHA1withRSA" for QZ Tray 2.0 and older
            sig.init(pk);
            sig.updateString(toSign);
            var hex = sig.sign();
            console.log("DEBUG: \n\n" + stob64(hextorstr(hex)));
            resolve(stob64(hextorstr(hex)));
        } catch (err) {
            console.error(err);
            reject(err);
        }
    };
});
