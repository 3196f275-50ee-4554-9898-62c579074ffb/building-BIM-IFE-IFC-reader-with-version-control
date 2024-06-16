<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;

class ProjectForm extends Component
{
    public $name;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function submit()
    {
        $this->validate();

        Project::create([
            'name' => $this->name,
        ]);


        $this->reset('name');

        $this->dispatch('projectAdded');
    }

    public function render()
    {
        return view('livewire.project-form');
    }
}
