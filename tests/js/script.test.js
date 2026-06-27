const { decodePassword, encodedChallenge, init, onClick, secret } = require("../../script");

describe("password decoder", () => {
  beforeEach(() => {
    document.body.innerHTML = "";
  });

  test("decodes the lab password", () => {
    expect(decodePassword(encodedChallenge)).toBe("Th15_15_5TR0n6");
  });

  test("supports encode/decode round trips", () => {
    const plainText = "Security as Code";

    expect(secret.decode(secret.encode(plainText))).toBe(plainText);
  });

  test("updates the header when the button handler runs", () => {
    document.body.innerHTML = '<h2 class="header">VGgxNV8xNV81VFIwbjY</h2>';

    onClick();

    expect(document.querySelector(".header").textContent).toBe("Th15_15_5TR0n6");
  });

  test("registers the click handler on the challenge button", () => {
    document.body.innerHTML = '<h2 class="header">VGgxNV8xNV81VFIwbjY</h2><button class="btn">Show Password</button>';

    init();
    document.querySelector(".btn").click();

    expect(document.querySelector(".header").textContent).toBe("Th15_15_5TR0n6");
  });
});
