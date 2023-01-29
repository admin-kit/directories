<?php

namespace AdminKit\Directories\Screens;

use AdminKit\Directories\Directories;
use AdminKit\Directories\Models\Directory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class DirectoryEditScreen extends Screen
{
    public Directory $item;

    public function query(Directory $item): iterable
    {
        return [
            'item' => $item,
        ];
    }

    public function name(): ?string
    {
        return $this->item->exists
            ? __('Edit').' '.__(Directories::NAME).' #'.$this->item->id
            : __('Create').' '.__(Directories::NAME);
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
            Button::make(__('Save'))
                ->icon('check')
                ->method('save')
                ->canSee(! $this->item->exists),

            Button::make(__('Update'))
                ->icon('note')
                ->method('save')
                ->canSee($this->item->exists),

            Button::make(__('Remove'))
                ->icon('trash')
                ->method('remove')
                ->canSee($this->item->exists)
                ->confirm(__("Are you sure you want to delete entry #{$this->item->id}?")),
        ];
    }

    public function layout(): iterable
    {
        $defaultLocale = Lang::getLocale();
        $locales = config('admin-kit.locales');
        $models = config('admin-kit.packages.directories.models');

        $tabs = [];
        foreach ($locales as $locale) {
            $tabs[$locale] = [
                Layout::rows([
                    Input::make("name[$locale]")
                        ->title(__('Name')." ($locale)")
                        ->required($locale === $defaultLocale)
                        ->value($this->item->getTranslation('name', $locale)),
                ]),
            ];
        }

        $properties = [];
        foreach (config('admin-kit.packages.directories.properties') ?? [] as $property) {
            $properties[] = Input::make('properties['.$property['key'].']')
                ->title(__($property['name']))
                ->required($property['required'])
                ->value($this->item->getProperty($property['key']));
        }

        return [
            Layout::tabs($tabs),
            Layout::rows([
                Select::make('type')
                    ->options($models)
                    ->title(__('Type'))
                    ->required()
                    ->value($this->item->type),
                ...$properties,
            ]),
        ];
    }

    public function save(Directory $item, Request $request): RedirectResponse
    {
        // validate
        $defaultLocale = Lang::getLocale();
        $locales = implode(',', config('admin-kit.locales'));
        $validated = $request->validate([
            'type' => ['required', 'string', 'max:20'],
            'name' => ['required', "array:$locales"],
            "name.$defaultLocale" => ['required', 'string', 'max:255'],
            'properties' => ['nullable', 'array'],
        ]);

        $item->fill($validated)->save();
        Alert::info(__('You have successfully saved').' '.__(Directories::NAME));

        return redirect()->route(Directories::ROUTE_LIST);
    }

    public function remove(Directory $item): RedirectResponse
    {
        $item->delete();
        Alert::info(__('You have successfully deleted').' '.__(Directories::NAME));

        return redirect()->route(Directories::ROUTE_LIST);
    }
}
