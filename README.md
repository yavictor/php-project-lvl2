### Hexlet tests and linter status:
[![hexlet-check](https://github.com/yavictor/php-project-lvl2/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/yavictor/php-project-lvl2/actions/workflows/hexlet-check.yml)
[![Code Climate](https://codeclimate.com/github/yavictor/php-project-lvl2/badges/gpa.svg)](https://codeclimate.com/github/yavictor/php-project-lvl2)
[![issue Count](https://codeclimate.com/github/yavictor/php-project-lvl2/badges/issue_count.svg)](https://codeclimate.com/github/yavictor/php-project-lvl2/issues)
[![Test Coverage](https://codeclimate.com/github/yavictor/php-project-lvl2/badges/coverage.svg)](https://codeclimate.com/github/yavictor/php-project-lvl2/coverage)

### gendiff:

Command line interface util that can show difference between two configuration files in json and yaml format. Also it can show only parameters that chaged in configuration and generate json result of both configs.

### Install

1. clone repository
2. make install

### Compare two JSONs

As "stylish" is default output:

> gendiff first.json second.json

same as

> gendiff --format stylish first.json second.json

### Compare two YML
> gendiff --format stylish first.yml second.yml

### Plain output
> gendiff --format plain first second

### Json output
> gendiff --format json first second

[![asciicast](https://asciinema.org/a/JeUVeE89ThSvqlPH18TMgkdk6.svg)](https://asciinema.org/a/JeUVeE89ThSvqlPH18TMgkdk6)