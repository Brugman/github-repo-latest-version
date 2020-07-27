# GitHub repo latest version

## Requirements

- Composer

## Installation

- `composer i`.
- Duplicate `config.example.php` to `config.php`.
- Edit `config.php`.
- Map a (sub)domain to `public_html`.

## Usage

`https://foo.company.com/repository-name` displays the latest version (tag) of your GitHub repo in JSON format.

To display an update notice in for example WordPress you can grab this JSON remotely with `file_get_contents('https://foo.company.com/repository-name')`.

On `https://foo.company.com/admin.php` you can check on how your caches are doing. No API calls are made for this page, so its unrestricted.