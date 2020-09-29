<?php

namespace Noud\ProductOfferBundle\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\ExistsFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;
use Noud\UtilBundle\Filter\RegexpFilter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * An offer from my shop - this description will be automatically extracted from the PHPDoc to document the API.
 *
 * @ApiResource(iri="http://schema.org/Offer")
 * @ ApiFilter(RegexpFilter::class)
 * @ ApiFilter(DateFilter::class, properties={"createdAt": DateFilter::EXCLUDE_NULL})
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "price": "exact", "description": "partial", "product": "exact"})
 * @ ApiFilter(BooleanFilter::class, properties={"isAvailableGenericallyInMyCountry"})
 * @ ApiFilter(NumericFilter::class, properties={"sold"})
 * @ApiFilter(RangeFilter::class, properties={"price"})
 * @ ApiFilter(ExistsFilter::class, properties={"transportFees"})
 * @ApiFilter(OrderFilter::class, properties={"id", "name"}, arguments={"orderParameterName"="order"})
 * @ORM\Entity
 */
class Offer
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    public $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\Range(min=0, minMessage="The price must be superior to 0.")
     * @Assert\Type(type="float")
     */
    public $price;

    /**
     * @ORM\Column(type="bool")
     * @Assert\Type(type="bool")
     */
    public $availableGenericallyInMyCountry = true;

    /**
     * @ORM\Column(type="bool", nullable=true)
     * @Assert\Type(type="bool")
     */
    public $sold = false;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="offers")
     */
    public $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAvailableGenericallyInMyCountry(): bool
    {
        return $this->availableGenericallyInMyCountry;
    }
}
