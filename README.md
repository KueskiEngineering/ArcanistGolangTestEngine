# ArcanistGolangTestEngine
Arcanist Test Engine for Golang Repositories

## How it works
The approach this engine takes is simple. Iterates line by line of STDOUT test execution.
If a FAIL is found, the whole tests is marked as failed. Related to coverage, it looks up for the coverage output lines.
If a package doesn't have any test, the coverage is set to 0, and at the end it calculates the average of all packages.
The test is marked then as FAIL in case the coverage is below the expected.

## Usage Guide
As the usual approach for Arcanist Test Engines, copy the contents of the `golang_test_engine` folder to `.arcanist-extensions` folder.

The script contains an editable section for things listed below:

* The command that is used to execute testing, by default: `go test -v -cover -coverprofile=coverage.out ./...`.
* Coverage percentage, by default: `100.0`.
* Test name, which by default is `Golang Repository Testing`.

If there is a need to customize them, change them in the script itself. These values are setup in constants at the top.

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/KueskiEngineering/ArcanistGolangTestEngine/tags). 

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

## Authors

* **Ernesto Espinosa** - *Initial work* - [enchf](https://github.com/enchf)
