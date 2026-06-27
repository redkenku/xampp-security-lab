(function exposePasswordTools(root) {
  "use strict";

  const encodedChallenge = "VGgxNV8xNV81VFIwbjY";
  const keyString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

  const secret = {
    _keyStr: keyString,

    encode(input) {
      let output = "";
      let i = 0;
      const utfInput = secret._utf8Encode(String(input));

      while (i < utfInput.length) {
        const chr1 = utfInput.charCodeAt(i);
        i += 1;
        const chr2 = utfInput.charCodeAt(i);
        i += 1;
        const chr3 = utfInput.charCodeAt(i);
        i += 1;

        const enc1 = chr1 >> 2;
        const enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
        let enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
        let enc4 = chr3 & 63;

        if (Number.isNaN(chr2)) {
          enc3 = 64;
          enc4 = 64;
        } else if (Number.isNaN(chr3)) {
          enc4 = 64;
        }

        output += keyString.charAt(enc1) + keyString.charAt(enc2) + keyString.charAt(enc3) + keyString.charAt(enc4);
      }

      return output;
    },

    decode(input) {
      let output = "";
      let i = 0;
      let cleanInput = String(input).replace(/[^A-Za-z0-9+/=]/g, "");

      while (cleanInput.length % 4 !== 0) {
        cleanInput += "=";
      }

      while (i < cleanInput.length) {
        const enc1 = keyString.indexOf(cleanInput.charAt(i));
        i += 1;
        const enc2 = keyString.indexOf(cleanInput.charAt(i));
        i += 1;
        const enc3 = keyString.indexOf(cleanInput.charAt(i));
        i += 1;
        const enc4 = keyString.indexOf(cleanInput.charAt(i));
        i += 1;

        const chr1 = (enc1 << 2) | (enc2 >> 4);
        const chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
        const chr3 = ((enc3 & 3) << 6) | enc4;

        output += String.fromCharCode(chr1);

        if (enc3 !== 64) {
          output += String.fromCharCode(chr2);
        }

        if (enc4 !== 64) {
          output += String.fromCharCode(chr3);
        }
      }

      return secret._utf8Decode(output);
    },

    _utf8Encode(input) {
      const string = input.replace(/\r\n/g, "\n");
      let utfText = "";

      for (let n = 0; n < string.length; n += 1) {
        const charCode = string.charCodeAt(n);

        if (charCode < 128) {
          utfText += String.fromCharCode(charCode);
        } else if (charCode < 2048) {
          utfText += String.fromCharCode((charCode >> 6) | 192);
          utfText += String.fromCharCode((charCode & 63) | 128);
        } else {
          utfText += String.fromCharCode((charCode >> 12) | 224);
          utfText += String.fromCharCode(((charCode >> 6) & 63) | 128);
          utfText += String.fromCharCode((charCode & 63) | 128);
        }
      }

      return utfText;
    },

    _utf8Decode(utfText) {
      let string = "";
      let i = 0;

      while (i < utfText.length) {
        const charCode = utfText.charCodeAt(i);

        if (charCode < 128) {
          string += String.fromCharCode(charCode);
          i += 1;
        } else if (charCode > 191 && charCode < 224) {
          const charCode2 = utfText.charCodeAt(i + 1);
          string += String.fromCharCode(((charCode & 31) << 6) | (charCode2 & 63));
          i += 2;
        } else {
          const charCode2 = utfText.charCodeAt(i + 1);
          const charCode3 = utfText.charCodeAt(i + 2);
          string += String.fromCharCode(((charCode & 15) << 12) | ((charCode2 & 63) << 6) | (charCode3 & 63));
          i += 3;
        }
      }

      return string;
    }
  };

  function decodePassword(encodedPassword = encodedChallenge) {
    return secret.decode(encodedPassword);
  }

  function onClick() {
    const header = root.document ? root.document.querySelector(".header") : null;

    if (header) {
      header.textContent = decodePassword();
    }
  }

  function init() {
    const button = root.document ? root.document.querySelector(".btn") : null;

    if (button) {
      button.addEventListener("click", onClick);
    }
  }

  if (root.document) {
    if (root.document.readyState === "loading") {
      root.document.addEventListener("DOMContentLoaded", init);
    } else {
      init();
    }
  }

  root.secret = secret;
  root.decodePassword = decodePassword;

  if (typeof module !== "undefined" && module.exports) {
    module.exports = {
      decodePassword,
      encodedChallenge,
      init,
      onClick,
      secret
    };
  }
})(typeof window !== "undefined" ? window : globalThis);
