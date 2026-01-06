<?php
/**
 * MLE Configuration Test Runner
 * 
 * This script tests all 45 MLE configuration methods to verify they can be instantiated correctly.
 * It demonstrates the various MLE configuration scenarios available in the SDK.
 * 
 * Usage: php TestMLEConfigurations.php [test_number]
 * - Run without arguments to see all available tests
 * - Run with a test number (1-45) to test a specific configuration
 * - Run with 'all' to test all configurations
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../vendor/autoload.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../../Resources/ConfigurationWithMLE.php';

class MLEConfigurationTester
{
    private $configWithMLE;
    private $testResults = [];

    public function __construct()
    {
        $this->configWithMLE = new CyberSource\ConfigurationWithMLE();
    }

    /**
     * Get all available test configurations
     */
    public function getAllTests()
    {
        return [
            // GROUP 1: File-Based Response MLE
            1 => ['method' => 'getResponseMleP12CorrectEnabled', 'group' => 'File-Based Response MLE', 'description' => 'P12 file with correct password, Response MLE enabled'],
            2 => ['method' => 'getResponseMleP12CorrectDisabled', 'group' => 'File-Based Response MLE', 'description' => 'P12 file with correct password, Response MLE disabled'],
            3 => ['method' => 'getResponseMlePemUnencrypted', 'group' => 'File-Based Response MLE', 'description' => 'PEM file (unencrypted) with Response MLE enabled'],
            4 => ['method' => 'getResponseMlePemEncrypted', 'group' => 'File-Based Response MLE', 'description' => 'PEM file (encrypted) with correct password'],
            5 => ['method' => 'getResponseMleP8Unencrypted', 'group' => 'File-Based Response MLE', 'description' => 'P8 file (unencrypted) with Response MLE enabled'],
            6 => ['method' => 'getResponseMleP8Encrypted', 'group' => 'File-Based Response MLE', 'description' => 'P8 file (encrypted) with correct password'],
            7 => ['method' => 'getResponseMleKeyUnencrypted', 'group' => 'File-Based Response MLE', 'description' => 'KEY file (unencrypted) with Response MLE enabled'],
            8 => ['method' => 'getResponseMleKeyEncrypted', 'group' => 'File-Based Response MLE', 'description' => 'KEY file (encrypted) with correct password'],

            // GROUP 2: Private Key Object
            9 => ['method' => 'getResponseMlePrivateKeyObjectEnabled', 'group' => 'Private Key Object', 'description' => 'Private key object with Response MLE enabled'],
            10 => ['method' => 'getResponseMlePrivateKeyObjectDisabled', 'group' => 'Private Key Object', 'description' => 'Private key object with Response MLE disabled'],

            // GROUP 3: Incorrect Password Scenarios
            11 => ['method' => 'getResponseMleP12IncorrectPasswordEnabled', 'group' => 'Incorrect Password', 'description' => 'P12 file with incorrect password, Response MLE enabled'],
            12 => ['method' => 'getResponseMleP12IncorrectPasswordDisabled', 'group' => 'Incorrect Password', 'description' => 'P12 file with incorrect password, Response MLE disabled'],
            13 => ['method' => 'getResponseMlePemIncorrectPassword', 'group' => 'Incorrect Password', 'description' => 'Encrypted PEM file with incorrect password'],
            14 => ['method' => 'getResponseMleP8IncorrectPassword', 'group' => 'Incorrect Password', 'description' => 'Encrypted P8 file with incorrect password'],
            15 => ['method' => 'getResponseMleKeyIncorrectPassword', 'group' => 'Incorrect Password', 'description' => 'Encrypted KEY file with incorrect password'],
            16 => ['method' => 'getResponseMlePfxIncorrectPassword', 'group' => 'Incorrect Password', 'description' => 'PFX file with incorrect password'],

            // GROUP 4: Incorrect Private Key Object
            17 => ['method' => 'getResponseMleIncorrectPrivateKeyObjectEnabled', 'group' => 'Incorrect Private Key', 'description' => 'Incorrect private key object, Response MLE enabled'],
            18 => ['method' => 'getResponseMleIncorrectPrivateKeyObjectDisabled', 'group' => 'Incorrect Private Key', 'description' => 'Incorrect private key object, Response MLE disabled'],

            // GROUP 5: Incorrect File Paths
            19 => ['method' => 'getResponseMleIncorrectPemPath', 'group' => 'Incorrect File Path', 'description' => 'Non-existent PEM file path'],
            20 => ['method' => 'getResponseMleIncorrectP8Path', 'group' => 'Incorrect File Path', 'description' => 'Non-existent P8 file path'],
            21 => ['method' => 'getResponseMleIncorrectKeyPath', 'group' => 'Incorrect File Path', 'description' => 'Non-existent KEY file path'],
            22 => ['method' => 'getResponseMleIncorrectP12Path', 'group' => 'Incorrect File Path', 'description' => 'Non-existent P12/PFX file path'],

            // GROUP 6: Non-MLE Response
            23 => ['method' => 'getResponseMleEnabledNonEncryptedApi', 'group' => 'Non-MLE Response', 'description' => 'Response MLE enabled but API returns non-encrypted response'],
            24 => ['method' => 'getResponseMleDisabledNonEncryptedApi', 'group' => 'Non-MLE Response', 'description' => 'Response MLE disabled and API returns non-encrypted response'],

            // GROUP 7: mapToControlMLEonAPI String Format
            25 => ['method' => 'getMleJwtGlobalEnabledApiOverrideTrue', 'group' => 'mapToControlMLEonAPI', 'description' => 'JWT + Global enabled + API override ::true'],
            26 => ['method' => 'getMleJwtGlobalDisabledApiRequestResponseTrue', 'group' => 'mapToControlMLEonAPI', 'description' => 'JWT + Global disabled + API-level true::true'],
            27 => ['method' => 'getMleJwtGlobalDisabledApiResponseOnlyTrue', 'group' => 'mapToControlMLEonAPI', 'description' => 'JWT + Global disabled + API-level false::true'],
            28 => ['method' => 'getMleJwtGlobalEnabledApiOverrideFalse', 'group' => 'mapToControlMLEonAPI', 'description' => 'JWT + Global enabled + API override ::false'],
            29 => ['method' => 'getMleJwtGlobalDisabledApiResponseFalse', 'group' => 'mapToControlMLEonAPI', 'description' => 'JWT + Global disabled + API-level ::false'],
            30 => ['method' => 'getMleJwtGlobalDisabledApiRequestOnlyTrue', 'group' => 'mapToControlMLEonAPI', 'description' => 'JWT + Global disabled + API-level true::false'],
            31 => ['method' => 'getMleJwtGlobalDisabledApiBothFalse', 'group' => 'mapToControlMLEonAPI', 'description' => 'JWT + Global disabled + API-level false::false'],

            // GROUP 8: HTTP Signature Auth
            32 => ['method' => 'getMleHttpSignatureGlobalEnabled', 'group' => 'HTTP Signature Auth', 'description' => 'HTTP Signature + Global Response MLE enabled'],
            33 => ['method' => 'getMleHttpSignatureGlobalDisabledApiResponseTrue', 'group' => 'HTTP Signature Auth', 'description' => 'HTTP Signature + Global disabled + API-level Response MLE'],

            // GROUP 9: JWT Base Cases
            34 => ['method' => 'getMleJwtOnlyNoMle', 'group' => 'JWT Base Cases', 'description' => 'JWT only (no MLE)'],
            35 => ['method' => 'getMleJwtGlobalResponseDisabled', 'group' => 'JWT Base Cases', 'description' => 'JWT + Global Response MLE disabled'],

            // GROUP 10: Invalid Format Testing
            36 => ['method' => 'getMleInvalidFormatSingleColon', 'group' => 'Invalid Format', 'description' => 'Invalid format - single colon :true'],
            37 => ['method' => 'getMleInvalidFormatTooManyParts', 'group' => 'Invalid Format', 'description' => 'Invalid format - too many parts ::true::true'],
            38 => ['method' => 'getMleInvalidFormatTrailingColons', 'group' => 'Invalid Format', 'description' => 'Invalid format - trailing colons ::true::'],
            39 => ['method' => 'getMleInvalidFormatThreeColons', 'group' => 'Invalid Format', 'description' => 'Invalid format - three colons :::true'],

            // GROUP 11: JWT + Request MLE
            40 => ['method' => 'getJwtUseMLEGloballyTrue', 'group' => 'JWT + Request MLE', 'description' => 'JWT + useMLEGlobally=true (deprecated)'],
            41 => ['method' => 'getJwtEnableRequestMLEGloballyTrue', 'group' => 'JWT + Request MLE', 'description' => 'JWT + enableRequestMLEForOptionalApisGlobally=true'],
            42 => ['method' => 'getJwtGlobalEnabledApiOverrideTrue', 'group' => 'JWT + Request MLE', 'description' => 'JWT + Global enabled + API override with boolean true'],
            43 => ['method' => 'getJwtGlobalDisabledApiRequestTrueString', 'group' => 'JWT + Request MLE', 'description' => 'JWT + Global disabled + API-level true::'],
            44 => ['method' => 'getJwtGlobalDisabledApiRequestTrueResponseFalse', 'group' => 'JWT + Request MLE', 'description' => 'JWT + Global disabled + API-level true::false'],
            45 => ['method' => 'getJwtGlobalDisabledApiRequestResponseBothTrue', 'group' => 'JWT + Request MLE', 'description' => 'JWT + Global disabled + API-level true::true'],
        ];
    }

    /**
     * Display all available tests
     */
    public function displayAllTests()
    {
        echo "\n" . str_repeat("=", 80) . "\n";
        echo "MLE CONFIGURATION TEST SUITE - 45 Test Cases\n";
        echo str_repeat("=", 80) . "\n\n";

        $tests = $this->getAllTests();
        $currentGroup = '';

        foreach ($tests as $testNum => $testInfo) {
            if ($currentGroup !== $testInfo['group']) {
                $currentGroup = $testInfo['group'];
                echo "\n" . str_repeat("-", 80) . "\n";
                echo "GROUP: {$currentGroup}\n";
                echo str_repeat("-", 80) . "\n";
            }
            echo sprintf("  [%2d] %s\n", $testNum, $testInfo['description']);
        }

        echo "\n" . str_repeat("=", 80) . "\n";
        echo "Usage:\n";
        echo "  php TestMLEConfigurations.php [test_number]  - Run specific test (1-45)\n";
        echo "  php TestMLEConfigurations.php all            - Run all tests\n";
        echo "  php TestMLEConfigurations.php                - Show this help\n";
        echo str_repeat("=", 80) . "\n\n";
    }

    /**
     * Run a specific test
     */
    public function runTest($testNum)
    {
        $tests = $this->getAllTests();
        
        if (!isset($tests[$testNum])) {
            echo "Error: Test #{$testNum} not found.\n";
            return false;
        }

        $testInfo = $tests[$testNum];
        $method = $testInfo['method'];

        echo "\n" . str_repeat("=", 80) . "\n";
        echo "Running Test #{$testNum}: {$testInfo['description']}\n";
        echo "Group: {$testInfo['group']}\n";
        echo "Method: {$method}()\n";
        echo str_repeat("=", 80) . "\n\n";

        try {
            $config = $this->configWithMLE->$method();
            
            echo "✓ Configuration created successfully\n";
            echo "\nConfiguration Details:\n";
            echo "  - Authentication Type: " . $config->getAuthenticationType() . "\n";
            echo "  - Merchant ID: " . $config->getMerchantID() . "\n";
            echo "  - Run Environment: " . $config->getRunEnvironment() . "\n";
            
            // Display MLE settings if available
            $this->displayMLESettings($config);
            
            echo "\n✓ Test #{$testNum} PASSED\n";
            echo str_repeat("=", 80) . "\n\n";
            
            $this->testResults[$testNum] = ['status' => 'PASSED', 'error' => null];
            return true;

        } catch (Exception $e) {
            echo "✗ Configuration failed\n";
            echo "Error: " . $e->getMessage() . "\n";
            echo "\n✗ Test #{$testNum} FAILED\n";
            echo str_repeat("=", 80) . "\n\n";
            
            $this->testResults[$testNum] = ['status' => 'FAILED', 'error' => $e->getMessage()];
            return false;
        }
    }

    /**
     * Display MLE settings from configuration
     */
    private function displayMLESettings($config)
    {
        echo "\nMLE Settings:\n";
        
        // Request MLE settings
        try {
            $requestMleEnabled = method_exists($config, 'getEnableRequestMLEForOptionalApisGlobally') 
                ? $config->getEnableRequestMLEForOptionalApisGlobally() 
                : 'N/A';
            echo "  - Request MLE Globally: " . ($requestMleEnabled === true ? 'Enabled' : ($requestMleEnabled === false ? 'Disabled' : $requestMleEnabled)) . "\n";
        } catch (Exception $e) {
            // Method might not exist
        }

        // Response MLE settings
        try {
            $responseMleEnabled = method_exists($config, 'getEnableResponseMleGlobally') 
                ? $config->getEnableResponseMleGlobally() 
                : 'N/A';
            echo "  - Response MLE Globally: " . ($responseMleEnabled === true ? 'Enabled' : ($responseMleEnabled === false ? 'Disabled' : $responseMleEnabled)) . "\n";
        } catch (Exception $e) {
            // Method might not exist
        }

        // API-level control
        try {
            $apiControl = method_exists($config, 'getMapToControlMLEonAPI') 
                ? $config->getMapToControlMLEonAPI() 
                : null;
            if ($apiControl && is_array($apiControl) && count($apiControl) > 0) {
                echo "  - API-Level Control:\n";
                foreach ($apiControl as $api => $setting) {
                    echo "      {$api}: {$setting}\n";
                }
            }
        } catch (Exception $e) {
            // Method might not exist
        }
    }

    /**
     * Run all tests
     */
    public function runAllTests()
    {
        $tests = $this->getAllTests();
        $totalTests = count($tests);
        $passedTests = 0;
        $failedTests = 0;

        echo "\n" . str_repeat("=", 80) . "\n";
        echo "RUNNING ALL {$totalTests} MLE CONFIGURATION TESTS\n";
        echo str_repeat("=", 80) . "\n";

        foreach ($tests as $testNum => $testInfo) {
            $result = $this->runTest($testNum);
            if ($result) {
                $passedTests++;
            } else {
                $failedTests++;
            }
            
            // Add a small delay between tests
            usleep(100000); // 0.1 second
        }

        // Display summary
        $this->displaySummary($totalTests, $passedTests, $failedTests);
    }

    /**
     * Display test summary
     */
    private function displaySummary($total, $passed, $failed)
    {
        echo "\n" . str_repeat("=", 80) . "\n";
        echo "TEST SUMMARY\n";
        echo str_repeat("=", 80) . "\n";
        echo "Total Tests:  {$total}\n";
        echo "Passed:       {$passed} (" . round(($passed/$total)*100, 2) . "%)\n";
        echo "Failed:       {$failed} (" . round(($failed/$total)*100, 2) . "%)\n";
        echo str_repeat("=", 80) . "\n";

        if ($failed > 0) {
            echo "\nFailed Tests:\n";
            foreach ($this->testResults as $testNum => $result) {
                if ($result['status'] === 'FAILED') {
                    $tests = $this->getAllTests();
                    echo "  [#{$testNum}] {$tests[$testNum]['description']}\n";
                    echo "          Error: {$result['error']}\n";
                }
            }
            echo str_repeat("=", 80) . "\n";
        }

        echo "\n";
    }
}

// Main execution
if (!defined('DO_NOT_RUN_SAMPLES')) {
    $tester = new MLEConfigurationTester();

    if ($argc < 2) {
        // No arguments - display help
        $tester->displayAllTests();
    } elseif ($argv[1] === 'all') {
        // Run all tests
        $tester->runAllTests();
    } elseif (is_numeric($argv[1])) {
        // Run specific test
        $testNum = (int)$argv[1];
        $tester->runTest($testNum);
    } else {
        echo "Invalid argument. Use 'all' or a test number (1-45).\n";
        $tester->displayAllTests();
    }
}
?>
