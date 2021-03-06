# ArcanistGolangTestEngine
Arcanist Test Engine for Golang Repositories

## How it works
The approach this engine takes is simple:

* Iterates line by line of STDOUT test execution.
* If a FAIL is found, the whole tests is marked as failed: `--- FAIL: TestSomething (0.00s)`.
* Related to coverage, it looks up for the coverage output lines: `coverage: 100.0% of statements`.
* If a package doesn't have any test, the coverage is set to 0: `?   	host.com/repo/package	[no test files]`.
* At the end, the average of all packages is calculated.
* Test suite is marked as FAIL if average coverage is below the expected.

## Usage Guide
As the usual approach for Arcanist Test Engines, copy the contents of the `golang_test_engine` folder to `.arcanist-extensions` folder.

The script contains an editable section for things listed below:

* Coverage percentage, by default: `100.0`.
* The command that is used to execute testing, by default: `go test -v -cover -coverprofile=coverage.out ./...`.
* Test name, which by default is `Golang Repository Testing`.

If there is a need to customize them, change them in the script itself. These values are setup in constants at the top:

```php
final class GolangTestEngine extends ArcanistUnitTestEngine {
  const MINIMUM_COVERAGE = 100.0;
  const TEST_COMMAND     = 'go test -v -cover -coverprofile=coverage.out ./...';
  const TEST_TITLE       = 'Golang Repository Testing';
```

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/KueskiEngineering/ArcanistGolangTestEngine/tags). 

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

## Authors

* **Ernesto Espinosa** - *Initial work* - [enchf](https://github.com/enchf)
