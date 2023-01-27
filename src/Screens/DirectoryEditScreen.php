<?php

namespace AdminKit\Directories\Screens;

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

    protected array $types;

    protected string $name;

    protected string $routeList;

    public function __construct()
    {
        $this->name = __('Directory');
        $this->types = config('admin-kit.packages.directories.models');
        $this->routeList = config('admin-kit.packages.directories.route_list');
    }

    public function query(Directory $item): iterable
    {
        return [
            'item' => $item,
        ];
    }

    public function name(): ?string
    {
        return $this->item->exists ? __('Edit')." $this->name #{$this->item->id}" : __('Create')." $this->name";
    }

    public function permission(): ?iterable
    {
        return [
            'admin-kit.directories',
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

        return [
            Layout::rows([
                Select::make('type')
                    ->options($this->types)
                    ->title(__('Type'))
                    ->required()
                    ->value($this->item->type),
            ]),
            Layout::tabs($tabs),
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
        ]);

        $item->fill($validated)->save();
        Alert::info(__('You have successfully saved').' '.$this->name);

        return redirect()->route($this->routeList);
    }

    public function remove(Directory $item): RedirectResponse
    {
        $item->delete();
        Alert::info(__('You have successfully deleted').' '.$this->name);

        return redirect()->route($this->routeList);
    }
}
