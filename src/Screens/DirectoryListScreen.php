<?php

namespace AdminKit\Directories\Screens;

use AdminKit\Directories\Models\Directory;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class DirectoryListScreen extends Screen
{
    protected string $name;

    protected string $namePlural;

    protected array $types;

    protected string $routeEdit;

    protected string $routeCreate;

    public function __construct()
    {
        $this->name = __('Directory');
        $this->namePlural = __('Directories');
        $this->types = config('admin-kit.packages.directories.models');
        $this->routeEdit = config('admin-kit.packages.directories.route_edit');
        $this->routeCreate = config('admin-kit.packages.directories.route_create');
    }

    public function query(): iterable
    {
        return [
            'items' => Directory::orderByDesc('id')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return $this->namePlural;
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create'))
                ->icon('plus')
                ->route($this->routeCreate),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('items', [
                // id
                TD::make('id', __('#'))
                    ->alignCenter()
                    ->width(50)
                    ->render(fn (Directory $item) => Link::make($item->id)->route($this->routeEdit, $item->id)),

                // custom columns
                TD::make('type', __('Type'))->render(fn (Directory $item) => $this->types[$item->type] ?? ''),
                TD::make('name', __('Name'))->render(fn (Directory $item) => $item->name),

                // actions
                TD::make('edit', __('Actions'))
                    ->alignRight()
                    ->width(100)
                    ->render(function (Directory $item) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([
                                Link::make(__('Edit'))
                                    ->route($this->routeEdit, $item->id)
                                    ->icon('pencil'),
                                Button::make(__('Delete'))
                                    ->method('remove')
                                    ->icon('trash')
                                    ->confirm(__("Are you sure you want to delete entry #$item->id?"))
                                    ->parameters(['id' => $item->id]),
                            ]);
                    }),
            ]),
        ];
    }

    public function remove(Directory $item): void
    {
        $item->delete();
        Alert::info(__('You have successfully deleted').' '.$this->name);
    }
}
