<?php

namespace spec\Packagist;

use PHPSpec2\ObjectBehavior;
use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;

class Packagist extends ObjectBehavior
{
    /**
     * @param spec\Packagist\TestClient $client
     * @param Guzzle\Http\Message\Request  $request
     * @param Guzzle\Http\Message\Response $response
     */
    function let($client, $request, $response)
    {
        $this->beConstructedWith($client);

        $request->send()->willReturn($response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Packagist');
    }

    function it_search_for_packages($client, $request, $response)
    {
        $client->get('https://packagist.org/search.json?q=sylius')->shouldBeCalled()->willReturn($request);
        $response->getBody(true)->shouldBeCalled()->willReturn('{"results":[{"name":"sylius\/resource-bundle","description":"Resource component for Sylius.","url":"https:\/\/packagist.org\/packages\/sylius\/resource-bundle","downloads":2915,"favers":0},{"name":"sylius\/cart-bundle","description":"Cart feature for your next Symfony2 application.","url":"https:\/\/packagist.org\/packages\/sylius\/cart-bundle","downloads":2109,"favers":0},{"name":"sylius\/assortment-bundle","description":"Manage products, their variants, properties and options in your Symfony2 application.","url":"https:\/\/packagist.org\/packages\/sylius\/assortment-bundle","downloads":2350,"favers":0},{"name":"sylius\/addressing-bundle","description":"Addressing and zone management for Symfony2 applications.","url":"https:\/\/packagist.org\/packages\/sylius\/addressing-bundle","downloads":2149,"favers":0},{"name":"sylius\/flow-bundle","description":"Multiple action setups for Symfony2, build your checkouts\/installers or whatever needs more than one step to complete.","url":"https:\/\/packagist.org\/packages\/sylius\/flow-bundle","downloads":1353,"favers":1},{"name":"sylius\/taxonomies-bundle","description":"Flexible categorization system for Symfony2.","url":"https:\/\/packagist.org\/packages\/sylius\/taxonomies-bundle","downloads":961,"favers":0},{"name":"sylius\/shipping-bundle","description":"Flexible shipping system for Symfony2 ecommerce applications.","url":"https:\/\/packagist.org\/packages\/sylius\/shipping-bundle","downloads":1195,"favers":0},{"name":"sylius\/sales-bundle","description":"Sales order management for Symfony2 applications.","url":"https:\/\/packagist.org\/packages\/sylius\/sales-bundle","downloads":1946,"favers":0},{"name":"sylius\/settings-bundle","description":"Settings system for Symfony2 applications, editable via web user interface.","url":"https:\/\/packagist.org\/packages\/sylius\/settings-bundle","downloads":890,"favers":0},{"name":"sylius\/inventory-bundle","description":"Flexible inventory management for Symfony2 applications.","url":"https:\/\/packagist.org\/packages\/sylius\/inventory-bundle","downloads":1581,"favers":0},{"name":"sylius\/taxation-bundle","description":"Flexible taxation system for Symfony2 ecommerce applications.","url":"https:\/\/packagist.org\/packages\/sylius\/taxation-bundle","downloads":1289,"favers":0},{"name":"sylius\/money-bundle","description":"Sylius integration with PHP Money library.","url":"https:\/\/packagist.org\/packages\/sylius\/money-bundle","downloads":526,"favers":0},{"name":"sylius\/payments-bundle","description":"Flexible payments system for Symfony2 ecommerce applications.","url":"https:\/\/packagist.org\/packages\/sylius\/payments-bundle","downloads":580,"favers":0},{"name":"sylius\/promotions-bundle","description":"Manage promotions in your Symfony2 application.","url":"https:\/\/packagist.org\/packages\/sylius\/promotions-bundle","downloads":570,"favers":0},{"name":"sylius\/core-bundle","description":"Sylius core bundle. It integrates all other bundles into full stack Symfony2 ecommerce solution.","url":"https:\/\/packagist.org\/packages\/sylius\/core-bundle","downloads":925,"favers":0}],"total":23,"next":"https:\/\/packagist.org\/search.json?q=sylius\u0026page=2"}');

        $packages = $this->search('sylius');
        $packages->shouldHaveCount(15);
    }

    function it_gets_package_details($client, $request, $response)
    {
        $client->get('https://packagist.org/p/sylius/sylius.json')->shouldBeCalled()->willReturn($request);
        $response->getBody(true)->shouldBeCalled()->willReturn('{"packages":{"sylius\/sylius":{"dev-checkout":{"name":"sylius\/sylius","description":"Modern ecommerce for Symfony2","keywords":[],"homepage":"","version":"dev-checkout","version_normalized":"dev-checkout","license":["MIT"],"authors":[{"name":"Pawe\u0142 J\u0119drzejewski","email":"pjedrzejewski@diweb.pl","homepage":"http:\/\/pjedrzejewski.com"},{"name":"Sylius project","homepage":"http:\/\/sylius.org"},{"name":"Community contributions","homepage":"http:\/\/github.com\/Sylius\/Sylius\/contributors"}],"source":{"type":"git","url":"https:\/\/github.com\/Sylius\/Sylius.git","reference":"cb0a489db41707d5df078f1f35e028e04ffd9e8e"},"dist":{"type":"zip","url":"https:\/\/api.github.com\/repos\/Sylius\/Sylius\/zipball\/cb0a489db41707d5df078f1f35e028e04ffd9e8e","reference":"cb0a489db41707d5df078f1f35e028e04ffd9e8e","shasum":""},"type":"library","time":"2013-03-01T22:22:37+00:00","autoload":{"psr-0":{"Context":"features\/"}},"extra":{"symfony-app-dir":"sylius","symfony-web-dir":"web"},"require":{"php":">=5.3.3","symfony\/symfony":">=2.2,<2.3-dev","doctrine\/orm":">=2.2.3,<2.4-dev","doctrine\/doctrine-bundle":"1.2.*","doctrine\/doctrine-fixtures-bundle":"*","twig\/extensions":"1.0.*","symfony\/assetic-bundle":"2.1.*","symfony\/swiftmailer-bundle":"2.2.*","symfony\/monolog-bundle":"2.2.*","sensio\/distribution-bundle":"2.2.*","sylius\/core-bundle":"0.1.*","sylius\/web-bundle":"0.1.*","mathiasverraes\/money":"dev-master@dev"},"require-dev":{"behat\/behat":"2.4.*","behat\/symfony2-extension":"*","behat\/mink-extension":"*","behat\/mink-browserkit-driver":"*","phpspec\/phpspec2":"dev-develop","behat\/mink-selenium2-driver":"*"},"uid":40293},"dev-master":{"name":"sylius\/sylius","description":"Modern ecommerce for Symfony2","keywords":[],"homepage":"","version":"dev-master","version_normalized":"9999999-dev","license":["MIT"],"authors":[{"name":"Pawe\u0142 J\u0119drzejewski","email":"pjedrzejewski@diweb.pl","homepage":"http:\/\/pjedrzejewski.com"},{"name":"Sylius project","homepage":"http:\/\/sylius.org"},{"name":"Community contributions","homepage":"http:\/\/github.com\/Sylius\/Sylius\/contributors"}],"source":{"type":"git","url":"https:\/\/github.com\/Sylius\/Sylius.git","reference":"28878fae4de46ce19bb3b72ba373bdb8e0279561"},"dist":{"type":"zip","url":"https:\/\/api.github.com\/repos\/Sylius\/Sylius\/zipball\/28878fae4de46ce19bb3b72ba373bdb8e0279561","reference":"28878fae4de46ce19bb3b72ba373bdb8e0279561","shasum":""},"type":"library","time":"2013-03-09T01:16:45+00:00","autoload":{"psr-0":{"Context":"features\/"}},"extra":{"symfony-app-dir":"sylius","symfony-web-dir":"web"},"require":{"php":">=5.3.3","doctrine\/orm":">=2.2.3,<2.4-dev","doctrine\/doctrine-fixtures-bundle":"*","twig\/extensions":"1.0.*","symfony\/assetic-bundle":"2.1.*","sylius\/core-bundle":"0.1.*","sylius\/web-bundle":"0.1.*","symfony\/symfony":">=2.2,<2.3-dev","doctrine\/doctrine-bundle":"1.2.*","symfony\/swiftmailer-bundle":"2.2.*","symfony\/monolog-bundle":"2.2.*","sensio\/distribution-bundle":"2.2.*","mathiasverraes\/money":"dev-master@dev"},"require-dev":{"behat\/behat":"2.4.*","behat\/symfony2-extension":"*","behat\/mink-extension":"*","behat\/mink-browserkit-driver":"*","phpspec\/phpspec2":"dev-develop","behat\/mink-selenium2-driver":"*"},"uid":32820}}}}');

        $this->get('sylius/sylius');
    }
}

//https://github.com/padraic/mockery/issues/121#issuecomment-13303506
abstract class TestClient implements ClientInterface
{
    public static function getAllEvents()
    {

    }
}

