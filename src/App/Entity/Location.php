<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="location")
 */
/*final */class Location
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=1024, nullable=false)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(name="address", type="string", length=1024, nullable=false)
     * @var string
     */
    private $address;

    /**
     * @ORM\Column(name="url", type="string", length=1024, nullable=false)
     * @var string
     */
    private $url;

    private function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public static function fromNameAddressAndUrl(string $name, string $address, string $url) : self
    {
        $location = new self();
        $location->name = $name;
        $location->address = $address;
        $location->url = $url;
        return $location;
    }

    /**
     * @param string $name
     * @param string $address
     * @param string $url
     * @return void
     */
    public function updateFromData(string $name, string $address, string $url)
    {
        $this->name = $name;
        $this->address = $address;
        $this->url = $url;
    }

    public function getId() : string
    {
        return (string)$this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getAddress() : string
    {
        return $this->address;
    }

    public function getUrl() : string
    {
        return $this->url;
    }
}
