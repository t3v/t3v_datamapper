#!/usr/bin/env sh

# === Variables ===

BASE_PATH=$(dirname "$0")
ROOT_PATH="$BASE_PATH/../.."

# === Exports ===

export BUILD_PATH="$ROOT_PATH/.build"
export BIN_PATH="$BUILD_PATH/bin"
export VENDOR_PATH="$BUILD_PATH/vendor"
export TESTING_FRAMEWORK_BUILD_PATH="$VENDOR_PATH/typo3/testing-framework/Resources/Core/Build";

# === Commands ===

"$BIN_PATH/phpunit" --configuration "$TESTING_FRAMEWORK_BUILD_PATH/UnitTests.xml" --migrate-configuration

# Try to keep environment pollution down, EPA loves us:
unset BASE_PATH ROOT_PATH
