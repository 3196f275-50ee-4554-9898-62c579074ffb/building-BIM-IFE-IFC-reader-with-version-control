<?php

namespace App\Http\Controllers;

use App\Models\FileVersion;
use Illuminate\Http\Request;

class FileVersionController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'project_id' => 'required|exists:projects,id',
        ]);

        $projectId = $request->input('project_id');
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $version = $this->getCurrentVersion($projectId, $originalName) + 1;

        $filePath = $file->storeAs('files/' . $projectId, $originalName . '_v' . $version);

        FileVersion::create([
            'project_id' => $projectId,
            'file_name' => $originalName,
            'file_path' => $filePath,
            'version' => $version,
        ]);

        return response()->json(['file_path' => $filePath], 201);
    }

    public function versions($projectId, $fileName)
    {
        $versions = FileVersion::where('project_id', $projectId)
            ->where('file_name', $fileName)
            ->orderBy('version', 'desc')
            ->get();

        return response()->json($versions);
    }

    public function projectFiles($projectId)
    {
        $files = FileVersion::where('project_id', $projectId)
            ->groupBy('file_name')
            ->get();

        return response()->json($files);
    }

    private function getCurrentVersion($projectId, $fileName)
    {
        return FileVersion::where('project_id', $projectId)
            ->where('file_name', $fileName)
            ->max('version') ?? 0;
    }
}
