#!/usr/bin/env sh

# === Constants ===

TYPO3_VERSION="^7.6"
TYPO3_VERSION_DIGITS=${TYPO3_VERSION//[^[:digit:]]/}
TYPO3_MAJOR_VERSION="${TYPO3_VERSION_DIGITS::1}"

# === Commands ===

# Remove Composer lock file if available
if [ -f composer.lock ]; then
  rm composer.lock
fi

# Require TYPO3 including dependencies
composer require typo3/cms="$TYPO3_VERSION"

# Reset the changes
git checkout composer.json

# Try to keep environment pollution down, EPA loves us
unset TYPO3_VERSION TYPO3_VERSION_DIGITS TYPO3_MAJOR_VERSION
