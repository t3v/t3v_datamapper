#!/usr/bin/env sh

# === Exports ===

export BUILD_PATH="$PWD/.Build"
export BIN_PATH="$BUILD_PATH/bin"
export VENDOR_PATH="$BUILD_PATH/vendor"
export TYPO3_PATH_WEB="$BUILD_PATH/Web"
export TESTING_FRAMEWORK_PATH="$VENDOR_PATH/nimut/testing-framework/res/Configuration";

export typo3DatabaseHost="localhost";
export typo3DatabaseUsername="root";
export typo3DatabasePassword="";
export typo3DatabaseName="t3v_datamapper";

# === Functional Tests ===

$BIN_PATH/phpunit --colors --configuration $TESTING_FRAMEWORK_PATH/FunctionalTests.xml Tests/Functional

# find "Tests/Functional" -wholename "*Test.php" | parallel --gnu "$BIN_PATH/phpunit --colors --configuration $TESTING_FRAMEWORK_PATH/FunctionalTests.xml {}"