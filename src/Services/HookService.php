<?php


namespace App\Services;


class HookService
{
    /**
     * @var HookService|null
     */
    private static ?HookService $_instance = null;

    private array $hookList = [
        'BOOK_FROM' => [],
        'BOOK_TO' => [],
        'ADMIN_STATS' => [],
    ];

    public static function getInstance(): HookService
    {
        if (self::$_instance === null) {
            self::$_instance = new HookService();
        }
        return self::$_instance;
    }

    private function __construct()
    {

    }

    public function register($point, $object) {
        $this->hookList[$point][] = $object;
    }

    public function execute($hook_point, $params) {
        foreach($this->hookList[$hook_point] as $hook) {
            $params = $hook->run($hook_point, $params);
        }
        return $params;
    }
}