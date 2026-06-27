# Security Report

## Reviewed Areas

- JavaScript password decoding in `script.js`
- PHP input handling in `pass_accept.php`
- HTML/PHP integration through `challenge-form.php`
- CI/CD checks in GitHub Actions

## JavaScript Findings

The original `script.js` contained syntax errors and logic bugs:

- invalid increment syntax in Base64 decoding
- invalid comparison operator
- mismatched braces
- dangling `header.style`
- returned the string `"output"` instead of the decoded value
- used `innerHTML` for plain text output

Fixes:

- corrected Base64 encode/decode logic
- exposed testable functions for Jest
- used `textContent` for DOM updates
- added browser-safe initialization

## PHP Findings

The original PHP code read POST variables directly and mixed validation with rendering. Missing POST fields could produce notices, and user data was not clearly escaped.

Fixes:

- centralized validation in `src/PassAccept.php`
- rejected invalid submissions with clear messages
- escaped rendered text
- added PHPUnit coverage for expected and failure cases

## Security as Code Tools

- ESLint with `eslint-plugin-security`
- PHPStan
- Gitleaks
- OWASP Dependency Check

## Pipeline Behavior

The GitHub Actions pipeline runs on push and pull request. It blocks the PR if tests fail, static analysis fails, Gitleaks finds secrets, or OWASP Dependency Check finds critical vulnerabilities with CVSS 9 or higher.

## Current Notes

The project keeps the supplied Bootstrap, jQuery, and Font Awesome assets as static files to preserve the original assignment page. Dependency scanning is still enabled, and critical findings block the pipeline.

## Local Scan Summary

- `npm run lint:js` passed.
- `npm run security:js` passed.
- `npm run test:js` passed.
- `composer test:php` passed.
- `composer analyse:php` passed.
- `gitleaks protect --staged --config=.gitleaks.toml` passed.
- `composer audit` found no advisories.
- `npm audit --audit-level=critical` found no critical advisories; npm still reports moderate Jest coverage-chain advisories in dev-only dependencies.
