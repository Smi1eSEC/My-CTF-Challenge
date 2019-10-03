<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------
namespace think\console\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\console\Table;
use think\Container;
use think\facade\App;
use think\facade\Route;

class RouteList extends Command
{
    protected $sortBy = [
        'rule'   => 0,
        'route'  => 1,
        'method' => 2,
        'name'   => 3,
        'domain' => 4,
    ];

    protected function configure()
    {
        $this->setName('route:list')
            ->addArgument('app', Argument::OPTIONAL, 'app name .')
            ->addArgument('style', Argument::OPTIONAL, "the style of the table.", 'default')
            ->addOption('sort', 's', Option::VALUE_OPTIONAL, 'order by rule name.', 0)
            ->addOption('more', 'm', Option::VALUE_NONE, 'show route options.')
            ->setDescription('show route list.');
    }

    protected function execute(Input $input, Output $output)
    {
        $app = $input->getArgument('app');

        if (App::isMulti() && $app) {
            $filename = App::getRootPath() . 'runtime' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . 'route_list_' . $app . '.php';
        } else {
            $filename = App::getRuntimePath() . 'route_list.php';
        }

        if (is_file($filename)) {
            unlink($filename);
        }

        $content = $this->getRouteList($app);
        file_put_contents($filename, 'Route List' . PHP_EOL . $content);
    }

    protected function getRouteList(string $app = null): string
    {
        Route::setTestMode(true);
        Route::clear();

        if (App::isMulti() && $app) {
            $path = App::getRootPath() . 'route' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR;
        } else {
            $path = App::getRootPath() . 'route' . DIRECTORY_SEPARATOR;
        }

        $files = is_dir($path) ? scandir($path) : [];

        foreach ($files as $file) {
            if (strpos($file, '.php')) {
                include $path . $file;
            }
        }

        if (Container::pull('config')->get('route.route_annotation')) {
            include Container::pull('build')->buildRoute();
        }

        $table = new Table();

        if ($this->input->hasOption('more')) {
            $header = ['Rule', 'Route', 'Method', 'Name', 'Domain', 'Option', 'Pattern'];
        } else {
            $header = ['Rule', 'Route', 'Method', 'Name', 'Domain'];
        }

        $table->setHeader($header);

        $routeList = Route::getRuleList();
        $rows      = [];

        foreach ($routeList as $domain => $items) {
            foreach ($items as $item) {
                $item['route'] = $item['route'] instanceof \Closure ? '<Closure>' : $item['route'];

                if ($this->input->hasOption('more')) {
                    $item = [$item['rule'], $item['route'], $item['method'], $item['name'], $domain, json_encode($item['option']), json_encode($item['pattern'])];
                } else {
                    $item = [$item['rule'], $item['route'], $item['method'], $item['name'], $domain];
                }

                $rows[] = $item;
            }
        }

        if ($this->input->getOption('sort')) {
            $sort = $this->input->getOption('sort');

            if (isset($this->sortBy[$sort])) {
                $sort = $this->sortBy[$sort];
            }

            uasort($rows, function ($a, $b) use ($sort) {
                $itemA = $a[$sort] ?? null;
                $itemB = $b[$sort] ?? null;

                return strcasecmp($itemA, $itemB);
            });
        }

        $table->setRows($rows);

        if ($this->input->getArgument('style')) {
            $style = $this->input->getArgument('style');
            $table->setStyle($style);
        }

        return $this->table($table);
    }

}
