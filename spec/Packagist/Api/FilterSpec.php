<?php

namespace spec\Packagist\Api;

use PhpSpec\ObjectBehavior;

class FilterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Packagist\Api\Filter');
    }

    public function it_change_type()
    {
        $this->getType()->shouldBeEqualTo(null);
        $this->setType("myType")->shouldBeEqualTo($this);
        $this->getType()->shouldBeEqualTo("myType");
    }

    public function it_change_vendor()
    {
        $this->getVendor()->shouldBeEqualTo(null);
        $this->setVendor("myVendor")->shouldBeEqualTo($this);
        $this->getVendor()->shouldBeEqualTo("myVendor");
    }

    public function it_add_tag()
    {
        $this->getTags()->shouldBeEqualTo(array());
        $this->addTag("myTag")->shouldBeEqualTo($this);
        $this->getTags()->shouldBeEqualTo(array("myTag"));
    }

    public function it_reset_tag()
    {
        $this->addTag("myTag")->shouldBeEqualTo($this);
        $this->getTags()->shouldBeEqualTo(array("myTag"));
        $this->resetTags()->shouldBeEqualTo($this);
        $this->getTags()->shouldBeEqualTo(array());
    }

    public function it_should_return_http_query_representation()
    {
        $this->addTag("myTag")
             ->addTag("myOtherTag")
             ->setVendor("myVendor")
             ->setType("myType");

        $this->getHttpQuery()->shouldBeEqualTo('tags[]=myTag&tags[]=myOtherTag&vendor=myVendor&type=myType');
    }
}
