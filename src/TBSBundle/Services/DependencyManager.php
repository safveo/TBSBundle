<?php


namespace Time\TBSBundle\Services;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DependencyManager
{
    private $container;
    private $em;


    public function __construct(ContainerInterface $containerInterface)
    {
        /**  get container*/
        $this->container = $containerInterface;

        /**  get entity manager */
        $this->em = $containerInterface->get('doctrine')->getManager();
    }


    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    public function getManager()
    {
        return $this->em;
    }
}