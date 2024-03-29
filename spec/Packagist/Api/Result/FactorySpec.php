<?php

declare(strict_types=1);

namespace spec\Packagist\Api\Result;

use Packagist\Api\Result\Factory;
use Packagist\Api\Result\Package;
use Packagist\Api\Result\Result;
use PhpSpec\ObjectBehavior;

class FactorySpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Factory::class);
    }

    public function it_creates_search_results(): void
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/search.json'), true);

        $results = $this->create($data);
        $results->shouldHaveCount(2);
        $results->shouldBeArray();
        foreach ($results as $result) {
            $result->shouldBeAnInstanceOf(Result::class);
        }
    }

    public function it_creates_popular_results(): void
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/popular.json'), true);

        $results = $this->create($data);
        $results->shouldHaveCount(2);
        $results->shouldBeArray();
        foreach ($results as $result) {
            $result->shouldBeAnInstanceOf(Result::class);
        }
    }

    public function it_creates_packages(): void
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/get.json'), true);

        $this->create($data)->shouldHaveType(Package::class);
    }

    public function it_creates_composer_packages(): void
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/get_composer.json'), true);

        $results = $this->create($data);
        $results->shouldHaveCount(1);
        $results->shouldBeArray();
        foreach ($results as $result) {
            $result->shouldBeAnInstanceOf(Package::class);

            foreach ($result->getVersions() as $version) {
                $version->shouldBeAnInstanceOf(Package\Version::class);
            }
        }
    }

    public function it_creates_composer_releases_packages(): void
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/v2_get.json'), true);

        $results = $this->create($data);
        $results->shouldHaveCount(1);
        $results->shouldBeArray();
        foreach ($results as $result) {
            $result->shouldBeAnInstanceOf(Package::class);

            foreach ($result->getVersions() as $version) {
                $version->shouldBeAnInstanceOf(Package\Version::class);
            }
        }
    }

    public function it_creates_package_names(): void
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/all.json'), true);

        $this->create($data)->shouldReturn([
            'sylius/addressing-bundle',
            'sylius/assortment-bundle',
            'sylius/blogger-bundle',
        ]);
    }

    public function it_creates_packages_with_missing_optional_data(): void
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/get_nodist.json'), true);

        $this->create($data)->shouldHaveType(Package::class);
    }

    public function it_creates_abandoned_packages(): void
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/get_abandoned.json'), true);

        $this->create($data)->shouldHaveType(Package::class);
    }

    public function it_creates_packages_with_suggesters(): void
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/get_suggesters.json'), true);
        $this->create($data)->shouldHaveType(Package::class);
    }

    public function it_creates_packages_with_dependents(): void
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/get_dependents.json'), true);
        $this->create($data)->shouldHaveType(Package::class);
    }

    public function it_creates_packages_with_null_source(): void
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/get_null_source.json'), true);
        $this->create($data)->shouldHaveType(Package::class);
    }

    public function it_creates_packages_with_null_description(): void
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/get_null_description.json'), true);
        $result = $this->create($data);
        $result->shouldHaveType(Package::class);
        $result->getDescription()->shouldBe('');
    }

    public function it_creates_packages_with_null_downloads(): void
    {
        $data = json_decode(file_get_contents('spec/Packagist/Api/Fixture/get_null_downloads.json'), true);
        $result = $this->create($data);
        $result->shouldHaveType(Package::class);
        $result->getDownloads()->shouldBeNull();
    }

    public function getMatchers(): array
    {
        return array(
            'haveBranch'  => function($subject, $key) {
                return array_key_exists($key, $subject);
            }
        );
    }
}
