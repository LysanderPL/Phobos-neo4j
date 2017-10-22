<?php
/**
 * Created by PhpStorm.
 * User: maciej
 * Date: 22.10.17
 * Time: 16:25
 */

namespace AppBundle\Entity\neo4j;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * @OGM\Node(label="Galaxy")
 */
class Galaxy
{
    /**
     * @OGM\GraphId()
     * @var int
     */
    private $id;
    /**
     * @OGM\property(type="string")
     * @var string
     */
    private $name;
    /**
     * @var SolarSystem[]|Collection
     * @OGM\Relationship(type="SOLAR_SYSTEM_IN_GALAXY", direction="OUTGOING", collection=true, mappedBy="galaxy", targetEntity="SolarSystem")
     */
    private $solarSystems;
    /**
     * @var Planet[]|Collection
     * @OGM\Relationship(type="PLANET_IN_GALAXY", direction="OUTGOING", collection=true, mappedBy="galaxy", targetEntity="Planet")
     */
    private $planets;


    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return SolarSystem[]|Collection
     */
    public function getSolarSystems(): Collection
    {
        return $this->solarSystems;
    }

    /**
     * @param SolarSystem[]|Collection $solarSystems
     */
    public function setSolarSystems(Collection $solarSystems)
    {
        $this->solarSystems = $solarSystems;
    }

    /**
     * @return Planet[]|Collection
     */
    public function getPlanets(): Collection
    {
        return $this->planets;
    }

    /**
     * @param Planet[]|Collection $planets
     */
    public function setPlanets(Collection $planets)
    {
        $this->planets = $planets;
    }


}