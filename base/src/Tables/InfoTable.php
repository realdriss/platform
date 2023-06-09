<?php

namespace RealDriss\Base\Tables;

use RealDriss\Base\Supports\SystemManagement;
use RealDriss\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTables;

class InfoTable extends TableAbstract
{
    /**
     * @var string
     */
    protected $view = 'core/table::simple-table';

    /**
     * @var bool
     */
    protected $hasCheckbox = false;

    /**
     * @var bool
     */
    protected $hasOperations = false;

    /**
     * {@inheritDoc}
     */
    public function ajax()
    {
        return $this->toJson($this->table
            ->of($this->query())
            ->editColumn('name', function ($item) {
                return view('core/base::system.partials.info-package-line', compact('item'))->render();
            })
            ->editColumn('dependencies', function ($item) {
                return view('core/base::system.partials.info-dependencies-line', compact('item'))->render();
            }));
    }

    /**
     * @return Collection
     * @throws FileNotFoundException
     */
    public function query()
    {
        $composerArray = SystemManagement::getComposerArray();
        $packages = SystemManagement::getPackagesAndDependencies($composerArray['require']);

        return collect($packages);
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'name'         => [
                'name'  => 'name',
                'title' => trans('core/base::system.package_name') . ' : ' . trans('core/base::system.version'),
                'class' => 'text-left',
            ],
            'dependencies' => [
                'name'  => 'dependencies',
                'title' => trans('core/base::system.dependency_name') . ' : ' . trans('core/base::system.version'),
                'class' => 'text-left',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    protected function getDom(): ?string
    {
        return "rt<'datatables__info_wrap'pli<'clearfix'>>";
    }

    /**
     * {@inheritDoc}
     */
    public function getBuilderParameters(): array
    {
        return [
            'stateSave' => true,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        return [];
    }
}
