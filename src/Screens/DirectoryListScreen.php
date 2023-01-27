<?php

namespace AdminKit\Directories\Screens;

use AdminKit\Directories\Directories;
use AdminKit\Directories\Models\Directory;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class DirectoryListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'items' => Directory::query()
                ->filters()
                ->orderBy('type')
                ->orderBy('id', 'desc')
                ->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __(Directories::NAME_PLURAL);
    }

    public function permission(): ?iterable
    {
        return [
            Directories::PERMISSION,
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create'))
                ->icon('plus')
                ->route(Directories::ROUTE_CREATE),
        ];
    }

    public function layout(): iterable
    {
        $models = config('admin-kit.packages.directories.models');

        return [
            Layout::table('items', [
                // id
                TD::make('id', __('#'))
                    ->alignCenter()
                    ->width(50)
                    ->sort()
                    ->render(fn (Directory $item) => Link::make($item->id)->route(Directories::ROUTE_EDIT, $item->id)),

                // custom columns
                TD::make('type', __('Type'))
                    ->filter(Select::make()
                        ->options($models))
                    ->sort()
                    ->render(fn (Directory $item) => $models[$item->type] ?? ''),
                TD::make('name', __('Name'))
                    ->sort()
                    ->render(fn (Directory $item) => $item->name),

                // actions
                TD::make('edit', __('Actions'))
                    ->alignRight()
                    ->width(100)
                    ->render(function (Directory $item) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([
                                Link::make(__('Edit'))
                                    ->route(Directories::ROUTE_EDIT, $item->id)
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
        Alert::info(__('You have successfully deleted').' '.__(Directories::NAME));
    }
}
