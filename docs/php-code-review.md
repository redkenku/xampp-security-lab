# PHP Code Review: `pass_accept.php`

## Original Issues

- Direct `$_POST["pws"]`, `$_POST["srt"]`, and `$_POST["fName"]` access could trigger notices when fields were missing.
- Validation was embedded directly in the HTML page, making it hard to test.
- No structured error messages were shown when validation failed.
- User-controlled values were not consistently escaped before rendering.
- The emitted JavaScript was displayed as raw text with `<br>` tags instead of being handled as a controlled script output.

## Implemented Fixes

- Moved validation into `src/PassAccept.php`.
- Added `validatePassAcceptInput()` with explicit checks for password, sort code, and first name.
- Used `hash_equals()` for exact secret comparisons.
- Added `e()` for HTML escaping with `ENT_QUOTES | ENT_SUBSTITUTE`.
- Added user-facing error output for invalid submissions.
- Added PHPUnit tests for valid input, wrong password, wrong sort code, empty first name, and missing keys.
- Rendered the final challenge DOM explicitly and emitted controlled JavaScript through `renderChallengeScript()`.

## Result

The PHP challenge now has a testable validation layer, safe rendering, predictable error handling, and a working HTML integration page.
