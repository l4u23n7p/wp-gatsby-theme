# Changelog

All notable changes will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.1.1] - 2019-11-23

### Added

- Add `link` field to company in `about_page` group
- Add `slug` field to blog type in `home_page` group _(in order to match project type)_
- Add ressource url in addition to id for `pages` field of `/wp/v2/theme-settings`

### Updated

- Rename `link` field to `slug` in project type of `home_page` group

### Fixed

- Fix `acf-json` to load groups as expected

## [0.1.0] - 2019-11-17

### Added

- Add `project` post type with its `filter` taxonomie
- Add theme settings page _(deploy, social media and jwt auth setting)_
- Custom fields for taxonomies _(`color` and `text_color`)_
- Custom fields for `home` page
- Custom fields for `about` page
- Add `/wp/v2/theme-settings` route
- Expose custom fields on API route _(for `posts`, `pages` and `projects`)_
