# Upgrade notes

## 1.6.0 (unreleased)

* `Packagist\Api\Result\Package::isAbandoned()` is now deprecated. Use `Packagist\Api\Result\Package::isAbandoned()`
  instead, which returns a boolean or a string (package name to use as a replacement).
* `Packagist\Api\Result\Package\Version::isAbandoned()` is now deprecated. See above.
* Dropped support for PHP lower than 7.1.0.
