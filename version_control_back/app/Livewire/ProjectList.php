<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;

class ProjectList extends Component
{
    protected $listeners = ['projectAdded' => 'render'];

    public function render()
    {
        $projects = Project::all();

        return view('livewire.project-list', compact('projects'));
    }
}
