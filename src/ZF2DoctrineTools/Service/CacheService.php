<?php
namespace ZF2DoctrineTools\Service;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property array    $cacheArray
 */
class CacheService
{

    protected $cacheArray = array();

    const FIVE_MINUTES   = 300;
    const TEN_MINUTES    = 600;
    const THIRTY_MINUTES = 1800;
    const ONE_HOUR       = 3600;
    const ONE_DAY        = 86400;
    const THREE_DAYS     = 259200;
    const ONE_WEEK       = 604800;
    const TWO_WEEKS      = 1209600;
    const FOUR_WEEKS     = 2419200;

    public function getCache($namespace, $ttl = self::FIVE_MINUTES)
    {
        $arrayKey = $namespace . '-' . $ttl;
        if (!array_key_exists($arrayKey, $this->cacheArray)) {
            $this->cacheArray[$arrayKey] = \Zend\Cache\StorageFactory::factory([
                'adapter' => [
                    'name'    => 'filesystem',
                    'options' => [
                        'namespace'   => $namespace,
                        'ttl'         => $ttl,
                        'cache_dir'   => 'data/cache',
                        'key_pattern' => '/^[\\a-z0-9_\+\-\[\]\$]*$/Di',
                        'dir_permission' => 0770,
                        'file_permission' => 0660,
                    ],
                ],
                'plugins' => [
                    'exception_handler' => [
                        'throw_exceptions' => false
                    ],
                    'Serializer',
                ]
            ]);
        }
        return $this->cacheArray[$arrayKey];
    }
}