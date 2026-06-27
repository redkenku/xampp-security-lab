# Lab: Web Application with XAMPP, GitHub, Continuous Testing, and Security as Code

## Overview

This project is the completed XAMPP lab exercise. It fixes the supplied JavaScript challenge, integrates the PHP challenge through an HTML form, adds automated tests, and configures GitHub Actions for Continuous Testing and Security as Code.

## Environment Setup

The target classroom environment is Windows 10 with XAMPP. This implementation also runs on Linux with XAMPP/LAMPP.

On Arch Linux:

```bash
sudo pacman -S --needed php composer gitleaks
yay -S xampp
sudo /opt/lampp/lampp start
sudo ln -s "$PWD" /opt/lampp/htdocs/xampp-security-lab
```

Open:

```text
http://localhost/xampp-security-lab/
```

If Apache is already running on another port, stop that service or change the XAMPP Apache port in `/opt/lampp/etc/httpd.conf`.

## Repository Structure

- `index.html` - first challenge page with the broken Base64 password fixed in `script.js`.
- `challenge-form.php` - HTML/PHP form that submits the required variables.
- `pass_accept.php` - server-side challenge result page.
- `src/PassAccept.php` - validation, escaping, and emitted challenge JavaScript helpers.
- `tests/js/` - Jest tests for JavaScript behavior.
- `tests/php/` - PHPUnit tests for PHP validation.
- `.github/workflows/ci.yml` - Continuous Testing and Security as Code pipeline.
- `docs/` - technical review and security documentation.
- `docs/submission/` - final submission screenshots and link summary.

## Running Locally

Install JavaScript dependencies:

```bash
npm install
```

Install PHP dependencies:

```bash
composer install
```

Run the web app through XAMPP:

```bash
sudo /opt/lampp/lampp start
sudo ln -s "$PWD" /opt/lampp/htdocs/xampp-security-lab
```

Then visit `http://localhost/xampp-security-lab/`.

## Tests and Static Analysis

JavaScript:

```bash
npm run lint:js
npm run security:js
npm run test:js
```

PHP:

```bash
composer test:php
composer analyse:php
```

The JavaScript tests verify decoding, encode/decode round trips, and button interaction. The PHP tests verify valid submissions, rejected password/sort-code errors, missing names, and missing POST keys without notices.

## CI/CD Pipeline

GitHub Actions runs on every push and pull request. The `quality-and-security` job:

1. Installs Node dependencies with `npm ci`.
2. Runs ESLint and security-focused ESLint rules.
3. Runs Jest tests.
4. Installs PHP dependencies with Composer.
5. Runs PHPUnit tests.
6. Runs PHPStan static analysis.
7. Runs Gitleaks secret scanning.
8. Runs OWASP Dependency Check and fails on critical findings with CVSS 9 or higher.

## GitHub Workflow

The intended workflow is:

```text
commit -> push -> pull request -> code review -> merge
```

The baseline imported site is committed on `main`. The completed lab implementation is developed on `lab-solution` and opened as a pull request.

## Security as Code

Security checks are automated in CI:

- PHPStan checks PHP type and control-flow issues.
- ESLint with `eslint-plugin-security` checks JavaScript security patterns.
- Gitleaks scans the Git history and working tree for secrets.
- OWASP Dependency Check scans dependencies and blocks critical vulnerability findings.

## Submission Evidence

- [Submission summary](docs/submission/SUBMISSION.md)
- [Working XAMPP localhost page](docs/submission/01-xampp-localhost.png)
- [Successful PHP challenge page](docs/submission/02-php-success.png)
- [Green GitHub Actions run](docs/submission/03-github-actions-green.png)
