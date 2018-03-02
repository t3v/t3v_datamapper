#!/usr/bin/env sh

# === Variables ===

TYPO3_VERSION="^8.7"
TYPO3_VERSION_DIGITS=${TYPO3_VERSION//[^[:digit:]]/}
TYPO3_MAJOR_VERSION="${TYPO3_VERSION_DIGITS::1}"

# === Commands ===

# Remove Composer lock file if available
if [ -f composer.lock ]; then
  rm composer.lock
fi

# Require TYPO3 including dependencies, for MAJOR version >= 9 require `typo3/minimal`, otherwise `typo3/cms`
if [ $TYPO3_MAJOR_VERSION -ge 9 ]; then
  composer require typo3/minimal="$TYPO3_VERSION"
else
  composer require typo3/cms="$TYPO3_VERSION"
fi

# Reset the changes
git checkout composer.json

# Try to keep environment pollution down, EPA loves us
unset TYPO3_VERSION TYPO3_VERSION_DIGITS TYPO3_MAJOR_VERSION