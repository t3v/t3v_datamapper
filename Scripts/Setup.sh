#!/usr/bin/env sh

# === Constants ===

TYPO3_VERSION="^8.7"
TYPO3_VERSION_DIGITS=${TYPO3_VERSION//[^[:digit:]]/}
TYPO3_MAJOR_VERSION="${TYPO3_VERSION_DIGITS::1}"

# === Commands ===

# Remove Composer lock file if available
if [ -f composer.lock ]; then
  rm composer.lock
fi

# Require the core library of TYPO3
composer require typo3/cms-core="$TYPO3_VERSION"

# Reset the changes
git checkout composer.json

# Try to keep environment pollution down, EPA loves us
unset TYPO3_VERSION TYPO3_VERSION_DIGITS TYPO3_MAJOR_VERSION
