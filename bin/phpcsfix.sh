#!/bin/bash
set -e

# Some fixing
php-cs-fixer fix

# Some linting
bin/console lint:yaml --parse-tags **/*.yaml
bin/console lint:container
bin/console lint:twig templates
