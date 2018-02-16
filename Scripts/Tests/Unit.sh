#!/usr/bin/env sh

# === Exports ===

export BUILD_PATH="$PWD/.build"
export BIN_PATH="$BUILD_PATH/bin"
export VENDOR_PATH="$BUILD_PATH/vendor"
export TYPO3_PATH_WEB="$BUILD_PATH/web"
export TESTING_FRAMEWORK_PATH="$VENDOR_PATH/nimut/testing-framework/res/Configuration";

# === Unit Tests ===

$BIN_PATH/phpunit --colors --configuration $TESTING_FRAMEWORK_PATH/UnitTests.xml Tests/Unit

# find "Tests/Unit" -wholename "*Test.php" | parallel --gnu "$BIN_PATH/phpunit --colors --configuration $TESTING_FRAMEWORK_PATH/UnitTests.xml {}"