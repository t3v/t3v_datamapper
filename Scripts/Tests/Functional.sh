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
export typo3DatabaseName="typo3";

# === Functional Tests ===

find 'Tests/Functional' -wholename '*Test.php' | parallel --gnu "$BIN_PATH/phpunit --colors -c $TESTING_FRAMEWORK_PATH/FunctionalTests.xml {}"