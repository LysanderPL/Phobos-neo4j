<?php
/**
 * Created by PhpStorm.
 * User: maciej
 * Date: 22.10.17
 * Time: 17:14
 */

namespace AppBundle\Library\Generators;


use AppBundle\Entity\neo4j\Galaxy;
use AppBundle\Entity\neo4j\Planet;
use AppBundle\Entity\neo4j\SolarSystem;
use GraphAware\Neo4j\OGM\Common\Collection;

class GalaxyGenerator
{

    /**
     * @param Galaxy $galaxy
     * @return SolarSystem[]|Collection
     */
    public function prepareSolarSystems(Galaxy $galaxy)
    {
        $solarSystemsCollection = $this->prepareSolarSystemsCollection($galaxy, $this->loadCsv());
        $solarSystemsCollection = $this->prepareNearbySolarSystems($solarSystemsCollection);

        return $solarSystemsCollection;
    }

    /**
     * @return array
     */
    private function loadCsv(): array
    {
        $path = "";
        for ($i = 0; $i < 5; $i++) {
            if (!file_exists($path . "additionals/exoplanet.eu_catalog.csv")) {
                $path .= "../";
            } else {
                break;
            }
        }
        $csv = array_map('str_getcsv', file($path . "additionals/exoplanet.eu_catalog.csv"));
        unset($csv[0]);
        return $csv;
    }

    /**
     * @param Galaxy $galaxy
     * @param array $chunk
     * @param SolarSystem $solarSystem
     * @return Collection
     */
    private function preparePlanetCollectionForChunk(Galaxy $galaxy, array $chunk, SolarSystem $solarSystem): Collection
    {
        $planetCollection = new Collection();
        foreach ($chunk as $planetData) {
            $planet = new Planet();
            $planet->setGalaxy($galaxy);
            $planet->setName($planetData[0]);
            $planet->setSolarSystem($solarSystem);
            $planetCollection->add($planet);
        }

        /**
         * @var Planet $item
         */
        foreach ($planetCollection->getIterator() as $key => $item) {
            if ($key % 5 === 0) {
                $tmpCollection = clone $planetCollection;
                $tmpCollection->remove($key);
                $item->setNearbyPlanets($tmpCollection);
            }
        }

        return $planetCollection;
    }

    /**
     * @param Galaxy $galaxy
     * @param array $csv
     * @return Collection
     */
    private function prepareSolarSystemsCollection(Galaxy $galaxy, array $csv): Collection
    {
        $solarSystemsCollection = new Collection();

        foreach (array_chunk($csv, 78) as $chunk) {
            foreach (array_chunk($chunk, random_int(4, 25)) as $smallerChunk) {
                $solarSystem = new SolarSystem();
                $solarSystem->setGalaxy($galaxy);
                $solarSystem->setPlanets($this->preparePlanetCollectionForChunk($galaxy, $smallerChunk, $solarSystem));
                $solarSystemsCollection->add($solarSystem);
            }
        }
        return $solarSystemsCollection;
    }

    /**
     * @param Collection $solarSystemsCollection
     * @return Collection
     */
    private function prepareNearbySolarSystems(Collection $solarSystemsCollection): Collection
    {
        /**
         * @var SolarSystem[] $smallerChunk
         * @var SolarSystem $last
         */
        $prev = null;
        foreach (array_chunk($solarSystemsCollection->toArray(), 50) as $chunk) {
            foreach ($smallerChunks = array_chunk($chunk, random_int(1, 5)) as $smallerChunk) {
                $tmp = $smallerChunk;
                unset($tmp[0]);
                if (!is_null($prev)) {
                    $tmp = array_merge($prev, $tmp);
                }
                if (count($smallerChunk) % 2 === 0) {
                    $randomChunk = array_rand($smallerChunks);
                    if ($smallerChunks[$randomChunk] != $smallerChunk) {
                        $tmp = array_merge($tmp, $smallerChunks[$randomChunk]);
                    }
                }

                $smallerChunk[0]->setNearbySolarSystems(new Collection($tmp));
                $prev = [$smallerChunk[0]];
            }
        }

        $last = $smallerChunks[count($smallerChunks) - 1][0];
        $last->setNearbySolarSystems(new Collection(array_merge($last->getNearbySolarSystems()->toArray(), $smallerChunks[0])));
        return $solarSystemsCollection;
    }
}