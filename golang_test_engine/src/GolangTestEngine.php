<?php

/**
 * Golang Test Runner
 */
final class GolangTestEngine extends ArcanistUnitTestEngine {
  const MINIMUM_COVERAGE = 100.0;
  const TEST_COMMAND     = 'go test -v -cover -coverprofile=coverage.out ./...';
  const TEST_TITLE       = 'Golang Repository Testing';

  const NO_TESTS_PREFIX  = '?';
  const COVERAGE_PREFIX  = 'coverage';
  const FAIL             = 'FAIL';
  
  public function run() {
    $results = array();
    $command = new ExecFuture(self::TEST_COMMAND);
    list($err, $stdout, $stderr) = $command->resolve();

    $result = new ArcanistUnitTestResult();
    $result->setName(self::TEST_TITLE);
    list($success, $message) = self::processTestOutput($stdout);

    $result->setResult($success ? ArcanistUnitTestResult::RESULT_PASS : ArcanistUnitTestResult::RESULT_FAIL);
    
    if (!is_null($message)) {
      $result->setUserData('  ' . $message);
    }

    $results[] = $result;
    sleep(0.75);
    
    return $results; 
  }

  public function shouldEchoTestResults() {
    return true;
  }

  /**
   * processTestOutput - Parses test execution output.
   * Returns a tuple with two values: array(success, message).
   * success - boolean value whether the testing is successful or not.
   * message - message to output when arc unit command is executed.
   */
  function processTestOutput($output) {
    $lines = explode("\n", $output);
    $coverages = array();
    $zerosFound = 0;
    $minimumCoverage = intval(self::MINIMUM_COVERAGE * 100);
    $command = self::TEST_COMMAND;

    foreach ($lines as $line) {
      if (strpos($line, self::FAIL) !== false) {
        return array(false, "Golang tests have failed. Please run '$command' for more details.\n");
      }

      if (self::startsWith($line, self::NO_TESTS_PREFIX)) {
        $zerosFound = $zerosFound + 1;
      } else if (self::startsWith($line, self::COVERAGE_PREFIX)) {
        $start = strpos($line, ':') + 2;
        $length = strpos($line, '%') - $start;
        $percentage = substr($line, $start, $length);

        array_push($coverages, floatval($percentage));
      }
    }

    if (count($coverages) > 0) {
      // Add the zeros found to the coverages.
      $coverages = array_merge($coverages, array_fill(0, $zerosFound, 0));
      $coverageAverage = intval((array_sum($coverages) / count($coverages)) * 100);

      if ($coverageAverage < $minimumCoverage) {
        return array(false, sprintf("Actual coverage (%0.2f%%) is below the minimum required (%0.2f%%).\n",
                                    ($coverageAverage / 100.0), ($minimumCoverage / 100.0)));
      }
    }

    return array(true, null);
  }

  function startsWith($string, $prefix) {
    return strpos($string, $prefix) === 0;
  }
}
