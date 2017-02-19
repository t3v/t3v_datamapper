#!/usr/bin/env sh

# === Exports ===

export TYPO3_PATH_WEB=$PWD/.Build/Web

if [ -d .Build/vendor/typo3/cms/components/testing_framework/Resources/Core/Build ]; then
  export TYPO3_PATH_BUILD=".Build/vendor/typo3/cms/components/testing_framework/Resources/Core/Build"
else
  export TYPO3_PATH_BUILD=".Build/vendor/typo3/cms/typo3/sysext/core/Build"
fi

export typo3DatabaseHost="localhost";
export typo3DatabaseUsername="root";
export typo3DatabasePassword="";
export typo3DatabaseName="typo3";

# === Functional Tests ===

find 'Tests/Functional' -wholename '*Test.php' | parallel --gnu '.Build/bin/phpunit --colors -c $TYPO3_PATH_BUILD/FunctionalTests.xml {}'