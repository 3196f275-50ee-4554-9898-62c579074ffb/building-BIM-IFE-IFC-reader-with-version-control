<?php

namespace App\Livewire;

use App\Models\FileVersion;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectFiles extends Component
{

    use WithFileUploads;

    public $project;
    public $file;
    public $fileName;
    public $versions;

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->versions = [];
    }

    public function uploadFile()
    {
        $this->validate([
            'file' => 'required|file|max:124000',
        ]);

        $originalName = $this->file->getClientOriginalName();
        $version = $this->getCurrentVersion($this->project->id, $originalName) + 1;
        $filePath = $this->file->storeAs('files/' . $this->project->id, $originalName . '_v' . $version);

        FileVersion::create([
            'project_id' => $this->project->id,
            'file_name' => $originalName,
            'file_path' => $filePath,
            'version' => $version,
        ]);

        $this->file = null;
        $this->loadVersions();
    }

    public function loadVersions()
    {
        $fileVersions = FileVersion::select('file_name', DB::raw('MAX(id) as id'))
            ->where('project_id', $this->project->id)
            ->groupBy('file_name')
            ->get();

        $this->versions = FileVersion::whereIn('id', $fileVersions->pluck('id'))->get();
    }

    public function showFileVersions($fileName)
    {
        $this->fileName = $fileName;
        $this->versions = FileVersion::where('project_id', $this->project->id)
            ->where('file_name', $fileName)
            ->orderBy('version', 'desc')
            ->get();
    }

    private function getCurrentVersion($projectId, $fileName)
    {
        return FileVersion::where('project_id', $projectId)
            ->where('file_name', $fileName)
            ->max('version') ?? 0;
    }

    public function render()
    {
        $files = FileVersion::select('file_name', DB::raw('MAX(version) as latest_version'))
            ->where('project_id', $this->project->id)
            ->groupBy('file_name')
            ->get();

        return view('livewire.project-files', [
            'files' => $files,
        ]);
    }
}
