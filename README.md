# GitHub repo latest version

## Demo

What's the latest version of [Brugman/acf-agency-workflow](https://github.com/Brugman/acf-agency-workflow)? Just grab https://github-repo-latest-version.timbr.dev/Brugman/acf-agency-workflow

## Requirements

- Composer

## Installation

- `composer i`.
- Duplicate `config.example.php` to `config.php`.
- Edit `config.php`.
- Map a (sub)domain to `public_html`.

## Usage

`/username/project` provides you with the latest version (tag) of a GitHub repo as JSON.

To display an update notice in for example WordPress, you can grab this data with `file_get_contents()` or `curl`, and compare it to the installed version.

On `/admin` you can check on how your caches are doing. No API calls are made for this page, so it is unrestricted.