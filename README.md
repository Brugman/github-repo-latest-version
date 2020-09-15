# GitHub repo latest version

> Add the ability to show an update notice in your apps with minimal code.

## Demo

What's the latest version of [Brugman/acf-agency-workflow](https://github.com/Brugman/acf-agency-workflow)?

Just grab https://github-repo-latest-version.timbr.dev/Brugman/acf-agency-workflow

This repo gets the latest version (tag) of your GitHub repos, and stores it on your own website. Inside your GitHub hosted software you can then pull that URL, see if the latest version is newer than the current version, and tell the user they should update.

## Usage

`/username/project` provides you with the latest version (tag) of a GitHub repo as JSON.

To display an update notice in for example WordPress, you can grab this data with `file_get_contents()` or `curl`, and compare it to the installed version.

On `/admin` you can check on how your caches are doing. No API calls are made for this page, so it is unrestricted.

## Requirements

- Composer

## Installation

1. `composer i`.
1. Duplicate `config.example.php` to `config.php`.
1. Edit `config.php`.
1. Map a (sub)domain to `public_html`.

## Contributing

Found a bug? Anything you would like to ask, add or change? Please open an issue so we can talk about it.

Pull requests are welcome. Please try to match the current code formatting.

## Author

[Tim Brugman](https://github.com/Brugman)
