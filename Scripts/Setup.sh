#!/usr/bin/env sh

# === Constants ===

TYPO3_VERSION="^8.7"

# === Commands ===

# Install TYPO3 and all other required dependencies
composer require typo3/cms="$TYPO3_VERSION"

# Reset the changes
git checkout composer.json